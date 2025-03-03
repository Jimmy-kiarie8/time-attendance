<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Models\Branch;
use App\Models\Client;
use App\Models\Company;
use App\Models\LoanType;
use App\Models\User;
use App\Services\ReportService;
use App\Services\ZKTecoService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    protected $reportService, $zKTecoService;

    public function __construct(ReportService $reportService, ZKTecoService $zKTecoService)
    {
        $this->reportService = $reportService;
        $this->zKTecoService = $zKTecoService;
    }


    public function index()
    {
        $jsonData = $this->loadAndUpdateJsonData();

        return Inertia::render('Reports/index', [
            'form_data' => $jsonData,
            'headers' => []
        ]);
    }

    public function generate(Request $request)
    {

        $queryParams = [
            'start_time' => Carbon::parse($request->start_date)->startOfDay()->toDateTimeString(),
            'end_time' => Carbon::parse($request->end_date)->endOfDay()->toDateTimeString(),
            'emp_code' => ($request->employee) ? $request->employee : null,
            // 'department' => ($request->department) ? $request->department : null,
        ];

        $data =  $this->zKTecoService->generateReport($request->report_type, false,$queryParams);

        $reportData = $this->reportService->transformData($data);
        // Log::info(DB::getQueryLog());

        return response()->json($reportData);
    }


    private function loadAndUpdateJsonData()
    {
        $jsonFile = public_path('reports/reports.json');
        if (!file_exists($jsonFile)) {
            abort(404, 'JSON file not found');
        }

        $jsonData = json_decode(file_get_contents($jsonFile), true);

        $modelData = [
            'employee' => $this->zKTecoService->getEmployeeData(),
            'department' => $this->zKTecoService->getDepartmentData(),
        ];

        foreach ($jsonData as &$item) {
            if ($item['type'] == 'select' && isset($modelData[$item['model']])) {
                // Ensure the model data is a Collection
                $itemsCollection = collect($modelData[$item['model']]);
                $item['items'] = $itemsCollection->map(function ($modelItem) use ($item) {
                    return [
                        'value' => $modelItem['id'],
                        'label' => $modelItem['name']
                    ];
                })->toArray();
            }

            if ($item['model'] == 'start_date') {
                $item['value'] = Carbon::now()->subMonth()->format('Y-m-d');
            } elseif ($item['model'] == 'end_date') {
                $item['value'] = Carbon::now()->format('Y-m-d');
            }
        }

        return $jsonData;
    }





    // Download

    public function downloadReport(Request $request)
    {


        $queryParams = [
            'start_time' => Carbon::parse($request->start_date)->startOfDay()->toDateTimeString(),
            'end_time' => Carbon::parse($request->end_date)->endOfDay()->toDateTimeString(),
            'emp_code' => ($request->employee) ? $request->employee : null,
            'department' => ($request->department) ? $request->department['dept_code'] : null,
        ];
        $reportType = $request->input('report_type');
        // $baseTable = $this->getBaseTableForReportType($reportType);

        // $reportService = new ReportService($baseTable, $filters);


        $data =  $this->zKTecoService->generateReport($request->report_type, false,$queryParams);

          $reportData = $this->reportService->transformData($data);
        // $reportData = $reportService->generateReport($request->report_type, true);

        if ($request->filetype === 'pdf') {
            return $this->export($reportData, $reportType, $request->filetype);
        } else {
            return (new ReportExport($reportData, $reportType, 'Excle'))->download(env('APP_NAME') . ' ' . Carbon::now()->format('Y-m-d') . ' Report.xlsx');
        }
    }


    private function export($data, $report_type, $filetype)
    {
        $viewPath = 'reports.report';
        $company = Company::first();




        $total = 0;
        $pdf = PDF::loadView($viewPath, [
            'data' => $data['data'],
            'headers' => $data['headers'],
            'filetype' => 'pdf',
            'total' => $total,
            'company' => $company,
            'report_type' => $report_type
        ]);

        return $pdf->stream(env('APP_NAME') . ' ' . now()->format('Y-m-d') . ' Report.pdf');
    }

}
