<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ReportZkteco
{

    protected $filters;
    protected $baseTable;

    public function __construct(string $baseTable, array $filters = [])
    {
        $this->baseTable = $baseTable;
        $this->filters = $filters;
    }

    public function generateReport(string $reportType, bool $export = false)
    {
        switch ($reportType) {
            case 'LoanBook':
                return $this->generateLoanBook($export);
            case 'LoanListing':
                return $this->generateLoanListing($export);
            case 'LoanAnalysis':
                return $this->generateLoanAnalysis($export);
            case 'Repayments':
                return $this->generateRepayments($export);
            case 'InstallmentsFailingDue':
                return $this->generateInstallmentsFailingDue($export);
            case 'InstallmentsInArrears':
                return $this->generateInstallmentsInArrears($export);
            case 'DaysCollections':
                return $this->generateDaysCollections($export);
            case 'Disbursements':
                return $this->generateDisbursements($export);
            case 'Fees':
                return $this->generateProcessingFees($export);
            case 'MissedCollections':
                return $this->generateMissedCollections($export);
            case 'PortfolioAtRisk':
                return $this->generatePortfolioAtRisk($export);
            case 'CollateralRegister':
                return $this->generateCollateralRegister($export);
            case 'CollectionSheets':
                return $this->generateCollectionSheets($export);


            case 'LoanTable':
                return $this->generateLoanTable($export);
            default:
                throw new \InvalidArgumentException("Invalid report type: {$reportType}");
        }
    }

    protected function applyFilters($query, $dueDate = false)
    {
        $filterMappings = [
            'officer_id' => 'officer_id',
            'client_id' => 'client_id',
            'branch_id' => 'branch_id',
            'loan_type_id' => 'loan_type_id',
            'status' => 'status',
            'start_date' => 'created_at',
            'end_date' => 'created_at',
        ];

        if ($this->baseTable == 'loans') {
            if ($dueDate) {
                $filterMappings['start_date'] = 'due_date';
                $filterMappings['end_date'] = 'due_date';
            } else {

                $filterMappings['start_date'] = 'application_date';
                $filterMappings['end_date'] = 'application_date';
            }
        } elseif ($this->baseTable == 'payments') {
            $filterMappings['start_date'] = 'date';
            $filterMappings['end_date'] = 'date';
        }


        foreach ($this->filters as $key => $value) {
            if (!empty($value)) {
                $column = $filterMappings[$key] ?? $key;
                $fullColumnName = "{$this->baseTable}.{$column}";

                if (is_array($value)) {
                    $query->whereIn($fullColumnName, $value);
                } elseif ($key === 'start_date') {
                    $query->where($fullColumnName, '>=', Carbon::parse($value)->startOfDay());
                } elseif ($key === 'end_date') {
                    $query->where($fullColumnName, '<=', Carbon::parse($value)->endOfDay());
                } else {
                    $query->where($fullColumnName, $value);
                }
            }
        }



        return $query;
    }


    protected function generateLoanTable($export = false)
    {

        $query = DB::table('loans');
        $query = $this->applyFilters($query);

        $query->select(
            'loans.id',
            'loans.reference as loan_id',
            'clients.name as client_name',
            'clients.phone as client_phone',
            'clients.id_no as id_number',
            'loans.due_date',
            'loans.balance as total_due',
            'loans.amount',
            'loans.status',
            'loans.disbursed_at',
            DB::raw('DATEDIFF(NOW(), loans.due_date) as days_in_arrears'),
            DB::raw('DATEDIFF(NOW(), loans.last_payment) as days_since_payment'),
            DB::raw('loans.balance - loans.amount as amount_in_arrears')
        )
            ->join('clients', 'loans.client_id', '=', 'clients.id')
            // ->where('loans.status', '!=', 'Paid')
            // ->where('loans.due_date', '<', Carbon::now())
            ->orderBy('days_in_arrears', 'desc');

        return $this->transformData($query, $export);
    }


    protected function generateLoanBook($export = false)
    {
        $query = DB::table('loans');
        $query = $this->applyFilters($query);

        $query->select(
            'loans.id',
            'clients.name as client_name',
            'loan_types.name as loan_type',
            'loans.reference',
            'loans.amount',
            'loans.status',
            'loans.disbursed_at',
            'loans.due_date as next_payment_date'
        )
            ->join('clients', 'loans.client_id', '=', 'clients.id')
            ->join('loan_types', 'loans.loan_type_id', '=', 'loan_types.id');

        return $this->transformData($query, $export);
    }

    protected function generateLoanListing($export = false)
    {
        $query = DB::table('loans');
        $query = $this->applyFilters($query);

        $query->select(
            'loans.id',
            'loans.reference',
            'clients.name as client_name',
            'loan_types.name as loan_type',
            'loans.amount',
            'loans.status',
            'loans.application_date'
        )
            ->join('clients', 'loans.client_id', '=', 'clients.id')
            ->join('loan_types', 'loans.loan_type_id', '=', 'loan_types.id')
            ->orderBy('loans.created_at', 'desc');

        return $this->transformData($query, $export);
    }


    protected function generatePortfolioAtRisk($export = false)
    {
        $query = DB::table('loans');
        $query = $this->applyFilters($query);

        $riskThreshold = 30; // Days past due to be considered at risk

        $query->select(
            'loans.id',
            'loans.reference',
            'clients.name as client_name',
            'loans.amount',
            'loans.status',
            'loans.created_at'
        )
            ->where('loans.due_date', '<=', Carbon::now()->subDays($riskThreshold))
            ->where('loans.status', 'Disbursed')
            ->join('clients', 'loans.client_id', '=', 'clients.id');
        return $this->transformData($query, $export);
    }

    protected function generateCollateralRegister($export = false)
    {
        $query = DB::table('collaterals');
        $query = $this->applyFilters($query);

        return $query->select(
            'collaterals.id',
            'clients.name as client_name',
            'loans.id as loan_id',
            'collaterals.type',
            'collaterals.value',
            'collaterals.description'
        )
            ->join('loans', 'collaterals.loan_id', '=', 'loans.id')
            ->join('clients', 'loans.client_id', '=', 'clients.id');

        return $this->transformData($query, $export);
    }

    protected function generateCollectionSheets($export = false)
    {
        $query = DB::table('loans');
        $query = $this->applyFilters($query);

        $query->select(
            'loans.id',
            'clients.name as client_name',
            'loans.reference as loan_id',
            'loans.due_date',
            'loans.balance',
            'loans.status'
        )
            ->join('clients', 'loans.client_id', '=', 'clients.id')
            ->where('loans.due_date', '>=', Carbon::now()->startOfDay())
            ->where('loans.balance', '>', 0)
            ->orderBy('loans.due_date');

        return $this->transformData($query, $export);
    }


    protected function generateLoanAnalysis($export = false)
    {
        // Apply filters if necessary
        $query = DB::table('loans');
        $query = $this->applyFilters($query); // Assuming you have a method to apply filters
        // Query for the loan data, grouped by officer_id
        $loans = $query->select(
            'officer_id',
            DB::raw('count(id) as nol'), // Number of loans (NOL)
            DB::raw('sum(amount) as principal'), // Principal (P)
            DB::raw('sum(interest_rate * amount / 100) as interest'), // Interest (I)

            // Summing the amounts in various overdue ranges
            DB::raw('sum(IF(DATEDIFF(CURDATE(), due_date) <= 0, amount, 0)) as ontime'), // On-time
            DB::raw('sum(IF(DATEDIFF(CURDATE(), due_date) BETWEEN 1 AND 30, amount, 0)) as overdue_1_30'), // 1-30 days overdue
            DB::raw('sum(IF(DATEDIFF(CURDATE(), due_date) BETWEEN 31 AND 60, amount, 0)) as overdue_31_60'), // 31-60 days overdue
            DB::raw('sum(IF(DATEDIFF(CURDATE(), due_date) BETWEEN 61 AND 90, amount, 0)) as overdue_61_90'), // 61-90 days overdue
            DB::raw('sum(IF(DATEDIFF(CURDATE(), due_date) BETWEEN 91 AND 180, amount, 0)) as overdue_91_180'), // 91-180 days overdue
            DB::raw('sum(IF(DATEDIFF(CURDATE(), due_date) > 180, amount, 0)) as overdue_180_plus'), // Over 180 days overdue

            // Counting the number of loans in various overdue ranges
            DB::raw('count(IF(DATEDIFF(CURDATE(), due_date) <= 0, id, NULL)) as ontime_count'), // On-time
            DB::raw('count(IF(DATEDIFF(CURDATE(), due_date) BETWEEN 1 AND 30, id, NULL)) as overdue_1_30_count'), // 1-30 days overdue
            DB::raw('count(IF(DATEDIFF(CURDATE(), due_date) BETWEEN 31 AND 60, id, NULL)) as overdue_31_60_count'), // 31-60 days overdue
            DB::raw('count(IF(DATEDIFF(CURDATE(), due_date) BETWEEN 61 AND 90, id, NULL)) as overdue_61_90_count'), // 61-90 days overdue
            DB::raw('count(IF(DATEDIFF(CURDATE(), due_date) BETWEEN 91 AND 180, id, NULL)) as overdue_91_180_count'), // 91-180 days overdue
            DB::raw('count(IF(DATEDIFF(CURDATE(), due_date) > 180, id, NULL)) as overdue_180_plus_count') // Over 180 days overdue
        )
            ->groupBy('officer_id')
            ->get();


        $item = [
            "principal" => 0,
            "interest" => 0,
            "ontime" => 0,
            "overdue_1_30" => 0,
            "overdue_31_60" => 0,
            "overdue_61_90" => 0,
            "overdue_91_180" => 0,
            "overdue_180_plus" => 0,
            "ontime_count" => 0,
            "overdue_1_30_count" => 0,
            "overdue_31_60_count" => 0,
            "overdue_61_90_count" => 0,
            "overdue_91_180_count" => 0,
            "overdue_180_plus_count" => 0,
        ];

        foreach ($loans as $key => $loan) {
            $item['principal'] += $loan->principal;
            $item['interest'] += $loan->interest;
            $item['ontime'] += $loan->ontime;
            $item['overdue_1_30'] += $loan->overdue_1_30;
            $item['overdue_31_60'] += $loan->overdue_31_60;
            $item['overdue_61_90'] += $loan->overdue_61_90;
            $item['overdue_91_180'] += $loan->overdue_91_180;
            $item['overdue_180_plus'] += $loan->overdue_180_plus;
            $item['ontime_count'] += $loan->ontime_count;
            $item['overdue_1_30_count'] += $loan->overdue_1_30_count;
            $item['overdue_31_60_count'] += $loan->overdue_31_60_count;
            $item['overdue_61_90_count'] += $loan->overdue_61_90_count;
            $item['overdue_91_180_count'] += $loan->overdue_91_180_count;
            $item['overdue_180_plus_count'] += $loan->overdue_180_plus_count;
        }

        // Fetch officer names if available
        $officers = User::whereIn('id', $loans->pluck('officer_id'))->get()->keyBy('id');

        // Map through the loans and format the data for each loan officer
        $report = $loans->map(function ($data) use ($officers) {
            return [
                'loan_officer' => $officers->get($data->officer_id)->name ?? 'Officer ' . $data->officer_id,
                'nol' => $data->nol,
                'principal' => number_format($data->principal, 2),
                'interest' => number_format($data->interest, 2),
                'ontime' => [
                    'amount' => number_format($data->ontime, 2),
                    'percentage' => $this->calculatePercentage($data->ontime, $data->principal),
                    'count' => $data->ontime_count,
                ],
                'overdue_1_30' => [
                    'amount' => number_format($data->overdue_1_30, 2),
                    'percentage' => $this->calculatePercentage($data->overdue_1_30, $data->principal),
                    'count' => $data->overdue_1_30_count,
                ],
                'overdue_31_60' => [
                    'amount' => number_format($data->overdue_31_60, 2),
                    'percentage' => $this->calculatePercentage($data->overdue_31_60, $data->principal),
                    'count' => $data->overdue_31_60_count,
                ],
                'overdue_61_90' => [
                    'amount' => number_format($data->overdue_61_90, 2),
                    'percentage' => $this->calculatePercentage($data->overdue_61_90, $data->principal),
                    'count' => $data->overdue_61_90_count,
                ],
                'overdue_91_180' => [
                    'amount' => number_format($data->overdue_91_180, 2),
                    'percentage' => $this->calculatePercentage($data->overdue_91_180, $data->principal),
                    'count' => $data->overdue_91_180_count,
                ],
                'overdue_180_plus' => [
                    'amount' => number_format($data->overdue_180_plus, 2),
                    'percentage' => $this->calculatePercentage($data->overdue_180_plus, $data->principal),
                    'count' => $data->overdue_180_plus_count,
                ],
            ];
        });

        // If exporting data, handle the transformation/export logic
        // if ($export) {
        //     return $this->transformData($report, $export);
        // }

        // Return the report data
        return ['report' => $report, 'item' => $item];
    }


    protected function generateRepayments($export = false)
    {
        $query = DB::table('payments');
        $query = $this->applyFilters($query);

        $query->select(
            'payments.reference',
            'payments.date as payment_date',
            'payments.id',
            'payments.repayment_amount as amount_paid',
            'payments.method',
            'payments.payment_code',
            'loans.reference as loan_id',
            'clients.name as client_name',
            'branches.name as branch_name',
            'loans.balance',
            'loans.status as loan_status'
        )
            ->join('loans', 'payments.loan_id', '=', 'loans.id')
            ->join('branches', 'loans.branch_id', '=', 'branches.id')
            ->join('clients', 'payments.client_id', '=', 'clients.id')
            ->orderBy('payments.date');

        return $this->transformData($query, $export);
    }

    public function generateInstallmentsFailingDue($export = false)
    {

        // $query = DB::table('payments');
        // $query = $this->applyFilters($query);

        $query = DB::table('loans');
        $query = $this->applyFilters($query, true);

        $query->select(
            'loans.id',
            'loans.due_date',
            'loans.reference',
            'clients.name as client_name',
            'users.name as loan_officer',
            'loan_types.name as loan_type',
            'branches.name as branch',
            'loans.amount',
            // DB::raw('DATEDIFF(NOW(), loans.due_date) as days_overdue')
        )
            ->join('clients', 'loans.client_id', '=', 'clients.id')
            ->join('loan_types', 'loans.loan_type_id', '=', 'loan_types.id')
            ->join('branches', 'loans.branch_id', '=', 'branches.id')
            ->join('users', 'loans.officer_id', '=', 'users.id')
            ->where('loans.status', '!=', 'Paid')
            // ->where('loans.due_date', '>', Carbon::now())
            ->orderBy('loans.due_date');

        return $this->transformData($query, $export);
    }

    protected function generateInstallmentsInArrears($export = false)
    {
        $query = DB::table('loans');
        $query = $this->applyFilters($query);

        $query->select(
            'loans.id',
            'loans.reference as loan_id',
            'clients.name as client_name',
            'clients.phone as client_phone',
            'clients.id_no as id_number',
            'loans.due_date',
            'loans.balance as total_due',
            'loans.amount',
            'loans.status',
            'loans.disbursed_at',
            DB::raw('DATEDIFF(NOW(), loans.due_date) as days_in_arrears'),
            DB::raw('DATEDIFF(NOW(), loans.last_payment) as days_since_payment'),
            DB::raw('loans.balance - loans.amount as amount_in_arrears')
        )
            ->join('clients', 'loans.client_id', '=', 'clients.id')
            ->where('loans.status', '!=', 'Paid')
            ->where('loans.due_date', '<', Carbon::now())
            ->orderBy('days_in_arrears', 'desc');

        return $this->transformData($query, $export);
    }

    protected function generateDaysCollections($export = false)
    {
        $query = DB::table('payments');
        $query = $this->applyFilters($query);

        $query->select(
            DB::raw('DATE(payments.date) as collection_date'),
            DB::raw('COUNT(*) as total_collections'),
            DB::raw('SUM(payments.repayment_amount) as total_amount_collected')
        )
            // ->where('payments.status', 'Paid')
            ->groupBy('collection_date')
            ->orderBy('collection_date', 'desc');

        return $this->transformData($query, $export);
    }

    protected function generateDisbursements($export = false)
    {
        $query = DB::table('loans');
        $query = $this->applyFilters($query);

        $query->select(
            'loans.id',
            'loans.reference',
            'loans.application_date',
            'clients.name as client_name',
            'loans.amount',
            'loans.disbursed_at',
            'loan_types.name as loan_type',
            'loans.status',
            'users.name as loan_officer'
        )
            ->join('clients', 'loans.client_id', '=', 'clients.id')
            ->join('loan_types', 'loans.loan_type_id', '=', 'loan_types.id')
            ->join('users', 'loans.officer_id', '=', 'users.id')
            // ->where('loans.status', 'Disbursed')
            ->orderBy('loans.disbursed_at', 'desc');

        return $this->transformData($query, $export);
    }

    protected function generateProcessingFees($export = false)
    {
        $query = DB::table('loans');
        $query = $this->applyFilters($query);

        $query->select(
            'loans.id',
            'loans.reference',
            'clients.name as client_name',
            'loans.processing_fee',
            'loans.created_at',
            'loans.processing_fee_status as status'
        )
            ->join('clients', 'loans.client_id', '=', 'clients.id')
            ->where('loans.processing_fee_paid', true)
            ->orderBy('loans.created_at', 'desc');

        return $this->transformData($query, $export);
    }

    protected function generateMissedCollections($export = false)
    {
        $query = DB::table('loans');
        $query = $this->applyFilters($query);

        $query->select(
            'loans.id',
            'loans.id as loan_id',
            'clients.name as client_name',
            'loans.due_date',
            'loans.payment_per_installment as principle',
            'loans.balance',
            DB::raw('DATEDIFF(NOW(), loans.due_date) as days_missed')
        )
            ->join('clients', 'loans.client_id', '=', 'clients.id')
            ->where('loans.status', '!=', 'Paid')
            ->where('loans.due_date', '<', Carbon::now())
            ->orderBy('days_missed', 'desc');

        return $this->transformData($query, $export);
    }


    public function transformData($query, $export)
    {

        $headers = [];
        if ($export) {

            $paginatedData = $query->get();
            // return ['data' => $paginatedData, 'headers' => $headers];
        } else {
            $paginatedData = $query->paginate();
        }


        // Check if the input is a Laravel paginator instance
        if ($paginatedData instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $data = $paginatedData->items();
        } else {
            $data = $paginatedData;
        }

        if (empty($data) || empty($data[0])) {
            return [];
        }

        // Ensure you're working with only the public attributes
        $firstItem = $data[0] instanceof \Illuminate\Database\Eloquent\Model ? $data[0]->toArray() : (array)$data[0];

        $headers = [];

        foreach (array_keys($firstItem) as $key) {
            // Skip the 'inventories' key if it's an empty array
            if ($key === 'client' || $key === 'location' || $key === 'id' || $key === 'inventories' || $key === 'movements') {
                continue;
            }

            $headers[] = [
                'title' => ucwords(str_replace('_', ' ', $key)),
                'key' => $key,
            ];
        }

        return ['data' => $data, 'headers' => $headers];
    }


    private function calculatePercentage($amount, $total)
    {
        return $total > 0 ? round(($amount / $total) * 100, 2) : 0;
    }
}
