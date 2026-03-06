@extends('layouts.master')
{{-- left sidebar --}}
@section('sidebar')
    <div id="scrollbar"
        class="group-data-[sidebar-size=md]:max-h-[calc(100vh_-_theme('spacing.header')_*_1.2)] group-data-[sidebar-size=lg]:max-h-[calc(100vh_-_theme('spacing.header')_*_1.2)] group-data-[layout=horizontal]:h-56 group-data-[layout=horizontal]:md:h-auto group-data-[layout=horizontal]:overflow-auto group-data-[layout=horizontal]:md:overflow-visible group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:mx-auto">
        @include('sidebar.sidebar')
        <!-- Left Sidebar End -->
    </div>
@endsection
{{-- content --}}
@section('content')
    <style id="baseStyles">
        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 12px;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .modal-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .modal-buttons {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .modal-btn {
            padding: 12px 20px;
            border-radius: 8px;
            border: none;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .modal-btn-portrait {
            background-color: #3b82f6;
            color: white;
        }

        .modal-btn-portrait:hover {
            background-color: #2563eb;
        }

        .modal-btn-landscape {
            background-color: #10b981;
            color: white;
        }

        .modal-btn-landscape:hover {
            background-color: #059669;
        }

        .modal-btn-cancel {
            background-color: #6b7280;
            color: white;
        }

        .modal-btn-cancel:hover {
            background-color: #4b5563;
        }

        /* Print Styles */
        @media print {

            /* Hide non-printable elements */
            .print-hidden {
                display: none !important;
            }

            body {
                margin: 0;
                padding: 0;
                font-size: 11px;
            }

            /* Card adjustments */
            .card {
                box-shadow: none !important;
                border: none !important;
            }

            .card-body {
                padding: 0 !important;
            }

            /* Header styling for print */
            .print-header {
                margin-bottom: 15px;
                border-bottom: 2px solid #000;
                padding-bottom: 10px;
            }

            .print-header h5 {
                font-size: 16px;
                font-weight: bold;
                margin: 0;
            }

            .print-header h3 {
                font-size: 18px;
                font-weight: bold;
                margin: 0;
            }

            .print-header p {
                font-size: 10px;
                margin: 2px 0;
            }

            /* Table styling */
            table {
                width: 100% !important;
                border-collapse: collapse;
                font-size: 9px;
                margin-top: 10px;
            }

            th {
                background-color: #f3f4f6 !important;
                font-weight: bold;
                padding: 6px 4px !important;
                border: 1px solid #000 !important;
                text-align: center;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            td {
                padding: 5px 4px !important;
                border: 1px solid #666 !important;
                text-align: center;
                word-wrap: break-word;
            }

            /* Footer for print */
            .print-footer {
                margin-top: 30px;
                font-size: 10px;
            }

            .print-footer .summary-section {
                margin-bottom: 20px;
                page-break-inside: avoid;
            }

            .print-footer h4 {
                font-size: 12px;
                font-weight: bold;
                margin-bottom: 8px;
                padding-bottom: 5px;
                border-bottom: 2px solid #000;
            }

            .print-footer table {
                font-size: 9px;
                width: 100%;
                border-collapse: collapse;
            }

            .print-footer th {
                background-color: #e5e7eb !important;
                padding: 5px 8px !important;
                border: 1px solid #000 !important;
                font-weight: bold;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .print-footer td {
                padding: 4px 8px !important;
                border: 1px solid #666 !important;
            }

            /* Totals row styling */
            .totals-row {
                font-weight: bold !important;
                background-color: #e5e7eb !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            /* Remove background colors on screen elements */
            .bg-slate-50,
            .dark\:bg-zink-600 {
                background-color: white !important;
            }
        }
    </style>

    <!-- Dynamic print orientation styles -->
    <style id="printOrientationStyle"></style>

    <!-- Print Orientation Modal -->
    <div id="printModal" class="modal-overlay">
        <div class="modal-content">
            <h3 class="modal-title">Select Print Orientation</h3>
            <div class="modal-buttons">
                <button onclick="printDocument('portrait')" class="modal-btn modal-btn-portrait">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                        <line x1="12" y1="18" x2="12.01" y2="18"></line>
                    </svg>
                    Portrait (Vertical)
                </button>
                <button onclick="printDocument('landscape')" class="modal-btn modal-btn-landscape">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="5" width="20" height="14" rx="2" ry="2"></rect>
                        <line x1="6" y1="12" x2="6.01" y2="12"></line>
                    </svg>
                    Landscape (Horizontal)
                </button>
                <button onclick="closeModal()" class="modal-btn modal-btn-cancel">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">
        <div
            class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4">

            <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
                <div class="grid grid-cols-1 gap-x-5 xl:grid-cols-12 mt-5">
                    <div class="xl:col-span-12">
                        <div class="card print:shadow-none print:border-none">
                            {{-- Header with buttons (hidden in print) --}}
                            <div class="card-body print-hidden space-y-6">

                                <!-- Header -->
                                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                    <div>
                                        <h6 class="text-lg font-semibold text-slate-800 dark:text-zink-100">
                                            Benefit Cases
                                        </h6>
                                        <p class="text-sm text-slate-500 dark:text-zink-300">
                                            Created: {{ \Carbon\Carbon::now()->format('d F, Y') }}
                                        </p>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex flex-wrap items-center gap-3">
                                        <button onclick="openModal()" type="button"
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-custom-500 text-white text-sm font-medium
                       hover:bg-custom-600 focus:ring-2 focus:ring-custom-200 transition shadow">
                                            <i data-lucide="printer" class="size-4"></i>
                                            Print
                                        </button>

                                        <a href="{{ route('manage.benefit.create.case.list') }}"
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-custom-100 text-custom-600 text-sm font-medium
                       hover:bg-custom-600 hover:text-white transition shadow">
                                            <i class="ri-add-line"></i>
                                            Add Benefit Cases
                                        </a>
                                    </div>
                                </div>

                                <!-- Filter Section -->
                                <div
                                    class="p-5 rounded-xl bg-white dark:bg-zink-700 border border-slate-200 dark:border-zink-600 shadow-sm">
                                    <form method="GET" action="{{ route('manage.benefit.case.list') }}"
                                        class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

                                        <!-- Month -->
                                        <div>
                                            <label class="block mb-1 text-sm font-medium text-slate-700 dark:text-zink-200">
                                                Month
                                            </label>
                                            <select name="month"
                                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                                <option value="">All Months</option>
                                                @foreach (range(1, 12) as $m)
                                                    <option value="{{ $m }}"
                                                        {{ request('month') == $m ? 'selected' : '' }}>
                                                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Year -->
                                        <div>
                                            <label class="block mb-1 text-sm font-medium text-slate-700 dark:text-zink-200">
                                                Year
                                            </label>
                                            <select name="year"
                                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                                <option value="">All Years</option>
                                                @for ($y = date('Y'); $y >= date('Y') - 10; $y--)
                                                    <option value="{{ $y }}"
                                                        {{ request('year') == $y ? 'selected' : '' }}>
                                                        {{ $y }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>

                                        <!-- Buttons -->
                                        <div class="flex gap-3 md:col-span-2">
                                            <!-- Apply Button -->
                                            <button type="submit"
                                                class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5
               rounded-md btn bg-custom-500 border-custom-500 text-white text-sm font-medium
               hover:bg-custom-600 hover:border-custom-600
               focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100
               active:bg-custom-700 active:border-custom-700
               transition-all dark:ring-custom-400/20">
                                                <i data-lucide="filter" class="size-4"></i>
                                                Apply Filter
                                            </button>

                                            <!-- Clear Button -->
                                            <a href="{{ route('manage.benefit.case.list') }}"
                                                class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5
               rounded-md border border-slate-300 dark:border-zink-500
               bg-white dark:bg-zink-700
               text-slate-700 dark:text-zink-200 text-sm font-medium
               hover:bg-slate-100 dark:hover:bg-zink-600
               focus:ring focus:ring-slate-200 dark:ring-zink-400/20
               transition-all">
                                                <i data-lucide="x" class="size-4"></i>
                                                Clear
                                            </a>
                                        </div>

                                    </form>

                                    <!-- Active Filter -->
                                    @if (request('month') || request('year'))
                                        <div class="mt-4 flex items-center gap-2 text-sm text-blue-700 dark:text-blue-300">
                                            <i data-lucide="info" class="size-4"></i>
                                            <span class="font-medium">Active Filter:</span>

                                            @if (request('month'))
                                                <span class="px-2 py-0.5 rounded-full bg-blue-100 dark:bg-blue-800 text-xs">
                                                    {{ DateTime::createFromFormat('!m', request('month'))->format('F') }}
                                                </span>
                                            @endif

                                            @if (request('year'))
                                                <span class="px-2 py-0.5 rounded-full bg-blue-100 dark:bg-blue-800 text-xs">
                                                    {{ request('year') }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>

                        {{-- Printable content --}}
                        <div class="!pt-0 card-body">
                            <div class="p-5 rounded-md md:p-8 bg-slate-50 dark:bg-zink-600 print:p-0 print:bg-white">
                                {{-- Company Header --}}
                                <div class="print-header grid grid-cols-1 gap-5 xl:grid-cols-12">
                                    <div class="text-center xl:col-span-3 ltr:xl:text-left rtl:xl:text-right">
                                        <div
                                            class="flex items-center justify-center mx-auto rounded-md size-16 bg-slate-100 dark:bg-zink-600 xl:mx-0 print:bg-transparent">
                                            <img src="{{ asset('assets/images/logo/logo.jpg') }}" alt=""
                                                class="h-14 w-14">
                                        </div>
                                        <h5 class="mt-4 mb-1 text-lg font-bold">Norakseng Lawfirm</h5>
                                        <p class="text-slate-500 dark:text-zink-200 text-sm">Legal Services</p>
                                    </div>

                                    <div class="xl:col-span-6 text-center">
                                        <h3 class="text-xl font-bold mb-2">BENEFIT CASES REPORT</h3>
                                        <p class="text-sm text-slate-600">
                                            Generated on: {{ \Carbon\Carbon::now()->format('F d, Y') }}
                                        </p>
                                    </div>

                                    <div class="ltr:xl:text-right rtl:xl:text-left xl:col-span-3">
                                        <p class="mb-1 text-slate-500 dark:text-zink-200 text-sm">
                                            <strong>Email:</strong> info@noraksenglawfirm.com
                                        </p>
                                        <p class="mb-1 text-slate-500 dark:text-zink-200 text-sm">
                                            <strong>Website:</strong>
                                            <a href="https://www.noraksenglawfirm.com/" target="_blank"
                                                class="text-custom-500 underline">
                                                noraksenglawfirm.com
                                            </a>
                                        </p>
                                        <p class="text-slate-500 dark:text-zink-200 text-sm">
                                            <strong>Contact:</strong> 017 888 438
                                        </p>
                                    </div>
                                </div>

                                {{-- Table --}}
                                <div class="mt-6 overflow-x-auto">
                                    <table class="w-full border border-slate-300 dark:border-zinc-500">
                                        <thead class="bg-slate-100 dark:bg-zink-700">
                                            <tr>
                                                <th class="px-3 py-2 border">No.</th>
                                                <th class="px-3 py-2 border">Code Case</th>
                                                <th class="px-3 py-2 border">Client</th>
                                                <th class="px-3 py-2 border">Type</th>
                                                <th class="px-3 py-2 border">Date</th>
                                                <th class="px-3 py-2 border">SubChapter</th>
                                                <th class="px-3 py-2 border">Service Fee</th>
                                                <th class="px-3 py-2 border">Employee</th>
                                                <th class="px-3 py-2 border">Emp. Fee</th>
                                                <th class="px-3 py-2 border">Ch. Fee</th>
                                                <th class="px-3 py-2 border">Admin Fee</th>
                                                <th class="px-3 py-2 border">IT Fee</th>
                                                <th class="px-3 py-2 border">Lawyer</th>
                                                <th class="px-3 py-2 border">Law. Fee</th>
                                                <th class="px-3 py-2 border">Net Fee</th>
                                                <th class="px-3 py-2 border print-hidden">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $totalService = $totalEmployeeFee = $totalChapterFee = $totalAdminFee = $totalItFee = $totalLawyerFee = $totalNetFee = 0;
                                            @endphp

                                            @forelse ($benefits as $index => $benefit)
                                                @php
                                                    $totalService += $benefit->service_fee;
                                                    $totalEmployeeFee += $benefit->employee_fee;
                                                    $totalChapterFee += $benefit->chapter_fee;
                                                    $totalAdminFee += $benefit->admin_fee;
                                                    $totalItFee += $benefit->it_fee;
                                                    $totalLawyerFee += $benefit->lawyer_fee;
                                                    $totalNetFee += $benefit->net_fee;
                                                @endphp
                                                <tr class="hover:bg-slate-50 dark:hover:bg-zink-700">
                                                    <td class="px-3 py-2 border">{{ $index + 1 }}</td>
                                                    <td class="px-3 py-2 border">
                                                        {{ $benefit->case->case_number ?? 'N/A' }}</td>
                                                    <td class="px-3 py-2 border">{{ $benefit->client_name }}</td>
                                                    <td class="px-3 py-2 border">{{ $benefit->type_case }}</td>
                                                    <td class="px-3 py-2 border">
                                                        {{ \Carbon\Carbon::parse($benefit->date)->format('d/m/Y') }}
                                                    </td>
                                                    <td class="px-3 py-2 border">{{ $benefit->sub_chapter }}</td>
                                                    <td class="px-3 py-2 border">
                                                        ${{ number_format($benefit->service_fee, 2) }}</td>
                                                    <td class="px-3 py-2 border">{{ $benefit->employee }}</td>
                                                    <td class="px-3 py-2 border">
                                                        ${{ number_format($benefit->employee_fee, 2) }}</td>
                                                    <td class="px-3 py-2 border">
                                                        ${{ number_format($benefit->chapter_fee, 2) }}</td>
                                                    <td class="px-3 py-2 border">
                                                        ${{ number_format($benefit->admin_fee, 2) }}</td>
                                                    <td class="px-3 py-2 border">
                                                        ${{ number_format($benefit->it_fee, 2) }}</td>
                                                    <td class="px-3 py-2 border">{{ $benefit->lawyer }}</td>
                                                    <td class="px-3 py-2 border">
                                                        ${{ number_format($benefit->lawyer_fee, 2) }}</td>
                                                    <td class="px-3 py-2 border">
                                                        ${{ number_format($benefit->net_fee, 2) }}</td>
                                                    <td class="px-3 py-2 border print-hidden">
                                                        <div class="flex justify-center gap-2">

                                                            <a href="{{ route('manage.benefit.edit.case', $benefit->id) }}"
                                                                id="updateRecord"
                                                                class="editClientBtn flex items-center justify-center transition-all duration-200 ease-linear rounded-md size-8 bg-slate-100 dark:bg-zink-600 dark:text-zink-200 text-slate-500 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-100 dark:hover:bg-custom-500/20">
                                                                <i data-lucide="pencil" class="size-4"></i>
                                                            </a>
                                                            {{-- <a href="#!" data-modal-target="deleteModal"
                                                                    id="deleteRecord"
                                                                    class="flex items-center justify-center transition-all duration-200 ease-linear rounded-md size-8 bg-slate-100 dark:bg-zink-600 dark:text-zink-200 text-slate-500 hover:text-red-500 dark:hover:text-red-500 hover:bg-red-100 dark:hover:bg-red-500/20" ><i
                                                                        data-lucide="trash-2" class="size-4"></i></a> --}}

                                                            <form
                                                                action="{{ route('manage.benefit.delete.case', $benefit->id) }}"
                                                                method="POST" onsubmit="return confirm('Are you sure?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="flex items-center justify-center transition-all duration-200 ease-linear rounded-md size-8 bg-slate-100 dark:bg-zink-600 dark:text-zink-200 text-slate-500 hover:text-red-500 dark:hover:text-red-500 hover:bg-red-100 dark:hover:bg-red-500/20"><i
                                                                        data-lucide="trash-2" class="size-4"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="16" class="text-center py-8 border">
                                                        <div class="flex flex-col items-center justify-center gap-3">
                                                            <i data-lucide="inbox" class="size-12 text-slate-400"></i>
                                                            <div>
                                                                <p class="text-slate-600 dark:text-zink-300 font-medium">
                                                                    No records found
                                                                </p>
                                                                @if (request('month') || request('year'))
                                                                    <p
                                                                        class="text-sm text-slate-500 dark:text-zink-400 mt-1">
                                                                        Try adjusting your filter criteria
                                                                    </p>
                                                                    <a href="{{ route('manage.benefit.case.list') }}"
                                                                        class="inline-flex items-center gap-1 text-custom-500 hover:text-custom-600 text-sm mt-2">
                                                                        <i data-lucide="refresh-ccw" class="size-3"></i>
                                                                        Clear filters
                                                                    </a>
                                                                @else
                                                                    <p
                                                                        class="text-sm text-slate-500 dark:text-zink-400 mt-1">
                                                                        No benefit cases have been created yet
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse

                                            {{-- Grand Totals Row --}}
                                            @if ($benefits->count() > 0)
                                                <tr class="totals-row bg-slate-100 dark:bg-zink-700 font-bold">
                                                    <td colspan="6" class="px-3 py-2 border text-right">
                                                        <strong>GRAND TOTALS:</strong>
                                                    </td>
                                                    <td class="px-3 py-2 border">
                                                        ${{ number_format($totalService, 2) }}</td>
                                                    <td class="px-3 py-2 border"></td>
                                                    <td class="px-3 py-2 border">
                                                        ${{ number_format($totalEmployeeFee, 2) }}</td>
                                                    <td class="px-3 py-2 border">
                                                        ${{ number_format($totalChapterFee, 2) }}</td>
                                                    <td class="px-3 py-2 border">
                                                        ${{ number_format($totalAdminFee, 2) }}</td>
                                                    <td class="px-3 py-2 border">
                                                        ${{ number_format($totalItFee, 2) }}</td>
                                                    <td class="px-3 py-2 border"></td>
                                                    <td class="px-3 py-2 border">
                                                        ${{ number_format($totalLawyerFee, 2) }}</td>
                                                    <td class="px-3 py-2 border">
                                                        ${{ number_format($totalNetFee, 2) }}</td>
                                                    <td class="px-3 py-2 border print-hidden"></td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Print Footer - Now visible on screen and in print --}}
                                <div class="print-footer mt-8">
                                    @if ($benefits->count() > 0)
                                        {{-- Summary by SubChapter --}}
                                        <div class="summary-section mb-6">
                                            <h4
                                                class="font-bold text-base mb-3 text-left border-b-2 border-slate-700 pb-2">
                                                SUMMARY BY SUBCHAPTER
                                            </h4>
                                            <table class="w-full text-sm">
                                                <thead>
                                                    <tr class="bg-slate-200">
                                                        <th class="border px-2 py-2 text-left">SubChapter</th>
                                                        <th class="border px-2 py-2 text-right">Cases</th>
                                                        <th class="border px-2 py-2 text-right">Service Fee</th>
                                                        <th class="border px-2 py-2 text-right">Chapter Fee</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $subChapterGroups = $benefits->groupBy('sub_chapter');
                                                    @endphp
                                                    @foreach ($subChapterGroups as $subChapter => $group)
                                                        <tr>
                                                            <td class="border px-2 py-2">{{ $subChapter ?: 'N/A' }}
                                                            </td>
                                                            <td class="border px-2 py-2 text-right">
                                                                {{ $group->count() }}</td>
                                                            <td class="border px-2 py-2 text-right">
                                                                ${{ number_format($group->sum('service_fee'), 2) }}
                                                            </td>
                                                            <td class="border px-2 py-2 text-right">
                                                                ${{ number_format($group->sum('chapter_fee'), 2) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        {{-- Summary by Employee --}}
                                        <div class="summary-section mb-6">
                                            <h4
                                                class="font-bold text-base mb-3 text-left border-b-2 border-slate-700 pb-2">
                                                SUMMARY BY EMPLOYEE
                                            </h4>
                                            <table class="w-full text-sm">
                                                <thead>
                                                    <tr class="bg-slate-200">
                                                        <th class="border px-2 py-2 text-left">Employee</th>
                                                        <th class="border px-2 py-2 text-right">Cases</th>
                                                        <th class="border px-2 py-2 text-right">Service Fee</th>
                                                        <th class="border px-2 py-2 text-right">Employee Fee</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $employeeGroups = $benefits->groupBy('employee');
                                                    @endphp
                                                    @foreach ($employeeGroups as $employee => $group)
                                                        <tr>
                                                            <td class="border px-2 py-2">{{ $employee ?: 'N/A' }}</td>
                                                            <td class="border px-2 py-2 text-right">
                                                                {{ $group->count() }}</td>
                                                            <td class="border px-2 py-2 text-right">
                                                                ${{ number_format($group->sum('service_fee'), 2) }}
                                                            </td>
                                                            <td class="border px-2 py-2 text-right">
                                                                ${{ number_format($group->sum('employee_fee'), 2) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        {{-- Summary by Lawyer --}}
                                        <div class="summary-section mb-6">
                                            <h4
                                                class="font-bold text-base mb-3 text-left border-b-2 border-slate-700 pb-2">
                                                SUMMARY BY LAWYER
                                            </h4>
                                            <table class="w-full text-sm">
                                                <thead>
                                                    <tr class="bg-slate-200">
                                                        <th class="border px-2 py-2 text-left">Lawyer</th>
                                                        <th class="border px-2 py-2 text-right">Cases</th>
                                                        <th class="border px-2 py-2 text-right">Service Fee</th>
                                                        <th class="border px-2 py-2 text-right">Lawyer Fee</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $lawyerGroups = $benefits->groupBy('lawyer');
                                                    @endphp
                                                    @foreach ($lawyerGroups as $lawyer => $group)
                                                        <tr>
                                                            <td class="border px-2 py-2">{{ $lawyer ?: 'N/A' }}</td>
                                                            <td class="border px-2 py-2 text-right">
                                                                {{ $group->count() }}</td>
                                                            <td class="border px-2 py-2 text-right">
                                                                ${{ number_format($group->sum('service_fee'), 2) }}
                                                            </td>
                                                            <td class="border px-2 py-2 text-right">
                                                                ${{ number_format($group->sum('lawyer_fee'), 2) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        {{-- NEW: Summary of Admin Fee --}}
                                        <div class="summary-section mb-6">
                                            <h4
                                                class="font-bold text-base mb-3 text-left border-b-2 border-slate-700 pb-2">
                                                ADMIN FEE SUMMARY
                                            </h4>
                                            <table class="w-full text-sm">
                                                <thead>
                                                    <tr class="bg-slate-200">
                                                        <th class="border px-2 py-2 text-left">Description</th>
                                                        <th class="border px-2 py-2 text-right">Total Cases</th>
                                                        <th class="border px-2 py-2 text-right">Total Admin Fee</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="border px-2 py-2 font-semibold">Admin Fee Total</td>
                                                        <td class="border px-2 py-2 text-right">
                                                            {{ $benefits->count() }}</td>
                                                        <td class="border px-2 py-2 text-right">
                                                            ${{ number_format($benefits->sum('admin_fee'), 2) }}</td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        {{-- NEW: Summary of IT Fee --}}
                                        <div class="summary-section mb-6">
                                            <h4
                                                class="font-bold text-base mb-3 text-left border-b-2 border-slate-700 pb-2">
                                                IT FEE SUMMARY
                                            </h4>
                                            <table class="w-full text-sm">
                                                <thead>
                                                    <tr class="bg-slate-200">
                                                        <th class="border px-2 py-2 text-left">Description</th>
                                                        <th class="border px-2 py-2 text-right">Total Cases</th>
                                                        <th class="border px-2 py-2 text-right">Total IT Fee</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="border px-2 py-2 font-semibold">IT Fee Total</td>
                                                        <td class="border px-2 py-2 text-right">
                                                            {{ $benefits->count() }}</td>
                                                        <td class="border px-2 py-2 text-right">
                                                            ${{ number_format($benefits->sum('it_fee'), 2) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        {{-- NEW: Summary of Net Fee --}}
                                        <div class="summary-section mb-6">
                                            <h4
                                                class="font-bold text-base mb-3 text-left border-b-2 border-slate-700 pb-2">
                                                NET FEE SUMMARY
                                            </h4>
                                            <table class="w-full text-sm">
                                                <thead>
                                                    <tr class="bg-slate-200">
                                                        <th class="border px-2 py-2 text-left">Description</th>
                                                        <th class="border px-2 py-2 text-right">Total Cases</th>
                                                        <th class="border px-2 py-2 text-right">Total Net Fee</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="border px-2 py-2 font-semibold">Net Fee Total</td>
                                                        <td class="border px-2 py-2 text-right">
                                                            {{ $benefits->count() }}</td>
                                                        <td class="border px-2 py-2 text-right">
                                                            ${{ number_format($benefits->sum('net_fee'), 2) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        {{-- Overall Summary --}}
                                        <div class="summary-section mb-6">
                                            <h4
                                                class="font-bold text-base mb-3 text-left border-b-2 border-slate-700 pb-2">
                                                OVERALL FINANCIAL SUMMARY
                                            </h4>
                                            <table class="w-full text-sm">
                                                <thead>
                                                    <tr class="bg-slate-200">
                                                        <th class="border px-2 py-2 text-left">Fee Type</th>
                                                        <th class="border px-2 py-2 text-right">Total Amount</th>
                                                        <th class="border px-2 py-2 text-right">Percentage of Service
                                                            Fee</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalServiceFee = $benefits->sum('service_fee');
                                                    @endphp
                                                    <tr>
                                                        <td class="border px-2 py-2">Service Fee</td>
                                                        <td class="border px-2 py-2 text-right font-semibold">
                                                            ${{ number_format($totalServiceFee, 2) }}</td>
                                                        <td class="border px-2 py-2 text-right">100.00%</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border px-2 py-2">Employee Fee</td>
                                                        <td class="border px-2 py-2 text-right">
                                                            ${{ number_format($benefits->sum('employee_fee'), 2) }}
                                                        </td>
                                                        <td class="border px-2 py-2 text-right">
                                                            {{ $totalServiceFee > 0 ? number_format(($benefits->sum('employee_fee') / $totalServiceFee) * 100, 2) : '0.00' }}%
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border px-2 py-2">Chapter Fee</td>
                                                        <td class="border px-2 py-2 text-right">
                                                            ${{ number_format($benefits->sum('chapter_fee'), 2) }}</td>
                                                        <td class="border px-2 py-2 text-right">
                                                            {{ $totalServiceFee > 0 ? number_format(($benefits->sum('chapter_fee') / $totalServiceFee) * 100, 2) : '0.00' }}%
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border px-2 py-2">Admin Fee</td>
                                                        <td class="border px-2 py-2 text-right">
                                                            ${{ number_format($benefits->sum('admin_fee'), 2) }}</td>
                                                        <td class="border px-2 py-2 text-right">
                                                            {{ $totalServiceFee > 0 ? number_format(($benefits->sum('admin_fee') / $totalServiceFee) * 100, 2) : '0.00' }}%
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border px-2 py-2">IT Fee</td>
                                                        <td class="border px-2 py-2 text-right">
                                                            ${{ number_format($benefits->sum('it_fee'), 2) }}</td>
                                                        <td class="border px-2 py-2 text-right">
                                                            {{ $totalServiceFee > 0 ? number_format(($benefits->sum('it_fee') / $totalServiceFee) * 100, 2) : '0.00' }}%
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border px-2 py-2">Lawyer Fee</td>
                                                        <td class="border px-2 py-2 text-right">
                                                            ${{ number_format($benefits->sum('lawyer_fee'), 2) }}</td>
                                                        <td class="border px-2 py-2 text-right">
                                                            {{ $totalServiceFee > 0 ? number_format(($benefits->sum('lawyer_fee') / $totalServiceFee) * 100, 2) : '0.00' }}%
                                                        </td>
                                                    </tr>
                                                    <tr class="bg-slate-300 font-bold">
                                                        <td class="border px-2 py-2">Net Fee</td>
                                                        <td class="border px-2 py-2 text-right">
                                                            ${{ number_format($benefits->sum('net_fee'), 2) }}</td>
                                                        <td class="border px-2 py-2 text-right">
                                                            {{ $totalServiceFee > 0 ? number_format(($benefits->sum('net_fee') / $totalServiceFee) * 100, 2) : '0.00' }}%
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif

                                    <div class="mt-8 pt-4 border-t-2 border-slate-800">
                                        <p class="text-center text-xs">This is a computer-generated document. No
                                            signature is required.</p>
                                        <p class="text-center text-xs">© {{ date('Y') }} Norakseng Lawfirm. All
                                            rights reserved.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('script')
        <script>
            function openModal() {
                document.getElementById('printModal').classList.add('active');
            }

            function closeModal() {
                document.getElementById('printModal').classList.remove('active');
            }

            function printDocument(orientation) {
                closeModal();

                // Get or create the style element
                let styleEl = document.getElementById('printOrientationStyle');

                // Set the appropriate CSS for the selected orientation
                if (orientation === 'landscape') {
                    styleEl.textContent = `
                    @page {
                        size: A4 landscape;
                        margin: 15mm;
                    }
                    @media print {
                        table {
                            font-size: 7px !important;
                        }
                        th, td {
                            padding: 4px 2px !important;
                        }
                        .print-header h5 {
                            font-size: 14px !important;
                        }
                        .print-header h3 {
                            font-size: 16px !important;
                        }
                        .print-header p {
                            font-size: 8px !important;
                        }
                    }
                `;
                } else {
                    styleEl.textContent = `
                    @page {
                        size: A4 portrait;
                        margin: 15mm;
                    }
                    @media print {
                        table {
                            font-size: 9px !important;
                        }
                        th, td {
                            padding: 6px 4px !important;
                        }
                    }
                `;
                }

                // Show print footer
                const footer = document.querySelector('.print-footer');
                if (footer) {
                    footer.style.display = 'block';
                }

                // Small delay to ensure styles are applied
                setTimeout(() => {
                    window.print();

                    // Cleanup after print dialog closes
                    setTimeout(() => {
                        if (footer) {
                            footer.style.display = 'block';
                        }
                    }, 1000);
                }, 250);
            }

            // Close modal when clicking outside
            document.getElementById('printModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeModal();
                }
            });
        </script>
    @endsection
@endsection
