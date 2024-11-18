<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{

    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }


    public function analytics()
    {
        // return [
        //     'dailyAttendance' => $this->dashboardService->getDailyAttendanceChart(),
        //     'departmentDistribution' => $this->dashboardService->getDepartmentEmployeeDistribution(),
        //     'deviceComparison' => $this->dashboardService->getDeviceTransactionComparison(),
        //     'hourlyPattern' => $this->dashboardService->getHourlyAttendancePattern(),
        // ];



        $data = [
            [
                'label' => 'Employees',
                'value' => $this->dashboardService->getData('employees'),
                'icon' => 'mdi-account-circle',
                'iconColor' => 'secondary',
            ],
            [
                'label' => 'Departments',
                'value' => $this->dashboardService->getData('departments'),
                'icon' => 'mdi-view-dashboard',
                'iconColor' => 'secondary',
            ]
        ];


        return Inertia::render('Dashboard/index', [
            'data' => $data,
            'dailyAttendance' => $this->dashboardService->getDailyAttendanceChart(),
            'departmentDistribution' => $this->dashboardService->getDepartmentEmployeeDistribution(),
            'deviceComparison' => $this->dashboardService->getDeviceTransactionComparison(),
            'hourlyPattern' => $this->dashboardService->getHourlyAttendancePattern(),
        ]);
    }

    public function analytics1()
    {
        // $user = User::find(Auth::id());
        $dashboard = $this->dashboardService;


        $data = $dashboard->getOverviewMetrics();

        $data = [
            [
                'label' => 'Payments',
                'value' => $data['totalPayment'],
                'icon' => 'mdi-cash',
                'iconColor' => 'secondary',
            ],
            [
                'label' => 'Total Loans',
                'value' => $data['totalLoans'],
                'icon' => 'mdi-counter',
                'iconColor' => 'info',
            ],
            [
                'label' => 'Total Disbursed Amount',
                'value' => $data['totalDisbursedAmount'],
                'icon' => 'mdi-cash',
                'iconColor' => 'primary',
            ],
            [
                'label' => 'Total Approved Loans',
                'value' => $data['totalApprovedLoans'],
                'icon' => 'mdi-check-circle',
                'iconColor' => 'success',
            ],
            [
                'label' => 'Total Pending Loans',
                'value' => $data['totalPendingLoans'],
                'icon' => 'mdi-book',
                'iconColor' => 'warning',
            ],
            [
                'label' => 'Total Rejected Loans',
                'value' => $data['totalRejectedLoans'],
                'icon' => 'mdi-cancel',
                'iconColor' => 'error',
            ],
            [
                'label' => 'Total Paid Loans',
                'value' => $data['totalPaidLoans'],
                'icon' => 'mdi-check',
                'iconColor' => 'success',
            ],
            [
                'label' => 'Total Penalties Collected',
                'value' => $data['totalPenaltiesCollected'],
                'icon' => 'mdi-close-circle',
                'iconColor' => 'secondary',
            ],
            [
                'label' => 'Total Overdue Loans',
                'value' => $data['totalOverdueLoans'],
                'icon' => 'mdi-format-overline',
                'iconColor' => 'error',
            ],
        ];


        $loanStatusChart = $dashboard->getLoanStatusChart();
        $disbursementTrends = $dashboard->getDisbursementTrends();
        $repaymentAndArrearsChart = $dashboard->getRepaymentAndArrearsChart();
        $borrowerDemographicsChart = $dashboard->getBorrowerDemographicsChart();

        $recentActivities = $dashboard->getRecentActivities();
        $overdueLoansRiskInsights = $dashboard->getOverdueLoansRiskInsights();
        $repaymentScheduleHeatmap = $dashboard->getRepaymentScheduleHeatmap();
        $agentsChart = $dashboard->agentsChart();


        $upcommingPayments = $dashboard->getUpcommingPayments();


        $stats = [
            [
                'label' => 'Borrowers',
                'value' => Client::count(),
                'icon' => 'mdi-account-circle',
                'iconColor' => 'info',
            ],

            [
                'label' => 'Loan Officers',
                'value' => User::count(),
                'icon' => 'mdi-account-circle',
                'iconColor' => 'info',
            ],

            [
                'label' => 'Branches',
                'value' =>Branch::count(),
                'icon' => 'mdi-view-dashboard',
                'iconColor' => 'info',
            ],

            [
                'label' => 'Guarantors',
                'value' =>Guarantor::count(),
                'icon' => 'mdi-account',
                'iconColor' => 'info',
            ],

            [
                'label' => 'Loan Products',
                'value' => LoanType::count(),
                'icon' => 'mdi-book',
                'iconColor' => 'info',
            ],
        ];


        return Inertia::render('Dashboard/index', [
            'data' => $data,
            'loanStatusChart' => $loanStatusChart,
            'disbursementTrends' => $disbursementTrends,
            'repaymentAndArrearsChart' => $repaymentAndArrearsChart,
            'borrowerDemographicsChart' => $borrowerDemographicsChart,
            'recentActivities' => $recentActivities,
            'overdueLoansRiskInsights' => $overdueLoansRiskInsights,
            'repaymentScheduleHeatmap' => $repaymentScheduleHeatmap,
            'agentsChart' => $agentsChart,
            'upcommingPayments' => $upcommingPayments,
            'stats' => $stats,
        ]);
    }
}
