<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZKTecoService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = config('zkteco.base_url');
        $this->authenticate();
    }

    /**
     * Authenticate and retrieve a JWT token.
     */
    protected function authenticate()
    {
        $response = Http::post("{$this->baseUrl}/jwt-api-token-auth/", [
            'username' => config('zkteco.username'),
            'password' => config('zkteco.password'),
        ]);

        if ($response->successful()) {
            $this->token = $response->json('token');

            // Log::alert($this->token);
        } else {
            throw new \Exception('Authentication failed.');
        }
    }
    /**
     * Get a list of areas.
     *
     * @return array
     */
    public function getAreas($queryParams = [], $perPage = 150, $page = 1)
    {
        $response = Http::withToken($this->token)->get("{$this->baseUrl}/personnel/api/areas/");
        // return $response->successful() ? $response->json() : $this->handleError($response);


        if ($response->successful()) {
            $transactions = $response->json('data');
            $total = $response->json('count');  // Assuming API returns the total count of transactions

            // Create a LengthAwarePaginator instance to paginate the data
            return new LengthAwarePaginator(
                array_slice($transactions, ($page - 1) * $perPage, $perPage), // Slice the data for current page
                $total, // Total number of items (count from API)
                $perPage, // Items per page
                $page, // Current page
                ['path' => url()->current()] // For pagination links
            );
        } else {
            $this->handleError($response);
        }
    }

    /**
     * Create a new area.
     *
     * @param  array  $data
     * @return array
     */
    public function createArea(array $data)
    {
        $response = Http::withToken($this->token)->post("{$this->baseUrl}/personnel/api/areas/", $data);
        return $response->successful() ? $response->json() : $this->handleError($response);
    }

    public function getAreaData($queryParams = [], $perPage = 150, $page = 1)
    {
        $response = Http::withToken($this->token)->get("{$this->baseUrl}/personnel/api/areas/");

        if ($response->successful()) {
            $transactions = $response->json('data');

            // Modify the array to only include 'id', 'label', and 'value'
            $transactions = array_map(function ($employee) {
                return [
                    'id' => $employee['id'],
                    'area_code' => $employee['area_code'],
                    'label' => $employee['area_name'],
                    'value' => $employee['area_code']
                ];
            }, $transactions);
        }

        return $transactions;
    }

    public function getDepartmentData($queryParams = [], $perPage = 150, $page = 1)
    {
        $response = Http::withToken($this->token)->get("{$this->baseUrl}/personnel/api/departments/");

        if ($response->successful()) {
            $transactions = $response->json('data');

            // Modify the array to only include 'id', 'label', and 'value'
            $transactions = array_map(function ($employee) {
                return [
                    'id' => $employee['dept_code'],
                    'dept_code' => $employee['dept_code'],
                    'name' => $employee['dept_name'],
                    'label' => $employee['dept_name'],
                    'value' => $employee['dept_code']
                ];
            }, $transactions);
        }

        return $transactions;
    }


    public function getEmployeeData($queryParams = [], $perPage = 150, $page = 1)
    {
        $response = Http::withToken($this->token)->get("{$this->baseUrl}/personnel/api/employees/");

        if ($response->successful()) {
            $transactions = $response->json('data');

            // Modify the array to only include 'id', 'label', and 'value'
            $transactions = array_map(function ($employee) {
                return [
                    'id' => $employee['emp_code'],
                    'emp_code' => $employee['id'],
                    'name' => $employee['first_name'] . ' ' . $employee['last_name'],
                    'label' => $employee['first_name'] . ' ' . $employee['last_name'],
                    'value' => $employee['emp_code']
                ];
            }, $transactions);
        }

        return $transactions;
    }

    /**
     * Get a list of employees.
     *
     * @return array
     */
    public function getEmployees($queryParams = [], $perPage = 150, $page = 1)
    {

        // return ['data' => []];
        $response = Http::withToken($this->token)->get("{$this->baseUrl}/personnel/api/employees/", $queryParams);
        // return $response->successful() ? $response->json() : $this->handleError($response);

        if ($response->successful()) {
            $transactions = $response->json('data');
            $total = $response->json('count');  // Assuming API returns the total count of transactions

            // Create a LengthAwarePaginator instance to paginate the data
            return new LengthAwarePaginator(
                array_slice($transactions, ($page - 1) * $perPage, $perPage), // Slice the data for current page
                $total, // Total number of items (count from API)
                $perPage, // Items per page
                $page, // Current page
                ['path' => url()->current()] // For pagination links
            );
        } else {
            $this->handleError($response);
        }
    }


    public function getDepartments($queryParams = [], $perPage = 150, $page = 1)
    {
        // return ['data' => []];
        $response = Http::withToken($this->token)->get("{$this->baseUrl}/personnel/api/departments/");
        // return $response->successful() ? $response->json() : $this->handleError($response);

        if ($response->successful()) {
            $transactions = $response->json('data');
            $total = $response->json('count');  // Assuming API returns the total count of transactions

            // Create a LengthAwarePaginator instance to paginate the data
            return new LengthAwarePaginator(
                array_slice($transactions, ($page - 1) * $perPage, $perPage), // Slice the data for current page
                $total, // Total number of items (count from API)
                $perPage, // Items per page
                $page, // Current page
                ['path' => url()->current()] // For pagination links
            );
        } else {
            $this->handleError($response);
        }
    }

    /**
     * Create a new employee.
     *
     * @param  array  $data
     * @return array
     */
    public function createEmployee(array $data)
    {
        try {
            $response = Http::withToken($this->token)->post("{$this->baseUrl}/personnel/api/employees/", $data);
            return $response->successful() ? $response->json() : $this->handleError($response);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function syncEmployee(array $data)
    {
        try {
            $response = Http::withToken($this->token)->post("{$this->baseUrl}/personnel/api/employees/resync_to_device/", $data);
            return $response->successful() ? $response->json() : $this->handleError($response);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteBio(array $data)
    {
        try {
            $response = Http::withToken($this->token)->post("{$this->baseUrl}/personnel/api/employees/del_bio_template/", $data);
            return $response->successful() ? $response->json() : $this->handleError($response);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Get attendance records.
     *
     * @param  array  $queryParams
     * @return array
     */
    public function getAttendanceRecords($queryParams = [], $perPage = 150, $page = 1)
    {
        $allTransactions = [];
        $nextUrl = null;

        // Make initial request with query parameters
        $response = Http::withToken($this->token)
            ->get("{$this->baseUrl}/iclock/api/transactions/", $queryParams);

        if (!$response->successful()) {
            $this->handleError($response);
            return;
        }

        // Process first page
        $responseData = $response->json();
        $allTransactions = $responseData['data'];
        $nextUrl = $responseData['next'];

        // Fetch remaining pages if they exist
        while ($nextUrl) {
            $response = Http::withToken($this->token)->get($nextUrl);

            if (!$response->successful()) {
                break;
            }

            $responseData = $response->json();
            $allTransactions = array_merge($allTransactions, $responseData['data']);
            $nextUrl = $responseData['next'];
        }

        Log::info('Total records fetched', ['count' => count($allTransactions)]);

        $processedData = [];

        // Group transactions by employee and date
        $groupedTransactions = collect($allTransactions)->groupBy(function ($transaction) {
            $date = Carbon::parse($transaction['punch_time'])->format('Y-m-d');
            return $transaction['emp_code'] . '_' . $date;
        });

        foreach ($groupedTransactions as $key => $dayTransactions) {
            [$empCode, $date] = explode('_', $key);
            $dateCarbon = Carbon::parse($date);

            // Separate transactions into shifts
            $firstShiftTransactions = collect($dayTransactions)->filter(function ($transaction) {
                $time = Carbon::parse($transaction['punch_time'])->format('H:i');
                return $time >= '07:00' && $time <= '17:00';
            });

            $secondShiftTransactions = collect($dayTransactions)->filter(function ($transaction) {
                $time = Carbon::parse($transaction['punch_time'])->format('H:i');
                return $time >= '16:00' || $time <= '06:59';
            });

            $shifts = [
                ['transactions' => $firstShiftTransactions, 'name' => 'First Shift'],
                ['transactions' => $secondShiftTransactions, 'name' => 'Second Shift']
            ];

            foreach ($shifts as $shift) {
                $shiftTransactions = $shift['transactions'];
                $shiftName = $shift['name'];

                if ($shiftTransactions->isEmpty()) {
                    continue;
                }

                // Sort transactions for this shift by punch time
                $sortedTransactions = $shiftTransactions->sortBy('punch_time');

                // Get first and last punch of the shift
                $firstPunch = $sortedTransactions->first();
                $lastPunch = $sortedTransactions->last();

                $checkInTime = $firstPunch ? Carbon::parse($firstPunch['punch_time']) : null;
                $checkOutTime = ($lastPunch && $lastPunch['id'] !== $firstPunch['id'])
                    ? Carbon::parse($lastPunch['punch_time'])
                    : null;

                $workedHours = null;
                if ($checkInTime && $checkOutTime) {
                    $totalMinutes = $checkInTime->diffInMinutes($checkOutTime);
                    $hours = intdiv($totalMinutes, 60);
                    $minutes = $totalMinutes % 60;

                    if ($hours > 0) {
                        $workedHours = $hours . ' hr' . ($hours > 1 ? 's' : '') . ' ' . ($minutes > 0 ? $minutes . ' min' : '');
                    } else {
                        $workedHours = $minutes . ' min';
                    }
                }

                // Determine late status based on shift
                $lateThreshold = $shiftName === 'First Shift' ? '09:00' : '17:00';

                $checkinStatus = $checkInTime
                    ? ($checkInTime->format('H:i') <= $lateThreshold ? 'On time' : 'Late')
                    : 'Missing';

                $checkoutStatus = $checkOutTime
                    ? ($shiftName === 'First Shift'
                        ? ($checkOutTime->format('H:i') >= '17:00' ? 'On time' : 'Early')
                        : ($checkOutTime->format('H:i') >= '06:59' ? 'On time' : 'Early'))
                    : 'Missing';

                // Create single record for the shift
                $shiftRecord = [
                    'id' => $firstPunch['id'],
                    'emp_code' => $empCode,
                    'date' => $date,
                    'shift' => $shiftName,
                    'first_name' => $firstPunch['first_name'],
                    'last_name' => $firstPunch['last_name'],
                    'department' => $firstPunch['department'],
                    'position' => $firstPunch['position'],
                    'checkin_time' => $checkInTime ? $checkInTime->format('H:i:s') : null,
                    'checkout_time' => $checkOutTime ? $checkOutTime->format('H:i:s') : null,
                    'status' => $checkInTime ? ($checkOutTime ? 'Out' : 'In') : 'Absent',
                    'checkin_status' => $checkinStatus,
                    'checkout_status' => $checkoutStatus,
                    'worked_hours' => $workedHours,
                ];

                $processedData[] = $shiftRecord;
            }
        }

        // Sort the processed data by date
        $processedData = collect($processedData)
            ->sortByDesc('date')
            ->values()
            ->all();

        Log::info('Processed records', ['count' => count($processedData)]);

        // Paginate the results
        return new LengthAwarePaginator(
            array_slice($processedData, ($page - 1) * $perPage, $perPage),
            count($processedData),
            $perPage,
            $page,
            ['path' => url()->current()]
        );
    }


    public function generateReport(string $reportType, bool $export = false, $queryParams)
    {
        switch ($reportType) {
            case 'attendance':
                return $this->getAttendanceRecords($queryParams);
            case 'LoanListing':
                //
            default:
                throw new \InvalidArgumentException("Invalid report type: {$reportType}");
        }
    }


    public function attendanceTrendsAnalysis(string $reportType, bool $export = false, $queryParams)
    {
        $attendances = $this->getAttendanceRecords($queryParams);
        $trendData = [];

        foreach ($attendances as $attendance) {
            $status = $this->getUserStatus($attendance);
            $date = $attendance->date->format('Y-m-d');
            if (!isset($trendData[$date])) {
                $trendData[$date] = [
                    'on_time' => 0,
                    'late' => 0,
                    'absent' => 0,
                ];
            }
            $trendData[$date][$status]++;
        }

        return $trendData;
    }


    /**
     * Retrieve a specific employee's attendance.
     *
     * @param  int  $employeeId
     * @return array
     */
    public function getEmployeeAttendance(int $employeeId, $perPage = 150, $page = 1)
    {
        $response = Http::withToken($this->token)->get("{$this->baseUrl}/iclock/api/transactions/{$employeeId}");
        // return $response->successful() ? $response->json() : $this->handleError($response);

        if ($response->successful()) {
            $transactions = $response->json('data');
            $total = $response->json('count');  // Assuming API returns the total count of transactions

            // Create a LengthAwarePaginator instance to paginate the data
            return new LengthAwarePaginator(
                array_slice($transactions, ($page - 1) * $perPage, $perPage), // Slice the data for current page
                $total, // Total number of items (count from API)
                $perPage, // Items per page
                $page, // Current page
                ['path' => url()->current()] // For pagination links
            );
        } else {
            $this->handleError($response);
        }
    }




    /**
     * Get user attendance status as on-time, late, or absent.
     *
     * @param  array  $attendanceRecords
     * @param  string  $standardCheckInTime
     * @return array
     */
    public function getUserStatus(array $attendanceRecords, string $standardCheckInTime = '09:00')
    {
        $statuses = [];
        foreach ($attendanceRecords as $record) {
            $userId = $record['user_id'];
            $checkInTime = Carbon::parse($record['check_in_time']);
            $standardTime = Carbon::createFromTimeString($standardCheckInTime);

            if (!$checkInTime) {
                $statuses[$userId] = 'absent';
            } else {
                $statuses[$userId] = $checkInTime->lessThanOrEqualTo($standardTime) ? 'on-time' : 'late';
            }
        }

        return $statuses;
    }

    /**
     * Filter attendance records by a specific date or date range.
     *
     * @param  string  $startDate
     * @param  string|null  $endDate
     * @return array
     */
    public function filterAttendanceByDate(string $startDate, string $endDate = null)
    {
        $queryParams = [
            'date_from' => $startDate,
            'date_to' => $endDate ?? $startDate,
        ];

        return $this->getAttendanceRecords($queryParams);
    }




    /**
     * Handle API error responses.
     *
     * @param  \Illuminate\Http\Client\Response  $response
     * @return array
     * @throws \Exception
     */
    protected function handleError($response)
    {
        throw new \Exception('API Error: ' . $response->body());
    }
}
