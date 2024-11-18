<?php

namespace App\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Http;

class DashboardService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = config('zkteco.base_url');
        // $this->token = config('services.zkteco.token');
        $this->token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ0b2tlbl90eXBlIjoiYWNjZXNzIiwiZXhwIjoxNzMxNzQyMzQwLCJpYXQiOjE3MzE2NTU5NDAsImp0aSI6ImQzMzQ0MjhmNGJmMTQ0NGM5NWNmMmI5OTcyNWExMzU1IiwidXNlcl9pZCI6MX0.xY9YsZiParq6U_d84fyRLvcZBpSkAOeb9MtW3owg4hE';
    }

    /**
     * Get daily attendance counts for the last 7 days
     */
    public function getDailyAttendanceChart()
    {
        $endDate = Carbon::tomorrow();
        $startDate = Carbon::now()->subDays(6);
        $period = CarbonPeriod::create($startDate, $endDate);

        $dates = [];
        $counts = [];

        foreach ($period as $date) {
            $formattedDate = $date->format('Y-m-d');
            $dates[] = $date->format('M d');

            // dd($formattedDate);

            // Get transactions for this date
            $response = Http::withToken($this->token)
                ->get("{$this->baseUrl}/iclock/api/transactions/", [
                    'start_time' => $formattedDate . ' 00:00:00',
                    'end_time' => $formattedDate  . ' 23:00:00',
                ]);

            $counts[] = $response->json()['count'] ?? 0;
        }

        return [
            'labels' => $dates,
            'datasets' => [
                [
                    'label' => 'Daily Attendance',
                    'data' => $counts,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1
                ]
            ]
        ];
    }

    /**
     * Get department-wise employee distribution
     */
    public function getDepartmentEmployeeDistribution()
    {
        $response = Http::withToken($this->token)
            ->get("{$this->baseUrl}/personnel/api/departments/");

        $departments = collect($response->json()['data'] ?? []);

        $labels = $departments->pluck('dept_name')->toArray();
        $employeeCounts = [];

        foreach ($departments as $department) {
            $empResponse = Http::withToken($this->token)
                ->get("{$this->baseUrl}/personnel/api/employees/", [
                    'department' => $department['id']
                ]);

            $employeeCounts[] = $empResponse->json()['count'] ?? 0;
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Employee Count',
                    'data' => $employeeCounts,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1
                ]
            ]
        ];
    }

    /**
     * Compare device transaction volumes
     */
    public function getDeviceTransactionComparison()
    {
        $response = Http::withToken($this->token)
            ->get("{$this->baseUrl}/iclock/api/terminals/");

        $devices = collect($response->json()['data'] ?? []);
        $labels = $devices->pluck('alias')->toArray();

        // Get today's transactions
        $todayData = [];
        $yesterdayData = [];

        foreach ($devices as $device) {
            // Today's transactions
            $todayResponse = Http::withToken($this->token)
                ->get("{$this->baseUrl}/iclock/api/transactions/", [
                    'terminal' => $device['id'],
                    'start_time' => Carbon::today()->startOfDay()->toDateTimeString(),
                    'end_date' => Carbon::today()->endOfDay()->toDateTimeString()
                ]);

            // Yesterday's transactions
            $yesterdayResponse = Http::withToken($this->token)
                ->get("{$this->baseUrl}/iclock/api/transactions/", [
                    'terminal' => $device['id'],
                    'start_time' => Carbon::today()->startOfDay()->toDateTimeString(),
                    'end_date' => Carbon::yesterday()->endOfDay()->toDateTimeString()
                ]);

            $todayData[] = $todayResponse->json()['count'] ?? 0;
            $yesterdayData[] = $yesterdayResponse->json()['count'] ?? 0;
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Today',
                    'data' => $todayData,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1
                ],
                [
                    'label' => 'Yesterday',
                    'data' => $yesterdayData,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1
                ]
            ]
        ];
    }

    /**
     * Get hourly attendance pattern for today
     */
    public function getHourlyAttendancePattern()
    {
        $hours = range(0, 23);
        $labels = array_map(function ($hour) {
            return sprintf('%02d:00', $hour);
        }, $hours);

        $checkins = array_fill(0, 24, 0);
        $checkouts = array_fill(0, 24, 0);

        $response = Http::withToken($this->token)
            ->get("{$this->baseUrl}/iclock/api/transactions/", [
                'start_time' => Carbon::today()->startOfDay()->toDateTimeString(),
                'end_time' => Carbon::today()->endOfDay()->toDateTimeString()
            ]);

        $transactions = $response->json()['data'] ?? [];

        foreach ($transactions as $transaction) {
            $hour = Carbon::parse($transaction['punch_time'])->hour;

            if ($hour < 13) { // Assuming 0 is check-in
                $checkins[$hour]++;
            } else {
                $checkouts[$hour]++;
            }
        }


        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Check-ins',
                    'data' => $checkins,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1
                ],
                [
                    'label' => 'Check-outs',
                    'data' => $checkouts,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1
                ]
            ]
        ];
    }


    public function getData($endPoint)
    {
        $response = Http::withToken($this->token)->get("{$this->baseUrl}/personnel/api/${endPoint}/");

        if ($response->successful()) {
            $transactions = $response->json('count');

            return $transactions;
        }
    }
}
