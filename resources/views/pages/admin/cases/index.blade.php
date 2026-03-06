{{-- resources/views/cases/create.blade.php --}}
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
    <div
        class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4">
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

            {{-- Breadcrumb --}}
            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">Create A New Case</h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li
                        class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1 before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="{{ route('cases.index') }}" class="text-slate-400 dark:text-zink-200">Case</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">Create New</li>
                </ul>
            </div>

            {{-- Case Type Selection Cards --}}
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-4 text-16">Select Case Type</h5>
                    <p class="mb-6 text-slate-500 dark:text-zink-200">Please Select The Type Of Case You Want To Create</p>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">

                        {{-- Criminal Case Card --}}
                        <a href="{{ route('cases.criminal') }}"
                            class="card hover:shadow-lg transition-all duration-300 border-2 border-transparent hover:border-custom-500">
                            <div class="card-body">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex items-center justify-center size-12 rounded-md bg-custom-100 text-custom-500 dark:bg-custom-500/20">
                                        <i data-lucide="shield-alert" class="size-6"></i>
                                    </div>
                                    <div class="grow">
                                        <h6 class="mb-2 text-15">Criminal Case ({{ $casesCriminalCount }})</h6>
                                        <p class="text-slate-500 dark:text-zink-200 text-sm">Criminal Case
                                            And Other Crimes</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        {{-- Civil Case Card --}}
                        <a href="{{ route("cases.civil") }}"
                            class="card hover:shadow-lg transition-all duration-300 border-2 border-transparent hover:border-custom-500">
                            <div class="card-body">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex items-center justify-center size-12 rounded-md bg-sky-100 text-sky-500 dark:bg-sky-500/20">
                                        <i data-lucide="file-text" class="size-6"></i>
                                    </div>
                                    <div class="grow">
                                        <h6 class="mb-2 text-15">Civil Cases ({{ $casesCivilCount }})</h6>
                                        <p class="text-slate-500 dark:text-zink-200 text-sm">Civil Cases
                                            And Other Disputes</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        {{-- Protection Case Card --}}
                        <a href="{{ route("cases.protection") }}"
                            class="card hover:shadow-lg transition-all duration-300 border-2 border-transparent hover:border-custom-500">
                            <div class="card-body">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex items-center justify-center size-12 rounded-md bg-green-100 text-green-500 dark:bg-green-500/20">
                                        <i data-lucide="shield" class="size-6"></i>
                                    </div>
                                    <div class="grow">
                                        <h6 class="mb-2 text-15">Defendant Case ({{ $casesProtectionCount }})</h6>
                                        <p class="text-slate-500 dark:text-zink-200 text-sm">Protect Rights And Property
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        {{-- Alternative Dispute Resolution Card --}}
                        <a href="{{ route("cases.outcourt") }}"
                            class="card hover:shadow-lg transition-all duration-300 border-2 border-transparent hover:border-custom-500">
                            <div class="card-body">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex items-center justify-center size-12 rounded-md bg-purple-100 text-purple-500 dark:bg-purple-500/20">
                                        <i data-lucide="file-lock" class="size-6"></i>
                                    </div>
                                    <div class="grow">
                                        <h6 class="mb-2 text-15">Out-Of-Court Settlement ({{ $casesOutcourtCount }})</h6>
                                        <p class="text-slate-500 dark:text-zink-200 text-sm">Mediation And Reconciliation</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        {{-- Contract Card --}}
                        <a href="{{ route("cases.contract") }}"
                            class="card hover:shadow-lg transition-all duration-300 border-2 border-transparent hover:border-custom-500">
                            <div class="card-body">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex items-center justify-center size-12 rounded-md bg-orange-100 text-orange-500 dark:bg-orange-500/20">
                                        <i data-lucide="file-signature" class="size-6"></i>
                                    </div>
                                    <div class="grow">
                                        <h6 class="mb-2 text-15">Contracts And Agreements ({{ $casesContractCount }})</h6>
                                        <p class="text-slate-500 dark:text-zink-200 text-sm">Design And Seal Contracts
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        {{-- Business SOP Card --}}
                        <a href="{{ route("cases.sop") }}"
                            class="card hover:shadow-lg transition-all duration-300 border-2 border-transparent hover:border-custom-500">
                            <div class="card-body">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex items-center justify-center size-12 rounded-md bg-blue-100 text-blue-500 dark:bg-blue-500/20">
                                        <i data-lucide="book-open" class="size-6"></i>
                                    </div>
                                    <div class="grow">
                                        <h6 class="mb-2 text-15">Develop Business Standards ({{ $casesSOPCount }})</h6>
                                        <p class="text-slate-500 dark:text-zink-200 text-sm">Operating Standards (SOP)</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        {{-- Business Protection Card --}}
                        <a href="{{ route("cases.businessprotection") }}"
                            class="card hover:shadow-lg transition-all duration-300 border-2 border-transparent hover:border-custom-500">
                            <div class="card-body">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex items-center justify-center size-12 rounded-md bg-teal-100 text-teal-500 dark:bg-teal-500/20">
                                        <i data-lucide="briefcase" class="size-6"></i>
                                    </div>
                                    <div class="grow">
                                        <h6 class="mb-2 text-15">Business Support ({{ $casesBusinessProtectionCount }})</h6>
                                        <p class="text-slate-500 dark:text-zink-200 text-sm">Protect Business
                                            And Trade Rights</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        {{-- Family Protection Card --}}
                        <a href="{{ route("cases.familyprotection") }}"
                            class="card hover:shadow-lg transition-all duration-300 border-2 border-transparent hover:border-custom-500">
                            <div class="card-body">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex items-center justify-center size-12 rounded-md bg-pink-100 text-pink-500 dark:bg-pink-500/20">
                                        <i data-lucide="home" class="size-6"></i>
                                    </div>
                                    <div class="grow">
                                        <h6 class="mb-2 text-15">Family Support ({{ $casesFamilyProtectionCount }})</h6>
                                        <p class="text-slate-500 dark:text-zink-200 text-sm">Protect Family And Family Members
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        {{-- Personal Protection Card --}}
                        <a href="{{ route("cases.personalprotection") }}"
                            class="card hover:shadow-lg transition-all duration-300 border-2 border-transparent hover:border-custom-500">
                            <div class="card-body">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex items-center justify-center size-12 rounded-md bg-indigo-100 text-indigo-500 dark:bg-indigo-500/20">
                                        <i data-lucide="user-check" class="size-6"></i>
                                    </div>
                                    <div class="grow">
                                        <h6 class="mb-2 text-15">Personal Support ({{ $casesPersonalProtectionCount }})</h6>
                                        <p class="text-slate-500 dark:text-zink-200 text-sm">Protecting The Rights Of Individuals
                                            And Safety</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        {{-- Others Card --}}
                        <a href="{{ route("cases.othercase") }}"
                            class="card hover:shadow-lg transition-all duration-300 border-2 border-transparent hover:border-custom-500">
                            <div class="card-body">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex items-center justify-center size-12 rounded-md bg-slate-100 text-slate-500 dark:bg-slate-500/20">
                                        <i data-lucide="more-horizontal" class="size-6"></i>
                                    </div>
                                    <div class="grow">
                                        <h6 class="mb-2 text-15">Other ({{ $casesOtherCount }})</h6>
                                        <p class="text-slate-500 dark:text-zink-200 text-sm">Other Services</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
