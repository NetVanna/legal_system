@extends('layouts.master')

@section('sidebar')
    <div id="scrollbar"
        class="group-data-[sidebar-size=md]:max-h-[calc(100vh_-_theme('spacing.header')_*_1.2)] group-data-[sidebar-size=lg]:max-h-[calc(100vh_-_theme('spacing.header')_*_1.2)] group-data-[layout=horizontal]:h-56 group-data-[layout=horizontal]:md:h-auto group-data-[layout=horizontal]:overflow-auto group-data-[layout=horizontal]:md:overflow-visible group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:mx-auto">
        @include('sidebar.sidebar')
    </div>
@endsection

@section('content')
    <div
        class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

            <!-- Breadcrumb -->
            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">HR Dashboard</h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li
                        class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1 before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="#!" class="text-slate-400 dark:text-zink-200">Dashboards</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">HR</li>
                </ul>
            </div>

            <!-- Admin Quick Actions -->
            <div class="flex flex-wrap items-center gap-3 mb-5">
                <a href="{{ route('employee.manage.index') }}"
                    class="btn bg-custom-500 border-custom-500 text-white hover:bg-custom-600 hover:border-custom-600 focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                    <i data-lucide="user-plus" class="inline-block w-4 h-4 mr-1"></i> Add Employee
                </a>
                <a href="{{ route('client.index') }}"
                    class="btn bg-green-500 border-green-500 text-white hover:bg-green-600 hover:border-green-600 focus:ring focus:ring-green-200 active:bg-green-700 active:border-green-700">

                    <i data-lucide="users" class="inline-block w-4 h-4 mr-1"></i>
                    Add Client
                </a>
                <a href="{{ route('manage.benefit.case.list') }}"
                    class="btn bg-purple-500 border-purple-500 text-white hover:bg-purple-600 hover:border-purple-600 focus:bg-purple-600 focus:border-purple-600 focus:ring focus:ring-purple-100 active:bg-purple-600 active:border-purple-600 active:ring active:ring-purple-100 dark:ring-purple-400/20">
                    <i data-lucide="briefcase" class="inline-block w-4 h-4 mr-1"></i> Manage Cases
                </a>
                <a href="{{ route('chapter_department.index') }}"
                    class="btn bg-orange-500 border-orange-500 text-white hover:bg-orange-600 hover:border-orange-600 focus:bg-orange-600 focus:border-orange-600 focus:ring focus:ring-orange-100 active:bg-orange-600 active:border-orange-600 active:ring active:ring-orange-100 dark:ring-orange-400/20">
                    <i data-lucide="building" class="inline-block w-4 h-4 mr-1"></i> Departments
                </a>
            </div>

            <!-- System Overview Cards -->
            <h6 class="mb-4 text-15">System Overview</h6>
            <div class="grid grid-cols-1 gap-x-5 md:grid-cols-2 xl:grid-cols-4 mb-5">
                <!-- Active Users -->
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex items-center justify-center w-12 h-12 rounded-md bg-emerald-100 dark:bg-emerald-500/20">
                                <i data-lucide="user-check" class="w-6 h-6 text-emerald-500"></i>
                            </div>
                            <div class="grow">
                                <h6 class="mb-1 text-15">Active Users</h6>
                                <p class="text-slate-500 dark:text-zink-200">Total System Access</p>
                            </div>
                        </div>
                        <div class="flex items-end justify-between mt-4">
                            <h4 class="text-24">{{ number_format($activeUsers ?? 0) }}</h4>
                        </div>
                    </div>
                </div>

                <!-- Inactive Users -->
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex items-center justify-center w-12 h-12 rounded-md bg-rose-100 dark:bg-rose-500/20">
                                <i data-lucide="user-minus" class="w-6 h-6 text-rose-500"></i>
                            </div>
                            <div class="grow">
                                <h6 class="mb-1 text-15">Inactive Users</h6>
                                <p class="text-slate-500 dark:text-zink-200">Suspended / Left</p>
                            </div>
                        </div>
                        <div class="flex items-end justify-between mt-4">
                            <h4 class="text-24">{{ number_format($inactiveUsers ?? 0) }}</h4>
                        </div>
                    </div>
                </div>

                <!-- Total Departments -->
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex items-center justify-center w-12 h-12 rounded-md bg-sky-100 dark:bg-sky-500/20">
                                <i data-lucide="network" class="w-6 h-6 text-sky-500"></i>
                            </div>
                            <div class="grow">
                                <h6 class="mb-1 text-15">Departments</h6>
                                <p class="text-slate-500 dark:text-zink-200">Chapters Registered</p>
                            </div>
                        </div>
                        <div class="flex items-end justify-between mt-4">
                            <h4 class="text-24">{{ number_format($totalDepartments ?? 0) }}</h4>
                        </div>
                    </div>
                </div>

                <!-- Roles / Positions -->
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex items-center justify-center w-12 h-12 rounded-md bg-amber-100 dark:bg-amber-500/20">
                                <i data-lucide="shield" class="w-6 h-6 text-amber-500"></i>
                            </div>
                            <div class="grow">
                                <h6 class="mb-1 text-15">Total Roles</h6>
                                <p class="text-slate-500 dark:text-zink-200">Positions Configured</p>
                            </div>
                        </div>
                        <div class="flex items-end justify-between mt-4">
                            <h4 class="text-24">{{ number_format($totalPositions ?? 0) }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h6 class="mb-4 text-15">Global Organization Analytics</h6>
            </div>

            @include('components.dashboard-stats')

        </div>
    </div>
@endsection