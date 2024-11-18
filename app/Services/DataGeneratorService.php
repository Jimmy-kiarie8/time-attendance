<?php

namespace App\Services;

use App\Models\Callcenter;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataGeneratorService
{
    public function generateLeadData()
    {
        $data = Lead::select(
            DB::raw('DATE_FORMAT(created_at, "%b") as month'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('month')
            ->orderBy('month', 'Desc')
            ->get();

        $labels = $data->pluck('month')->toArray();
        $counts = $data->pluck('count')->toArray();

        $testData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => $counts,
                    'backgroundColor' => ['#77CEFF', '#0079AF', '#123E6B', '#97B0C4', '#A5C8ED'],
                ],
            ],
        ];

        return $testData;
    }

    public function generateAgentActivityData()
    {
        $data = Callcenter::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('agent_id', Auth::id())
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = $data->pluck('date')->toArray();
        $counts = $data->pluck('count')->toArray();

        $agentActivityData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Completed Calls',
                    'data' => $counts,
                    'backgroundColor' => 'rgba(119, 206, 255, 0.5)',
                    'borderColor' => '#0079AF',
                ],
            ],
        ];

        return $agentActivityData;
    }

    public function generateLeadsConversionData()
    {
        $data = User::select(
            'users.name',  // Specify the table alias for the name column
            DB::raw('COUNT(CASE WHEN leads.status = "converted" THEN 1 ELSE NULL END) as converted_count'),
            DB::raw('COUNT(leads.id) as total_count')
        )
            ->leftJoin('leads', 'users.id', '=', 'leads.agent_id')  // Adjust the table alias for the join condition
            ->groupBy('users.id', 'users.name')  // Specify the table alias for the groupBy clause
            ->get();


        $labels = $data->pluck('name')->toArray();
        $conversionRates = $data->map(function ($agent) {
            return ($agent->total_count > 0) ? ($agent->converted_count / $agent->total_count) * 100 : 0;
        })->toArray();

        $leadsConversionData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Conversion Rate',
                    'data' => $conversionRates,
                    'backgroundColor' => '#77CEFF',
                ],
            ],
        ];

        return $leadsConversionData;
    }

    public function generateLeadStatusDistributionData()
    {
        $data = Lead::select(
            'status',
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('status')
            ->get();

        $statuses = $data->pluck('status')->toArray();
        $counts = $data->pluck('count')->toArray();

        $leadStatusDistributionData = [
            'labels' => $statuses,
            'datasets' => [
                [
                    'data' => $counts,
                    'backgroundColor' => ['#77CEFF', '#0079AF', '#123E6B', '#97B0C4', '#A5C8ED'],
                ],
            ],
        ];

        return $leadStatusDistributionData;
    }

    public function generateSystemCallsTrendData()
    {
        $data = Callcenter::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = $data->pluck('date')->toArray();
        $counts = $data->pluck('count')->toArray();

        $systemCallsTrendData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Completed Calls',
                    'data' => $counts,
                    'backgroundColor' => 'rgba(119, 206, 255, 0.5)',
                    'borderColor' => '#0079AF',
                ],
            ],
        ];

        return $systemCallsTrendData;
    }

    public function generateAgentPerformanceData()
    {
        $data = User::select(
            'users.name',
            DB::raw('COUNT(CASE WHEN callcenters.status = "Completed" THEN 1 ELSE NULL END) as completed_count'),
            DB::raw('COUNT(CASE WHEN callcenters.status = "Missed" THEN 1 ELSE NULL END) as missed_count'),
            DB::raw('COUNT(leads.id) as total_leads')
        )
            ->leftJoin('callcenters', 'users.id', '=', 'callcenters.agent_id')
            ->leftJoin('leads', 'users.id', '=', 'leads.agent_id')
            ->groupBy('users.id', 'users.name')
            ->get();

        $labels = $data->pluck('name')->toArray();
        $completedCounts = $data->pluck('completed_count')->toArray();
        $missedCounts = $data->pluck('missed_count')->toArray();
        $totalLeads = $data->pluck('total_leads')->toArray();

        $agentPerformanceData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Completed Calls',
                    'data' => $completedCounts,
                    'backgroundColor' => 'rgba(119, 206, 255, 0.5)',
                    'borderColor' => '#0079AF',
                ],
                [
                    'label' => 'Missed Calls',
                    'data' => $missedCounts,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
                    'borderColor' => '#FF6384',
                ],
                [
                    'label' => 'Total Leads',
                    'data' => $totalLeads,
                    'backgroundColor' => 'rgba(123, 239, 178, 0.5)',
                    'borderColor' => '#00AF67',
                ],
            ],
        ];

        return $agentPerformanceData;
    }
}
