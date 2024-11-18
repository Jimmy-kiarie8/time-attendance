<?php

namespace App\Services;

use App\Services\ZKTecoService;
use Carbon\Carbon;

class ReportService
{
    protected $zkTecoService;

    public function __construct(ZKTecoService $zkTecoService)
    {
        $this->zkTecoService = $zkTecoService;
    }

    /**
     * Daily Attendance Report
     *
     * @param Carbon $date
     * @return array
     */
    public function dailyAttendanceReport(Carbon $date)
    {

        $attendances = $this->zkTecoService->getAttendanceByDate($date);

        // Format data with status (on-time, late, absent)
        $report = [];
        foreach ($attendances as $attendance) {
            $report[] = [
                'user_id' => $attendance->user_id,
                'status' => $this->zkTecoService->getUserStatus($attendance),
            ];
        }
        return $report;
    }

    /**
     * Monthly Attendance Summary
     *
     * @param int $userId
     * @param Carbon $month
     * @return array
     */
    public function monthlyAttendanceSummary($userId, Carbon $month)
    {
        $start = $month->copy()->startOfMonth();
        $end = $month->copy()->endOfMonth();
        $attendances = $this->zkTecoService->getAttendanceByUserAndDateRange($userId, $start, $end);

        $summary = [
            'on_time' => 0,
            'late' => 0,
            'absent' => 0,
        ];

        foreach ($attendances as $attendance) {
            $status = $this->zkTecoService->getUserStatus($attendance);
            $summary[$status]++;
        }
        return $summary;
    }

    /**
     * Late Attendance Report
     *
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return array
     */
    public function lateAttendanceReport(Carbon $startDate, Carbon $endDate)
    {
        $attendances = $this->zkTecoService->getAttendanceByDateRange($startDate, $endDate);

        // Filter for late statuses
        $lateReport = array_filter($attendances, function($attendance) {
            return $this->zkTecoService->getUserStatus($attendance) === 'late';
        });

        return $lateReport;
    }

    /**
     * Absent Report
     *
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return array
     */
    public function absentReport(Carbon $startDate, Carbon $endDate)
    {
        $attendances = $this->zkTecoService->getAttendanceByDateRange($startDate, $endDate);

        // Filter for absent statuses
        $absentReport = array_filter($attendances, function($attendance) {
            return $this->zkTecoService->getUserStatus($attendance) === 'absent';
        });

        return $absentReport;
    }

    /**
     * Attendance Trends Analysis
     *
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return array
     */
    public function attendanceTrendsAnalysis(Carbon $startDate, Carbon $endDate)
    {
        $attendances = $this->zkTecoService->getAttendanceByDateRange($startDate, $endDate);
        $trendData = [];

        foreach ($attendances as $attendance) {
            $status = $this->zkTecoService->getUserStatus($attendance);
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
     * Individual Attendance History
     *
     * @param int $userId
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return array
     */
    public function individualAttendanceHistory($userId, Carbon $startDate, Carbon $endDate)
    {
        $attendances = $this->zkTecoService->getAttendanceByUserAndDateRange($userId, $startDate, $endDate);

        $history = [];
        foreach ($attendances as $attendance) {
            $history[] = [
                'date' => $attendance->date->format('Y-m-d'),
                'status' => $this->zkTecoService->getUserStatus($attendance),
            ];
        }
        return $history;
    }

    /**
     * Compliance Rate Report
     *
     * @param int $userId
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return float
     */
    public function complianceRateReport($userId, Carbon $startDate, Carbon $endDate)
    {
        $attendances = $this->zkTecoService->getAttendanceByUserAndDateRange($userId, $startDate, $endDate);

        $onTimeCount = 0;
        $totalDays = count($attendances);

        foreach ($attendances as $attendance) {
            if ($this->zkTecoService->getUserStatus($attendance) === 'on-time') {
                $onTimeCount++;
            }
        }

        return $totalDays > 0 ? ($onTimeCount / $totalDays) * 100 : 0;
    }



    public function generateReport(string $reportType, bool $export = false)
    {
        switch ($reportType) {
            case 'LoanBook':
                return $this->generateLoanBook($export);
            case 'LoanListing':
                return $this->generateLoanListing($export);
            case 'LoanTable':
                return $this->generateLoanTable($export);
            default:
                throw new \InvalidArgumentException("Invalid report type: {$reportType}");
        }
    }



    public function transformData($paginatedData, $export=false)
    {

        $headers = [];
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


}
