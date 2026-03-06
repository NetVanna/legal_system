<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait DashboardAnalytics
{
    public function getDashboardData($moduleKey = null)
    {
        // For case counts and revenue, we can filter by type_case
        $benefitCaseQuery = DB::table('benefit_cases');
        $caseQuery = DB::table('cases');
        $monthlyBenefitCaseQuery = DB::table('benefit_cases')
            ->whereYear('date', now()->year)
            ->whereMonth('date', now()->month);
        $lastMonthBenefitCaseQuery = DB::table('benefit_cases')
            ->whereYear('date', now()->subMonth()->year)
            ->whereMonth('date', now()->subMonth()->month);
        $activeCasesQuery = DB::table('cases');
            
        // If passed a strict type mapping for the module
        if ($moduleKey) {
            $benefitCaseQuery->where('type_case', $moduleKey);
            $caseQuery->where('case_type', $moduleKey);
            $monthlyBenefitCaseQuery->where('type_case', $moduleKey);
            $lastMonthBenefitCaseQuery->where('type_case', $moduleKey);
            $activeCasesQuery->where('case_type', $moduleKey);
        }

        // Total Revenue & Breakdown
        $totalRevenue = (clone $benefitCaseQuery)->sum('service_fee');
        $monthlyRevenue = (clone $monthlyBenefitCaseQuery)->sum('service_fee');
        $lastMonthRevenue = (clone $lastMonthBenefitCaseQuery)->sum('service_fee');

        $revenueGrowth = $lastMonthRevenue > 0
            ? (($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100
            : 0;

        // Fee Distribution Analysis
        $feeBreakdown = (clone $benefitCaseQuery)
            ->select(
                DB::raw('SUM(employee_fee) as total_employee_fee'),
                DB::raw('SUM(chapter_fee) as total_chapter_fee'),
                DB::raw('SUM(admin_fee) as total_admin_fee'),
                DB::raw('SUM(it_fee) as total_it_fee'),
                DB::raw('SUM(lawyer_fee) as total_lawyer_fee'),
                DB::raw('SUM(net_fee) as total_net_fee')
            )
            ->first();
            
        // If there's no data, default properties so the view doesn't break
        if (!$feeBreakdown->total_employee_fee) {
            $feeBreakdown = (object)[
                'total_net_fee' => 0,
                'total_employee_fee' => 0,
                'total_lawyer_fee' => 0,
                'total_chapter_fee' => 0,
                'total_admin_fee' => 0,
                'total_it_fee' => 0,
            ];
        }

        // Case Statistics
        $totalCases = (clone $caseQuery)->count();
        $activeCases = (clone $activeCasesQuery)->count(); // Can add status filters if required
        $monthlyCases = (clone $monthlyBenefitCaseQuery)->count();

        // Client Statistics (Clients are shared, but if we want per module maybe join cases)
        $totalClients = DB::table('clients')->count();
        $individualClients = DB::table('clients')->where('client_type', 'individual')->count();
        $companyClients = DB::table('clients')->where('client_type', 'company')->count();

        $newClientsThisMonth = DB::table('clients')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        // Employee Statistics
        $totalEmployees = DB::table('users')->where('status', 'active')->count();

        $employeesByPosition = DB::table('users')
            ->join('positions', 'users.position_id', '=', 'positions.id')
            ->select('positions.name', DB::raw('count(*) as total'))
            ->where('users.status', 'active')
            ->groupBy('positions.name')
            ->get();

        // Top Performing Employees by Revenue
        $topEmployees = (clone $benefitCaseQuery)
            ->select('employee', DB::raw('SUM(service_fee) as total_revenue'), DB::raw('COUNT(*) as case_count'))
            ->groupBy('employee')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        // Top Lawyers by Revenue
        $topLawyers = (clone $benefitCaseQuery)
            ->select('lawyer', DB::raw('SUM(lawyer_fee) as total_earnings'), DB::raw('COUNT(*) as case_count'))
            ->groupBy('lawyer')
            ->orderByDesc('total_earnings')
            ->limit(5)
            ->get();

        // Chapter Performance
        $chapterPerformance = (clone $benefitCaseQuery)
            ->select('chapter', DB::raw('SUM(service_fee) as revenue'), DB::raw('COUNT(*) as cases'))
            ->whereNotNull('chapter')
            ->groupBy('chapter')
            ->orderByDesc('revenue')
            ->get();

        // Monthly Revenue Trend (Last 12 months)
        $monthlyTrendQuery = DB::table('benefit_cases')
            ->select(
                DB::raw('YEAR(date) as year'),
                DB::raw('MONTH(date) as month'),
                DB::raw('SUM(service_fee) as revenue'),
                DB::raw('COUNT(*) as cases')
            )
            ->where('date', '>=', now()->subMonths(11)->startOfMonth());
            
        if ($moduleKey) {
            $monthlyTrendQuery->where('type_case', $moduleKey);
        }
            
        $monthlyTrend = $monthlyTrendQuery->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Case Type Distribution
        $caseTypeDistributionQuery = DB::table('benefit_cases')
            ->select('type_case', DB::raw('COUNT(*) as count'), DB::raw('SUM(service_fee) as revenue'));
            
        if ($moduleKey) {
             $caseTypeDistributionQuery->where('type_case', $moduleKey);
        }
        
        $caseTypeDistribution = $caseTypeDistributionQuery->groupBy('type_case')
            ->orderByDesc('count')
            ->get();

        // Recent Cases
        $recentCasesQuery = DB::table('benefit_cases')
            ->join('cases', 'benefit_cases.case_id', '=', 'cases.id')
            ->select('benefit_cases.*', 'cases.case_number');
            
        if ($moduleKey) {
             $recentCasesQuery->where('benefit_cases.type_case', $moduleKey);
        }
            
        $recentCases = $recentCasesQuery->orderByDesc('benefit_cases.date')
            ->limit(10)
            ->get();

        return [
            'totalRevenue' => $totalRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'revenueGrowth' => $revenueGrowth,
            'totalCases' => $totalCases,
            'activeCases' => $activeCases,
            'totalClients' => $totalClients,
            'individualClients' => $individualClients,
            'companyClients' => $companyClients,
            'newClientsThisMonth' => $newClientsThisMonth,
            'monthlyCases' => $monthlyCases,
            'feeBreakdown' => $feeBreakdown,
            'topEmployees' => $topEmployees,
            'recentCases' => $recentCases,
            'topLawyers' => $topLawyers,
            'chapterPerformance' => $chapterPerformance,
            'monthlyTrend' => $monthlyTrend,
            'caseTypeDistribution' => $caseTypeDistribution,
            // Add JSON versions for easy JS usage
            'monthlyTrendJson' => json_encode($monthlyTrend->map(function($item) {
                return [
                    'revenue' => (float)$item->revenue,
                    'label' => date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year))
                ];
            })),
            'caseTypeDistributionJson' => json_encode($caseTypeDistribution->map(function($item) {
                return [
                    'count' => (int)$item->count,
                    'type' => $item->type_case
                ];
            })),
        ];
    }
}
