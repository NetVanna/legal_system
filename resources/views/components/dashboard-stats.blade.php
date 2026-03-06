<!-- Key Metrics Cards -->
<div class="grid grid-cols-1 gap-x-5 md:grid-cols-2 xl:grid-cols-4 mb-5">

    <!-- Total Revenue Card -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-12 h-12 rounded-md bg-green-100 dark:bg-green-500/20">
                    <i data-lucide="dollar-sign" class="w-6 h-6 text-green-500"></i>
                </div>
                <div class="grow">
                    <h6 class="mb-1 text-15">Total Revenue</h6>
                    <p class="text-slate-500 dark:text-zink-200">All Time</p>
                </div>
            </div>
            <div class="flex items-end justify-between mt-4">
                <h4 class="text-24">${{ number_format($totalRevenue, 2) }}</h4>
                <div
                    class="flex items-center gap-1 text-xs {{ $revenueGrowth >= 0 ? 'text-green-500' : 'text-red-500' }}">
                    <i data-lucide="{{ $revenueGrowth >= 0 ? 'trending-up' : 'trending-down' }}" class="w-4 h-4"></i>
                    {{ number_format(abs($revenueGrowth), 1) }}%
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Revenue Card -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-12 h-12 rounded-md bg-blue-100 dark:bg-blue-500/20">
                    <i data-lucide="calendar" class="w-6 h-6 text-blue-500"></i>
                </div>
                <div class="grow">
                    <h6 class="mb-1 text-15">Monthly Revenue</h6>
                    <p class="text-slate-500 dark:text-zink-200">This Month</p>
                </div>
            </div>
            <div class="flex items-end justify-between mt-4">
                <h4 class="text-24">${{ number_format($monthlyRevenue, 2) }}</h4>
                <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-600 dark:bg-green-500/20">
                    {{ $monthlyCases }} Cases
                </span>
            </div>
        </div>
    </div>

    <!-- Total Cases Card -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-12 h-12 rounded-md bg-purple-100 dark:bg-purple-500/20">
                    <i data-lucide="briefcase" class="w-6 h-6 text-purple-500"></i>
                </div>
                <div class="grow">
                    <h6 class="mb-1 text-15">Total Cases</h6>
                    <p class="text-slate-500 dark:text-zink-200">Active Cases</p>
                </div>
            </div>
            <div class="flex items-end justify-between mt-4">
                <h4 class="text-24">{{ number_format($totalCases) }}</h4>
                <span class="px-2 py-1 text-xs rounded bg-purple-100 text-purple-600 dark:bg-purple-500/20">
                    {{ $activeCases }} Active
                </span>
            </div>
        </div>
    </div>

    <!-- Total Clients Card -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-12 h-12 rounded-md bg-orange-100 dark:bg-orange-500/20">
                    <i data-lucide="users" class="w-6 h-6 text-orange-500"></i>
                </div>
                <div class="grow">
                    <h6 class="mb-1 text-15">Total Clients</h6>
                    <p class="text-slate-500 dark:text-zink-200">{{ $individualClients }} Individual /
                        {{ $companyClients }} Company
                    </p>
                </div>
            </div>
            <div class="flex items-end justify-between mt-4">
                <h4 class="text-24">{{ number_format($totalClients) }}</h4>
                <span class="px-2 py-1 text-xs rounded bg-orange-100 text-orange-600 dark:bg-orange-500/20">
                    +{{ $newClientsThisMonth }} New
                </span>
            </div>
        </div>
    </div>

</div>

<!-- Fee Distribution & Charts Row -->
<div class="grid grid-cols-1 gap-x-5 xl:grid-cols-2 mb-5">

    <!-- Fee Distribution Card -->
    <div class="card">
        <div class="card-body">
            <h6 class="mb-4 text-15">Fee Distribution Breakdown</h6>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 rounded bg-slate-100 dark:bg-zink-600">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-green-500"></div>
                        <span class="text-sm">Net Fee</span>
                    </div>
                    <span class="font-semibold">${{ number_format($feeBreakdown->total_net_fee, 2) }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded bg-slate-100 dark:bg-zink-600">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                        <span class="text-sm">Employee Fee</span>
                    </div>
                    <span class="font-semibold">${{ number_format($feeBreakdown->total_employee_fee, 2) }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded bg-slate-100 dark:bg-zink-600">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-purple-500"></div>
                        <span class="text-sm">Lawyer Fee</span>
                    </div>
                    <span class="font-semibold">${{ number_format($feeBreakdown->total_lawyer_fee, 2) }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded bg-slate-100 dark:bg-zink-600">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-orange-500"></div>
                        <span class="text-sm">Chapter Fee</span>
                    </div>
                    <span class="font-semibold">${{ number_format($feeBreakdown->total_chapter_fee, 2) }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded bg-slate-100 dark:bg-zink-600">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-yellow-500"></div>
                        <span class="text-sm">Admin Fee</span>
                    </div>
                    <span class="font-semibold">${{ number_format($feeBreakdown->total_admin_fee, 2) }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded bg-slate-100 dark:bg-zink-600">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-red-500"></div>
                        <span class="text-sm">IT Fee</span>
                    </div>
                    <span class="font-semibold">${{ number_format($feeBreakdown->total_it_fee, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Trend Chart -->
    <div class="card">
        <div class="card-body">
            <h6 class="mb-4 text-15">Revenue Trend (Last 12 Months)</h6>
            <div id="revenueChart" class="apex-charts"></div>
        </div>
    </div>

</div>

<!-- Performance Tables Row -->
<div class="grid grid-cols-1 gap-x-5 xl:grid-cols-2 mb-5">

    <!-- Top Performing Employees -->
    <div class="card">
        <div class="card-body">
            <h6 class="mb-4 text-15">Top Performing Employees</h6>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="ltr:text-left rtl:text-right">
                        <tr>
                            <th class="px-3.5 py-2.5 font-semibold border-b">Employee</th>
                            <th class="px-3.5 py-2.5 font-semibold border-b">Cases</th>
                            <th class="px-3.5 py-2.5 font-semibold border-b text-right">Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topEmployees as $employee)
                            <tr>
                                <td class="px-3.5 py-2.5 border-b">{{ $employee->employee }}</td>
                                <td class="px-3.5 py-2.5 border-b">
                                    <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-600 dark:bg-blue-500/20">
                                        {{ $employee->case_count }}
                                    </span>
                                </td>
                                <td class="px-3.5 py-2.5 border-b text-right font-semibold">
                                    ${{ number_format($employee->total_revenue, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-3.5 py-2.5 text-center text-slate-500">No data
                                    available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Top Lawyers -->
    <div class="card">
        <div class="card-body">
            <h6 class="mb-4 text-15">Top Lawyers by Earnings</h6>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="ltr:text-left rtl:text-right">
                        <tr>
                            <th class="px-3.5 py-2.5 font-semibold border-b">Lawyer</th>
                            <th class="px-3.5 py-2.5 font-semibold border-b">Cases</th>
                            <th class="px-3.5 py-2.5 font-semibold border-b text-right">Earnings</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topLawyers as $lawyer)
                            <tr>
                                <td class="px-3.5 py-2.5 border-b">{{ $lawyer->lawyer }}</td>
                                <td class="px-3.5 py-2.5 border-b">
                                    <span
                                        class="px-2 py-1 text-xs rounded bg-purple-100 text-purple-600 dark:bg-purple-500/20">
                                        {{ $lawyer->case_count }}
                                    </span>
                                </td>
                                <td class="px-3.5 py-2.5 border-b text-right font-semibold">
                                    ${{ number_format($lawyer->total_earnings, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-3.5 py-2.5 text-center text-slate-500">No data
                                    available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Chapter Performance & Case Type Distribution -->
<div class="grid grid-cols-1 gap-x-5 xl:grid-cols-2 mb-5">

    <!-- Chapter Performance -->
    <div class="card">
        <div class="card-body">
            <h6 class="mb-4 text-15">Chapter Performance</h6>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="ltr:text-left rtl:text-right">
                        <tr>
                            <th class="px-3.5 py-2.5 font-semibold border-b">Chapter</th>
                            <th class="px-3.5 py-2.5 font-semibold border-b">Cases</th>
                            <th class="px-3.5 py-2.5 font-semibold border-b text-right">Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($chapterPerformance as $chapter)
                            <tr>
                                <td class="px-3.5 py-2.5 border-b">{{ $chapter->chapter }}</td>
                                <td class="px-3.5 py-2.5 border-b">{{ $chapter->cases }}</td>
                                <td class="px-3.5 py-2.5 border-b text-right font-semibold">
                                    ${{ number_format($chapter->revenue, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-3.5 py-2.5 text-center text-slate-500">No data
                                    available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Case Type Distribution -->
    <div class="card">
        <div class="card-body">
            <h6 class="mb-4 text-15">Case Type Distribution</h6>
            <div id="caseTypeChart" class="apex-charts"></div>
        </div>
    </div>

</div>

<!-- Recent Cases -->
<div class="card">
    <div class="card-body">
        <h6 class="mb-4 text-15">Recent Cases</h6>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="ltr:text-left rtl:text-right">
                    <tr>
                        <th class="px-3.5 py-2.5 font-semibold border-b">Client</th>
                        <th class="px-3.5 py-2.5 font-semibold border-b">Type</th>
                        <th class="px-3.5 py-2.5 font-semibold border-b">Date</th>
                        <th class="px-3.5 py-2.5 font-semibold border-b">Employee</th>
                        <th class="px-3.5 py-2.5 font-semibold border-b">Lawyer</th>
                        <th class="px-3.5 py-2.5 font-semibold border-b text-right">Service Fee</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentCases as $case)
                        <tr>
                            <td class="px-3.5 py-2.5 border-b">{{ $case->client_name }}</td>
                            <td class="px-3.5 py-2.5 border-b">
                                <span class="px-2 py-1 text-xs rounded bg-slate-100 text-slate-600 dark:bg-slate-500/20">
                                    {{ $case->type_case }}
                                </span>
                            </td>
                            <td class="px-3.5 py-2.5 border-b">{{ date('M d, Y', strtotime($case->date)) }}
                            </td>
                            <td class="px-3.5 py-2.5 border-b">{{ $case->employee }}</td>
                            <td class="px-3.5 py-2.5 border-b">{{ $case->lawyer }}</td>
                            <td class="px-3.5 py-2.5 border-b text-right font-semibold">
                                ${{ number_format($case->service_fee, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-3.5 py-2.5 text-center text-slate-500">No cases found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check if ApexCharts is loaded (should be from master layout)
            if (typeof ApexCharts === 'undefined') {
                console.error('ApexCharts is not defined. Please ensure the library is loaded.');
                return;
            }

            // 1. Revenue Trend Chart
            const revenueData = {!! $monthlyTrendJson !!};
            const revenueEl = document.querySelector("#revenueChart");
            if (revenueEl && revenueData.length > 0) {
                const revenueOptions = {
                    series: [{
                        name: 'Revenue',
                        data: revenueData.map(item => item.revenue)
                    }],
                    chart: {
                        height: 300,
                        type: 'area',
                        toolbar: { show: false }
                    },
                    dataLabels: { enabled: false },
                    stroke: { curve: 'smooth', width: 2 },
                    colors: ['#10b981'],
                    fill: {
                        type: 'gradient',
                        gradient: { shadeIntensity: 1, opacityFrom: 0.5, opacityTo: 0.1 }
                    },
                    xaxis: {
                        categories: revenueData.map(item => item.label)
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return "$" + val.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                            }
                        }
                    }
                };
                new ApexCharts(revenueEl, revenueOptions).render();
            }

            // 2. Case Type Distribution Chart
            const typeData = {!! $caseTypeDistributionJson !!};
            const typeEl = document.querySelector("#caseTypeChart");
            if (typeEl && typeData.length > 0) {
                const caseTypeOptions = {
                    series: typeData.map(item => item.count),
                    chart: {
                        height: 300,
                        type: 'donut',
                    },
                    labels: typeData.map(item => item.type),
                    colors: ['#3b82f6', '#8b5cf6', '#f59e0b', '#10b981', '#ef4444', '#06b6d4'],
                    legend: { position: 'bottom' },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return val + " cases";
                            }
                        }
                    }
                };
                new ApexCharts(typeEl, caseTypeOptions).render();
            }
        });
    </script>
@endpush