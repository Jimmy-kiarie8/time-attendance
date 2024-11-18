<?php

namespace App\Exports;

use App\Models\Company;
use App\Services\ReportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;

class ReportExport implements WithChunkReading, ShouldQueue, FromView
{

    use Exportable;

    public $data, $report_type, $filetype;

    public function __construct($data, $report_type, $filetype)
    {
        $this->data = $data;
        $this->report_type = $report_type;
        $this->filetype = $filetype;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
    }

    public function chunkSize(): int
    {
        return 1000; // Adjust the chunk size according to your needs
    }


    public function view(): View
    {
        // resources/views/reports/sale-report.blade.php
        // $reportService = new ReportService;
        // dd($this->data);
        $total = 0;
        // if($this->report_type === 'Transactions') {
        //     // Get totals
        //     $total = $reportService->getTotals($this->data, 'TransAmount');
        // }
        $viewPath = "reports.report";
        return view($viewPath, [
            'data' => $this->data['data'],
            'headers' => $this->data['headers'],
            'total' => $total,
            'filetype' => $this->filetype,
            'report_type' => $this->report_type,
            'company' =>Company::first()


        ]);

    }


}
