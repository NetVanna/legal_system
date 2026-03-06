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
    <!-- Page-content -->
    <div
        class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
            <div class="mt-1 -ml-3 -mr-3 rounded-none card">
                <div class="card-body !px-2.5">
                    <div class="flex flex-col md:flex-row gap-5 items-start">
                        <div class="shrink-0">
                            @if(!empty($profileDetail->name))
                                @php
                                    $fullName = $profileDetail->name;
                                    $parts = explode(' ', $fullName);
                                    $initials = '';
                                    foreach (array_slice($parts, 0, 2) as $part) {
                                        if(!empty($part)) {
                                            $initials .= strtoupper(substr($part, 0, 1));
                                        }
                                    }
                                @endphp
                            @endif
                            <div class="relative flex items-center justify-center rounded-full shadow-md size-20 xl:size-28 bg-slate-100 overflow-hidden shrink-0">
                                @if(!empty($profileDetail->photo))
                                    <img src="{{ URL::to('assets/images/user/' . $profileDetail->photo) }}" alt="Profile Photo"
                                        class="object-cover w-full h-full">
                                @elseif($profileDetail->photo === null)
                                    <span class="font-semibold text-2xl tracking-wide bg-sky-100 text-sky-600 dark:bg-sky-500/20 dark:text-sky-500 uppercase flex items-center justify-center w-full h-full">
                                        {{ $initials }}
                                    </span>
                                @else
                                    <img src="{{ URL::to('assets/images/user/' . Session::get('photo')) }}" alt="Profile Photo"
                                        class="object-cover w-full h-full">
                                @endif
                            </div>
                        </div><!--end col-->
                        
                        <div class="grow flex flex-col gap-3 py-1">
                            <h5 class="mb-0 flex items-center gap-2 text-lg font-semibold">
                                @if(!empty($profileDetail->name))
                                    {{ $profileDetail->name }}
                                @else
                                    {{ Session::get('name') }}
                                @endif
                                <i data-lucide="badge-check"
                                    class="size-5 text-sky-500 fill-sky-100 dark:fill-custom-500/20"></i>
                            </h5>
                            
                            <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500 dark:text-zink-200">
                                @if($type === 'employee')
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="building-2"
                                            class="size-4 text-slate-400"></i>
                                        <span class="font-semibold px-2">{{ $profileDetail->chapter->name ?? 'N/A' }}</span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="user-circle"
                                            class="size-4 text-slate-400"></i>
                                        <span>{{ ucfirst($profileDetail->client_type ?? 'Individual') }} Client</span>
                                    </div>
                                    @if(!empty($profileDetail->address))
                                        <div class="flex items-center gap-1.5">
                                            <i data-lucide="map-pin"
                                                class="size-4 text-slate-400"></i>
                                            <span>{{ $profileDetail->address }}</span>
                                        </div>
                                    @endif
                                @endif
                            </div>

                            <ul
                                class="flex flex-wrap items-center mt-1 mb-1 text-center divide-x divide-slate-200 dark:divide-zink-500 rtl:divide-x-reverse">
                                <li class="px-5 ltr:first:ps-0 rtl:first:pe-0">
                                    <h5 class="text-sm font-bold mb-0">{{ $cases->count() }}</h5>
                                    <p class="text-slate-500 dark:text-zink-200 text-xs">Cases</p>
                                </li>
                                @if($type === 'employee')
                                    <li class="px-5">
                                        <h5 class="text-sm font-bold mb-0">{{ $clients->count() }}</h5>
                                        <p class="text-slate-500 dark:text-zink-200 text-xs">Clients</p>
                                    </li>
                                    <li class="px-5">
                                        <h5 class="text-sm font-bold mb-0 text-slate-700 dark:text-slate-200">{{ ucfirst($profileDetail->status ?? 'Active') }}</h5>
                                        <p class="text-slate-500 dark:text-zink-200 text-xs">Status</p>
                                    </li>
                                @else
                                    <li class="px-5">
                                        <h5 class="text-sm font-bold mb-0">{{ $profileDetail->client_code ?? 'N/A' }}</h5>
                                        <p class="text-slate-500 dark:text-zink-200 text-xs">Client Code</p>
                                    </li>
                                    <li class="px-5">
                                        <h5 class="text-sm font-bold mb-0">{{ ucfirst($profileDetail->client_type ?? 'Individual') }}</h5>
                                        <p class="text-slate-500 dark:text-zink-200 text-xs">Type</p>
                                    </li>
                                @endif
                            </ul>

                            <div class="flex flex-wrap items-center gap-3 text-sm text-slate-500 dark:text-zink-200 mt-1">
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="phone" class="size-4 text-slate-400"></i>
                                    <span>{{ $profileDetail->phone ?? 'N/A' }}</span>
                                </div>
                                <span class="size-1 rounded-full bg-slate-300 dark:bg-zink-500"></span>
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="mail" class="size-4 text-slate-400"></i>
                                    <span>{{ $profileDetail->email ?? 'N/A' }}</span>
                                </div>
                                @if($type !== 'employee' && !empty($profileDetail->company_name))
                                    <span class="size-1 rounded-full bg-slate-300 dark:bg-zink-500"></span>
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="building" class="size-4 text-slate-400"></i>
                                        <span>{{ $profileDetail->company_name }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!--end grid-->
                </div>

                <div class="card-body !px-2.5 !py-0">
                    <ul class="flex flex-wrap w-full text-sm font-medium text-center nav-tabs">
                        <li class="group active">
                            <a href="javascript:void(0);" data-tab-toggle="" data-target="overviewTabs"
                                class="inline-block px-4 py-2 text-base transition-all duration-300 ease-linear rounded-t-md text-slate-500 dark:text-zink-200 border-b border-transparent group-[.active]:text-custom-500 dark:group-[.active]:text-custom-500 group-[.active]:border-b-custom-500 dark:group-[.active]:border-b-custom-500 hover:text-custom-500 dark:hover:text-custom-500 active:text-custom-500 dark:active:text-custom-500 -mb-[1px]">Overview</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!--end card-->
            <div class="tab-content">
                <div class="block tab-pane" id="overviewTabs">
                    <div class="grid grid-cols-1 gap-x-5 xl:grid-cols-12">
                        <!--== Personal Information Card ==-->
                        <div class="xl:col-span-4">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="mb-4 text-15">Personal Information</h6>
                                    <div class="overflow-x-auto">
                                        <table class="w-full ltr:text-left rtl:text-right">
                                            <tbody>
                                                @if($type === 'employee')
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0 w-1/2" scope="row">Employee ID</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                                            {{ $profileDetail->employee_id ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0" scope="row">Position</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                                            {{ $profileDetail->position->name ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0" scope="row">Role</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                                            {{ ucfirst($profileDetail->role ?? 'N/A') }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0" scope="row">Department</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                                            {{ $profileDetail->chapter->name ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0" scope="row">Sub-Dept</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                                            {{ $profileDetail->subChapter->name ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0" scope="row">Gender</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                                            {{ ucfirst($profileDetail->gender ?? 'N/A') }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0" scope="row">Date of Birth</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                                            {{ $profileDetail->date_birth ? \Carbon\Carbon::parse($profileDetail->date_birth)->format('d M, Y') : 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0" scope="row">Phone</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                                            {{ $profileDetail->phone ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0" scope="row">Email</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                                            {{ $profileDetail->email ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0" scope="row">Address</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                                            {{ $profileDetail->address ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="pt-2 font-semibold ps-0" scope="row">Status</th>
                                                        <td class="pt-2 text-right">
                                                            @php $status = $profileDetail->status ?? 'active'; @endphp
                                                            <span
                                                                class="px-2 py-0.5 text-xs font-medium rounded border
                                                                                                                                                                                {{ $status === 'active' ? 'bg-green-100 border-transparent text-green-500 dark:bg-green-500/20' : ($status === 'inactive' ? 'bg-slate-100 border-transparent text-slate-500 dark:bg-slate-500/20' : 'bg-red-100 border-transparent text-red-500 dark:bg-red-500/20') }}">
                                                                {{ ucfirst($status) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="pt-2 font-semibold ps-0" scope="row">Joined</th>
                                                        <td class="pt-2 text-right text-slate-500 dark:text-zink-200">
                                                            {{ $profileDetail->created_at ? $profileDetail->created_at->format('d M, Y') : 'N/A' }}
                                                        </td>
                                                    </tr>
                                                @else
                                                    {{-- CLIENT fields --}}
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0 w-1/2" scope="row">Client Code</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                                            {{ $profileDetail->client_code ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0" scope="row">Client Type</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                                            {{ ucfirst($profileDetail->client_type ?? 'Individual') }}
                                                        </td>
                                                    </tr>
                                                    @if(!empty($profileDetail->company_name))
                                                        <tr>
                                                            <th class="py-2 font-semibold ps-0" scope="row">Company</th>
                                                            <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                                                {{ $profileDetail->company_name }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0" scope="row">Gender</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                                            {{ ucfirst($profileDetail->gender ?? 'N/A') }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0" scope="row">Date of Birth</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                                            {{ $profileDetail->birth_date ? $profileDetail->birth_date->format('d M, Y') : 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0" scope="row">ID Card No.</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                                            {{ $profileDetail->id_card_num ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0" scope="row">Phone</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                                            {{ $profileDetail->phone ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0" scope="row">Email</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                                            {{ $profileDetail->email ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0" scope="row">Address</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                                            {{ $profileDetail->address ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0" scope="row">Instructor</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                                            {{ $profileDetail->instructor->name ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="pt-2 font-semibold ps-0" scope="row">Registered</th>
                                                        <td class="pt-2 text-right text-slate-500 dark:text-zink-200">
                                                            {{ $profileDetail->created_at ? $profileDetail->created_at->format('d M, Y') : 'N/A' }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--== Notes / Overview Card ==-->
                        <div class="xl:col-span-8">
                            {{-- Recent Cases Summary --}}
                            @if($cases->count() > 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3 text-15">Recent Cases</h6>
                                        <div class="overflow-x-auto">
                                            <table class="w-full align-middle text-sm">
                                                <thead>
                                                    <tr class="border-b border-slate-200 dark:border-zink-500">
                                                        <th class="py-2 font-semibold ps-0 text-left">Case Code</th>
                                                        <th class="py-2 font-semibold text-left">Title</th>
                                                        <th class="py-2 font-semibold text-left">Department</th>
                                                        <th class="py-2 font-semibold text-right">Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($cases->take(5) as $case)
                                                        <tr class="border-b border-slate-200 dark:border-zink-500">
                                                            <td class="py-2 ps-0 text-slate-500 dark:text-zink-200">
                                                                {{ $case->case_number ?? 'N/A' }}
                                                            </td>
                                                            <td class="py-2 text-slate-700 dark:text-zink-100">
                                                                {{ Str::limit($case->case_title ?? 'N/A', 40) }}
                                                            </td>
                                                            <td class="py-2 text-slate-500 dark:text-zink-200">
                                                                {{ $case->chapter->name ?? 'N/A' }}
                                                            </td>
                                                            <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                                                {{ ($case->filled_date ? \Carbon\Carbon::parse($case->filled_date) : $case->created_at)?->format('d M, Y') ?? 'N/A' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!--end grid-->
                </div>
                <!--end tab pane-->
                {{-- Documents tab removed for brevity - can be re-added later --}}
                <div class="hidden tab-pane" id="documentsTabs">
                    <div class="flex items-center gap-3 mb-4">
                        <h5 class="underline grow">Documents</h5>
                        <div class="shrink-0">
                            <button data-modal-target="addDocuments" type="button"
                                class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">Add
                                Document</button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full align-middle border-separate whitespace-nowrap border-spacing-y-1">
                            <thead class="text-left bg-white dark:bg-zink-700">
                                <tr>
                                    <th class="px-3.5 py-2.5 font-semibold border-b border-transparent">
                                        <div class="flex items-center h-full">
                                            <input id="Checkbox1"
                                                class="size-4 bg-white border border-slate-200 checked:bg-none dark:bg-zink-700 dark:border-zink-500 rounded-sm appearance-none arrow-none relative after:absolute after:content-['\eb7b'] after:top-0 after:left-0 after:font-remix after:leading-none after:opacity-0 checked:after:opacity-100 after:text-custom-500 checked:border-custom-500 dark:after:text-custom-500 dark:checked:border-custom-800"
                                                type="checkbox" value="">
                                        </div>
                                    </th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b border-transparent">Documents Type</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b border-transparent">Documents Name</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b border-transparent">File Size</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b border-transparent">Modify Date</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b border-transparent">Uploaded</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b border-transparent">Status</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b border-transparent text-right">Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white dark:bg-zink-700">
                                    <td class="px-3.5 py-2.5 border-y border-transparent">
                                        <div class="flex items-center h-full">
                                            <input id="Checkbox2"
                                                class="size-4 bg-white border border-slate-200 checked:bg-none dark:bg-zink-700 dark:border-zink-500 rounded-sm appearance-none arrow-none relative after:absolute after:content-['\eb7b'] after:top-0 after:left-0 after:font-remix after:leading-none after:opacity-0 checked:after:opacity-100 after:text-custom-500 checked:border-custom-500 dark:after:text-custom-500 dark:checked:border-custom-800"
                                                type="checkbox" value="">
                                        </div>
                                    </td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">
                                        <span
                                            class="px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-slate-100 border-transparent text-slate-500 dark:bg-slate-500/20 dark:text-zink-200 dark:border-transparent">Docs</span>
                                    </td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">starcode Docs File</td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">2.5MB</td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">15 Feb, 2023</td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">Admin</td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent"><span
                                            class="ppx-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-green-100 border-transparent text-green-500 dark:bg-green-500/20 dark:border-transparent">Successful</span>
                                    </td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="#!"
                                                class="flex items-center justify-center transition-all duration-150 ease-linear rounded-md size-8 bg-slate-100 hover:bg-slate-200 dark:bg-zink-600 dark:hover:bg-zink-500"><i
                                                    data-lucide="eye" class="size-3"></i></a>
                                            <a href="#!"
                                                class="flex items-center justify-center transition-all duration-150 ease-linear rounded-md size-8 bg-slate-100 hover:bg-slate-200 dark:bg-zink-600 dark:hover:bg-zink-500"><i
                                                    data-lucide="file-edit" class="size-3"></i></a>
                                            <a href="#!"
                                                class="flex items-center justify-center transition-all duration-150 ease-linear rounded-md size-8 bg-slate-100 hover:bg-slate-200 dark:bg-zink-600 dark:hover:bg-zink-500"><i
                                                    data-lucide="arrow-down-to-line" class="size-3"></i></a>
                                            <a href="#!"
                                                class="flex items-center justify-center transition-all duration-150 ease-linear rounded-md size-8 bg-slate-100 hover:bg-slate-200 dark:bg-zink-600 dark:hover:bg-zink-500"><i
                                                    data-lucide="trash-2" class="size-3"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="bg-white dark:bg-zink-700">
                                    <td class="px-3.5 py-2.5 border-y border-transparent">
                                        <div class="flex items-center h-full">
                                            <input id="Checkbox2"
                                                class="size-4 bg-white border border-slate-200 checked:bg-none dark:bg-zink-700 dark:border-zink-500 rounded-sm appearance-none arrow-none relative after:absolute after:content-['\eb7b'] after:top-0 after:left-0 after:font-remix after:leading-none after:opacity-0 checked:after:opacity-100 after:text-custom-500 checked:border-custom-500 dark:after:text-custom-500 dark:checked:border-custom-800"
                                                type="checkbox" value="">
                                        </div>
                                    </td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">
                                        <span
                                            class="px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-slate-100 border-transparent text-slate-500 dark:bg-slate-500/20 dark:text-zink-200 dark:border-transparent">PSD</span>
                                    </td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">starcode Design Kit.psd</td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">234.87 MB</td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">29 Jan, 2023</td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">StarCode Kh</td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent"><span
                                            class="ppx-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-green-100 border-transparent text-green-500 dark:bg-green-500/20 dark:border-transparent">Successful</span>
                                    </td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="#!"
                                                class="flex items-center justify-center transition-all duration-150 ease-linear rounded-md size-8 bg-slate-100 hover:bg-slate-200 dark:bg-zink-600 dark:hover:bg-zink-500"><i
                                                    data-lucide="eye" class="size-3"></i></a>
                                            <a href="#!"
                                                class="flex items-center justify-center transition-all duration-150 ease-linear rounded-md size-8 bg-slate-100 hover:bg-slate-200 dark:bg-zink-600 dark:hover:bg-zink-500"><i
                                                    data-lucide="file-edit" class="size-3"></i></a>
                                            <a href="#!"
                                                class="flex items-center justify-center transition-all duration-150 ease-linear rounded-md size-8 bg-slate-100 hover:bg-slate-200 dark:bg-zink-600 dark:hover:bg-zink-500"><i
                                                    data-lucide="arrow-down-to-line" class="size-3"></i></a>
                                            <a href="#!"
                                                class="flex items-center justify-center transition-all duration-150 ease-linear rounded-md size-8 bg-slate-100 hover:bg-slate-200 dark:bg-zink-600 dark:hover:bg-zink-500"><i
                                                    data-lucide="trash-2" class="size-3"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="bg-white dark:bg-zink-700">
                                    <td class="px-3.5 py-2.5 border-y border-transparent">
                                        <div class="flex items-center h-full">
                                            <input id="Checkbox2"
                                                class="size-4 bg-white border border-slate-200 checked:bg-none dark:bg-zink-700 dark:border-zink-500 rounded-sm appearance-none arrow-none relative after:absolute after:content-['\eb7b'] after:top-0 after:left-0 after:font-remix after:leading-none after:opacity-0 checked:after:opacity-100 after:text-custom-500 checked:border-custom-500 dark:after:text-custom-500 dark:checked:border-custom-800"
                                                type="checkbox" value="">
                                        </div>
                                    </td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">
                                        <span
                                            class="px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-slate-100 border-transparent text-slate-500 dark:bg-slate-500/20 dark:text-zink-200 dark:border-transparent">SVG</span>
                                    </td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">home Pattern Wave.svg</td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">3.87 MB</td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">24 Sept, 2023</td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">Admin</td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent"><span
                                            class="px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-red-100 border-transparent text-red-500 dark:bg-red-500/20 dark:border-transparent">Error</span>
                                    </td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="#!"
                                                class="flex items-center justify-center transition-all duration-150 ease-linear rounded-md size-8 bg-slate-100 hover:bg-slate-200 dark:bg-zink-600 dark:hover:bg-zink-500"><i
                                                    data-lucide="eye" class="size-3"></i></a>
                                            <a href="#!"
                                                class="flex items-center justify-center transition-all duration-150 ease-linear rounded-md size-8 bg-slate-100 hover:bg-slate-200 dark:bg-zink-600 dark:hover:bg-zink-500"><i
                                                    data-lucide="file-edit" class="size-3"></i></a>
                                            <a href="#!"
                                                class="flex items-center justify-center transition-all duration-150 ease-linear rounded-md size-8 bg-slate-100 hover:bg-slate-200 dark:bg-zink-600 dark:hover:bg-zink-500"><i
                                                    data-lucide="arrow-down-to-line" class="size-3"></i></a>
                                            <a href="#!"
                                                class="flex items-center justify-center transition-all duration-150 ease-linear rounded-md size-8 bg-slate-100 hover:bg-slate-200 dark:bg-zink-600 dark:hover:bg-zink-500"><i
                                                    data-lucide="trash-2" class="size-3"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="bg-white dark:bg-zink-700">
                                    <td class="px-3.5 py-2.5 border-y border-transparent">
                                        <div class="flex items-center h-full">
                                            <input id="Checkbox2"
                                                class="size-4 bg-white border border-slate-200 checked:bg-none dark:bg-zink-700 dark:border-zink-500 rounded-sm appearance-none arrow-none relative after:absolute after:content-['\eb7b'] after:top-0 after:left-0 after:font-remix after:leading-none after:opacity-0 checked:after:opacity-100 after:text-custom-500 checked:border-custom-500 dark:after:text-custom-500 dark:checked:border-custom-800"
                                                type="checkbox" value="">
                                        </div>
                                    </td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">
                                        <span
                                            class="px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-slate-100 border-transparent text-slate-500 dark:bg-slate-500/20 dark:text-zink-200 dark:border-transparent">SCSS</span>
                                    </td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">tailwind.scss</td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">0.100 KB</td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">03 April, 2023</td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">Paula</td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent"><span
                                            class="ppx-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-green-100 border-transparent text-green-500 dark:bg-green-500/20 dark:border-transparent">Successful</span>
                                    </td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="#!"
                                                class="flex items-center justify-center transition-all duration-150 ease-linear rounded-md size-8 bg-slate-100 hover:bg-slate-200 dark:bg-zink-600 dark:hover:bg-zink-500"><i
                                                    data-lucide="eye" class="size-3"></i></a>
                                            <a href="#!"
                                                class="flex items-center justify-center transition-all duration-150 ease-linear rounded-md size-8 bg-slate-100 hover:bg-slate-200 dark:bg-zink-600 dark:hover:bg-zink-500"><i
                                                    data-lucide="file-edit" class="size-3"></i></a>
                                            <a href="#!"
                                                class="flex items-center justify-center transition-all duration-150 ease-linear rounded-md size-8 bg-slate-100 hover:bg-slate-200 dark:bg-zink-600 dark:hover:bg-zink-500"><i
                                                    data-lucide="arrow-down-to-line" class="size-3"></i></a>
                                            <a href="#!"
                                                class="flex items-center justify-center transition-all duration-150 ease-linear rounded-md size-8 bg-slate-100 hover:bg-slate-200 dark:bg-zink-600 dark:hover:bg-zink-500"><i
                                                    data-lucide="trash-2" class="size-3"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="bg-white dark:bg-zink-700">
                                    <td class="px-3.5 py-2.5 border-y border-transparent">
                                        <div class="flex items-center h-full">
                                            <input id="Checkbox2"
                                                class="size-4 bg-white border border-slate-200 checked:bg-none dark:bg-zink-700 dark:border-zink-500 rounded-sm appearance-none arrow-none relative after:absolute after:content-['\eb7b'] after:top-0 after:left-0 after:font-remix after:leading-none after:opacity-0 checked:after:opacity-100 after:text-custom-500 checked:border-custom-500 dark:after:text-custom-500 dark:checked:border-custom-800"
                                                type="checkbox" value="">
                                        </div>
                                    </td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">
                                        <span
                                            class="px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-slate-100 border-transparent text-slate-500 dark:bg-slate-500/20 dark:text-zink-200 dark:border-transparent">MP4</span>
                                    </td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">starcode Guide Video.mp4</td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">149.33 MB</td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">12 Nov, 2023</td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">StarCode Kh</td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent"><span
                                            class="px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-yellow-100 border-transparent text-yellow-500 dark:bg-yellow-500/20 dark:border-transparent">Pending</span>
                                    </td>
                                    <td class="px-3.5 py-2.5 border-y border-transparent">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="#!"
                                                class="flex items-center justify-center transition-all duration-150 ease-linear rounded-md size-8 bg-slate-100 hover:bg-slate-200 dark:bg-zink-600 dark:hover:bg-zink-500"><i
                                                    data-lucide="eye" class="size-3"></i></a>
                                            <a href="#!"
                                                class="flex items-center justify-center transition-all duration-150 ease-linear rounded-md size-8 bg-slate-100 hover:bg-slate-200 dark:bg-zink-600 dark:hover:bg-zink-500"><i
                                                    data-lucide="file-edit" class="size-3"></i></a>
                                            <a href="#!"
                                                class="flex items-center justify-center transition-all duration-150 ease-linear rounded-md size-8 bg-slate-100 hover:bg-slate-200 dark:bg-zink-600 dark:hover:bg-zink-500"><i
                                                    data-lucide="arrow-down-to-line" class="size-3"></i></a>
                                            <a href="#!"
                                                class="flex items-center justify-center transition-all duration-150 ease-linear rounded-md size-8 bg-slate-100 hover:bg-slate-200 dark:bg-zink-600 dark:hover:bg-zink-500"><i
                                                    data-lucide="trash-2" class="size-3"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="flex flex-col items-center gap-4 mt-4 mb-4 md:flex-row">
                        <div class="grow">
                            <p class="text-slate-500 dark:text-zink-200">Showing <b>6</b> of <b>18</b> Results</p>
                        </div>
                        <ul class="flex flex-wrap items-center gap-2 shrink-0">
                            <li>
                                <a href="#!"
                                    class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto"><i
                                        class="size-4 rtl:rotate-180" data-lucide="chevron-left"></i></a>
                            </li>
                            <li>
                                <a href="#!"
                                    class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto">1</a>
                            </li>
                            <li>
                                <a href="#!"
                                    class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto">2</a>
                            </li>
                            <li>
                                <a href="#!"
                                    class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto active">3</a>
                            </li>
                            <li>
                                <a href="#!"
                                    class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto">4</a>
                            </li>
                            <li>
                                <a href="#!"
                                    class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto">5</a>
                            </li>
                            <li>
                                <a href="#!"
                                    class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto">6</a>
                            </li>
                            <li>
                                <a href="#!"
                                    class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto"><i
                                        class="size-4 rtl:rotate-180" data-lucide="chevron-right"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--end tab pane-->
                <div class="hidden tab-pane" id="projectsTabs">
                    <div class="flex items-center gap-3 mb-4">
                        <h5 class="underline grow">Cases</h5>
                        <div class="shrink-0">
                            <button type="button"
                                class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">Add
                                Case</button>
                        </div>
                    </div>
                    {{-- Real Cases Table --}}
                    @if($cases->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full align-middle border-separate whitespace-nowrap border-spacing-y-1">
                                <thead class="text-left bg-white dark:bg-zink-700">
                                    <tr>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-transparent">#</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-transparent">Case Number</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-transparent">Case Title</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-transparent">Department</th>
                                        @if($type === 'employee')
                                            <th class="px-3.5 py-2.5 font-semibold border-b border-transparent">Client</th>
                                        @else
                                            <th class="px-3.5 py-2.5 font-semibold border-b border-transparent">Lawyer</th>
                                        @endif
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-transparent">Status</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-transparent">Filed Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cases as $i => $case)
                                        <tr class="bg-white dark:bg-zink-700">
                                            <td class="px-3.5 py-2.5 border-y border-transparent text-slate-500 dark:text-zink-200">
                                                {{ $i + 1 }}</td>
                                            <td class="px-3.5 py-2.5 border-y border-transparent">
                                                <span
                                                    class="px-2.5 py-0.5 text-xs font-medium rounded border bg-slate-100 border-transparent text-slate-500 dark:bg-slate-500/20 dark:text-zink-200 dark:border-transparent">
                                                    {{ $case->case_number ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="px-3.5 py-2.5 border-y border-transparent text-slate-700 dark:text-zink-100">
                                                {{ Str::limit($case->case_title ?? 'N/A', 45) }}
                                            </td>
                                            <td class="px-3.5 py-2.5 border-y border-transparent text-slate-500 dark:text-zink-200">
                                                {{ $case->chapter->name ?? 'N/A' }}
                                            </td>
                                            @if($type === 'employee')
                                                <td class="px-3.5 py-2.5 border-y border-transparent text-slate-500 dark:text-zink-200">
                                                    {{ $case->client->name ?? 'N/A' }}
                                                </td>
                                            @else
                                                <td class="px-3.5 py-2.5 border-y border-transparent text-slate-500 dark:text-zink-200">
                                                    {{ $case->lawyer->name ?? ($case->instructor->name ?? 'N/A') }}
                                                </td>
                                            @endif
                                            <td class="px-3.5 py-2.5 border-y border-transparent">
                                                @php
                                                    $statusColors = [
                                                        'open' => 'bg-green-100 text-green-600 dark:bg-green-500/20',
                                                        'closed' => 'bg-slate-100 text-slate-500 dark:bg-slate-500/20',
                                                        'pending' => 'bg-yellow-100 text-yellow-600 dark:bg-yellow-500/20',
                                                        'active' => 'bg-sky-100 text-sky-600 dark:bg-sky-500/20',
                                                    ];
                                                    $status = strtolower($case->case_status ?? 'pending');
                                                    $colorClass = $statusColors[$status] ?? 'bg-slate-100 text-slate-500';
                                                @endphp
                                                <span
                                                    class="px-2.5 py-0.5 text-xs font-medium rounded border border-transparent {{ $colorClass }}">
                                                    {{ ucfirst($status) }}
                                                </span>
                                            </td>
                                            <td class="px-3.5 py-2.5 border-y border-transparent text-slate-500 dark:text-zink-200">
                                                {{ $case->filed_date ? $case->filed_date->format('d M, Y') : ($case->created_at ? $case->created_at->format('d M, Y') : 'N/A') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 mb-4">
                            <p class="text-slate-500 dark:text-zink-200">Showing <b>{{ $cases->count() }}</b> case(s)</p>
                        </div>
                    @else
                        <div class="py-10 text-center">
                            <i data-lucide="folder-open" class="mx-auto mb-3 size-12 text-slate-300"></i>
                            <p class="text-slate-500 dark:text-zink-200">No cases found.</p>
                        </div>
                    @endif
                </div>
                <!--end tab pane-->
                <ul class="absolute z-50 hidden py-2 mt-1 text-left list-none bg-white rounded-md shadow-md dropdown-menu min-w-[10rem]"
                    aria-labelledby="projectDropdownmenu1">
                    <li>
                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500"
                            href="#!"><i data-lucide="eye" class="inline-block mr-1 size-3"></i>
                            Overview</a>
                    </li>
                    <li>
                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500"
                            href="#!"><i data-lucide="file-edit" class="inline-block mr-1 size-3"></i> Edit</a>
                    </li>
                    <li>
                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500"
                            href="#!"><i data-lucide="trash-2" class="inline-block mr-1 size-3"></i> Delete</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection