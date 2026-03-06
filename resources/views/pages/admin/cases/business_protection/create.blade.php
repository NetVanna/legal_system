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

            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">Create A Business Protection Case</h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li
                        class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1 before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="{{ route('cases.index') }}" class="text-slate-400 dark:text-zink-200">Case</a>
                    </li>
                    <li
                        class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1 before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="{{ route('cases.create-businessprotection-case') }}"
                            class="text-slate-400 dark:text-zink-200">Create New</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">Business Support</li>
                </ul>
            </div>

            <form action="{{ route('cases.store-businessprotection-case') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="case_type" value="Business Support">

                {{-- Basic Information --}}
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-5">
                            <div
                                class="flex items-center justify-center size-10 rounded-md bg-custom-100 text-custom-500 dark:bg-custom-500/20">
                                <i data-lucide="info" class="size-5"></i>
                            </div>
                            <h6 class="text-15 grow">Case Information</h6>
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
                            <div>
                                <label for="case_number" class="inline-block mb-2 text-base font-medium">
                                    Case Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="case_number" name="case_number"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                    placeholder="Enter Case Number" value="{{ old('case_number') }}" required>
                                @error('case_number')
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="case_title"
                                    class="inline-block mb-2 text-base font-medium">Case Title</label>
                                <input type="text" id="case_title" name="case_title"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                    placeholder="Enter A Title" value="{{ old('case_title') }}">
                                @error('case_title')
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="filed_date" class="inline-block mb-2 text-base font-medium">
                                    Application Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="filed_date" name="filed_date"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                    value="{{ old('filed_date') }}" required>
                                @error('filed_date')
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="client_id" class="inline-block mb-2 text-base font-medium">
                                    Customers <span class="text-red-500">*</span>
                                </label>
                                <select id="client_id" name="client_id" data-choices
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                    <option value="">-- Select Customers --</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}"
                                            {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                            {{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('client_id')
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="lawyer_id" class="inline-block mb-2 text-base font-medium">
                                    Lawyer In Charge <span class="text-red-500">*</span>
                                </label>
                                <select id="lawyer_id" name="lawyer_id" data-choices
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                    required>
                                    <option value="">-- Choose A Lawyer --</option>
                                    @foreach ($lawyers ?? [] as $lawyer)
                                        <option value="{{ $lawyer->id }}"
                                            {{ old('lawyer_id') == $lawyer->id ? 'selected' : '' }}>
                                            {{ $lawyer->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('lawyer_id')
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="instructor_id" class="inline-block mb-2 text-base font-medium">Instructor</label>
                                <select id="instructor_id" name="instructor_id" data-choices
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                    <option value="">-- Select A Mentor --</option>
                                    @foreach ($instructors ?? [] as $instructor)
                                        <option value="{{ $instructor->id }}"
                                            {{ old('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                            {{ $instructor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="chapter_id" class="inline-block mb-2 text-base font-medium">Chapter</label>
                                <select id="chapter_id" name="chapter_id" data-choices
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                    <option value="">-- Select A Chapter --</option>
                                    @foreach ($chapters ?? [] as $chapter)
                                        <option value="{{ $chapter->id }}"
                                            {{ old('chapter_id') == $chapter->id ? 'selected' : '' }}>
                                            {{ $chapter->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="subchapter_id" class="inline-block mb-2 text-base font-medium">Subcategory</label>
                                <select id="subchapter_id" name="subchapter_id" data-choices
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                    <option value="">-- Select A Subcategory --</option>
                                    @foreach ($subchapters ?? [] as $subchapter)
                                        <option value="{{ $subchapter->id }}"
                                            {{ old('subchapter_id') == $subchapter->id ? 'selected' : '' }}>
                                            {{ $subchapter->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="casecode_id" class="inline-block mb-2 text-base font-medium">Story Code</label>
                                <select id="casecode_id" name="casecode_id" data-choices
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                    <option value="">-- Choose A Code --</option>
                                    @foreach ($casecodes ?? [] as $casecode)
                                        <option value="{{ $casecode->id }}"
                                            {{ old('casecode_id') == $casecode->id ? 'selected' : '' }}>
                                            {{ $casecode->code }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="case_status" class="inline-block mb-2 text-base font-medium">
                                    Story Status <span class="text-red-500">*</span>
                                </label>
                                <select id="case_status" name="case_status"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                    required>
                                    <option value="">-- Select Status --</option>
                                    <option value="open" {{ old('case_status') == 'open' ? 'selected' : '' }}>Open
                                    </option>
                                    <option value="in_progress"
                                        {{ old('case_status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="closed" {{ old('case_status') == 'closed' ? 'selected' : '' }}>Close
                                    </option>
                                    <option value="won" {{ old('case_status') == 'won' ? 'selected' : '' }}>Win
                                    </option>
                                    <option value="lost" {{ old('case_status') == 'lost' ? 'selected' : '' }}>Lose
                                    </option>
                                    <option value="settled" {{ old('case_status') == 'settled' ? 'selected' : '' }}>
                                        Resolved</option>
                                </select>
                                @error('case_status')
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- <div>
                                <label for="day_judge"
                                    class="inline-block mb-2 text-base font-medium">Judgment Day</label>
                                <input type="datetime-local" id="day_judge" name="day_judge"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                    value="{{ old('day_judge') }}">
                            </div>
                            <div>
                                <label for="day_show"
                                    class="inline-block mb-2 text-base font-medium">Announcement Date</label>
                                <input type="datetime-local" id="day_show" name="day_show"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                    value="{{ old('day_show') }}">
                            </div> --}}
                            <div>
                                <label for="closed_date" class="inline-block mb-2 text-base font-medium">Institutions</label>
                                <input type="text"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                    name="case_data[0][court]" id="court" placeholder="Enter The Name Of The Institution">
                                </input>
                            </div>
                            <div>
                                <label for="closed_date"
                                    class="inline-block mb-2 text-base font-medium">Closing Date</label>
                                <input type="date" id="closed_date" name="closed_date"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                    value="{{ old('closed_date') }}">
                            </div>
                        </div>

                        <div class="mt-5">
                            <label for="description" class="inline-block mb-2 text-base font-medium">Description</label>
                            <textarea id="description" name="description" rows="4"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                placeholder="Enter Case Description">{{ old('description') }}</textarea>
                        </div>

                        <div class="mt-5">
                            <label for="outcome" class="inline-block mb-2 text-base font-medium">Results</label>
                            <textarea id="outcome" name="outcome" rows="3"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                placeholder="Enter Story Results">{{ old('outcome') }}</textarea>
                        </div>
                    </div>
                </div>
                {{-- Payment Information --}}
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-5">
                            <div
                                class="flex items-center justify-center size-10 rounded-md bg-yellow-100 text-yellow-500 dark:bg-yellow-500/20">
                                <i data-lucide="dollar-sign" class="size-5"></i>
                            </div>
                            <h6 class="text-15 grow">Payment Information</h6>
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-5">
                            <div>
                                <label for="payment_type"
                                    class="inline-block mb-2 text-base font-medium">Payment Type</label>
                                <select id="payment_type" name="payment_type"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                    <option value="">-- Select Category --</option>
                                    <option value="cash" {{ old('payment_type') == 'cash' ? 'selected' : '' }}>
                                        Cash</option>
                                    <option value="bank_transfer"
                                        {{ old('payment_type') == 'bank_transfer' ? 'selected' : '' }}>Transfer Money</option>
                                    <option value="check" {{ old('payment_type') == 'check' ? 'selected' : '' }}>
                                        Check</option>
                                </select>
                            </div>
                            <div>
                                <label for="case_price"
                                    class="inline-block mb-2 text-base font-medium">Case Value</label>
                                <input type="number" id="case_price" name="case_price" step="1"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                    placeholder="0.00" value="{{ old('case_price') }}">
                            </div>
                            <div>
                                <label for="discount" class="inline-block mb-2 text-base font-medium">Discount</label>
                                <input type="number" id="discount" name="discount"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                    placeholder="0.00" value="{{ old('discount') }}">
                            </div>

                            <div>
                                <label for="payment_amount"
                                    class="inline-block mb-2 text-base font-medium">Amount Paid</label>
                                <input type="number" id="payment_amount" name="payment_amount" step="1"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                    placeholder="0.00" value="{{ old('payment_amount') }}">
                            </div>

                            <div>
                                <label for="payment_status"
                                    class="inline-block mb-2 text-base font-medium">Payment Status</label>
                                <select id="payment_status" name="payment_status"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                    <option value="unpaid" {{ old('payment_status') == 'unpaid' ? 'selected' : '' }}>
                                        Unpaid</option>
                                    <option value="partial" {{ old('payment_status') == 'partial' ? 'selected' : '' }}>
                                        Part Payment</option>
                                    <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>
                                        Already Paid
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Client Relatives --}}
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="flex items-center justify-between mb-5">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex items-center justify-center size-10 rounded-md bg-purple-100 text-purple-500 dark:bg-purple-500/20">
                                    <i data-lucide="users" class="size-5"></i>
                                </div>
                                <h6 class="text-15">Customer Relative Information</h6>
                            </div>
                            <button type="button" onclick="addRelative()"
                                class="text-white transition-all duration-200 ease-linear btn bg-green-500 border-green-500 hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-100 active:text-white active:bg-green-600 active:border-green-600 active:ring active:ring-green-100 dark:ring-green-400/20">
                                <i data-lucide="plus" class="inline-block size-4"></i>
                                <span class="align-middle">Add</span>
                            </button>
                        </div>

                        <div id="relatives-container" class="space-y-4">
                            <div
                                class="relative p-4 border rounded-md border-slate-200 dark:border-zink-500 bg-slate-50 dark:bg-zink-600">
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                    <div>
                                        <label class="inline-block mb-2 text-base font-medium">Name</label>
                                        <input type="text" name="client_relative[0][name]"
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                            placeholder="Enter A Name">
                                    </div>
                                    <div>
                                        <label class="inline-block mb-2 text-base font-medium">Contact</label>
                                        <input type="text" name="client_relative[0][relationship]"
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                            placeholder="E.G.. Brothers">
                                    </div>
                                    <div>
                                        <label class="inline-block mb-2 text-base font-medium">Phone Number</label>
                                        <input type="text" name="client_relative[0][phone]"
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                            placeholder="Enter A Phone Number">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Opponents --}}
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="flex items-center justify-between mb-5">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex items-center justify-center size-10 rounded-md bg-orange-100 text-orange-500 dark:bg-orange-500/20">
                                    <i data-lucide="user-x" class="size-5"></i>
                                </div>
                                <h6 class="text-15">Opposition News</h6>
                            </div>
                            <button type="button" onclick="addOpponent()"
                                class="text-white transition-all duration-200 ease-linear btn bg-green-500 border-green-500 hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-100 active:text-white active:bg-green-600 active:border-green-600 active:ring active:ring-green-100 dark:ring-green-400/20">
                                <i data-lucide="plus" class="inline-block size-4"></i>
                                <span class="align-middle">Add</span>
                            </button>
                        </div>

                        <div id="opponents-container" class="space-y-4">
                            <div
                                class="relative p-4 border rounded-md border-slate-200 dark:border-zink-500 bg-slate-50 dark:bg-zink-600">
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                                    <div>
                                        <label class="inline-block mb-2 text-base font-medium">Name</label>
                                        <input type="text" name="opponents[0][name]"
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                            placeholder="Enter A Name">
                                    </div>
                                    <div>
                                        <label class="inline-block mb-2 text-base font-medium">Phone Number</label>
                                        <input type="text" name="opponents[0][phone]"
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                            placeholder="Enter A Phone Number">
                                    </div>
                                    <div>
                                        <label class="inline-block mb-2 text-base font-medium">Email</label>
                                        <input type="email" name="opponents[0][email]"
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                            placeholder="Enter Email">
                                    </div>
                                    <div>
                                        <label class="inline-block mb-2 text-base font-medium">Address</label>
                                        <input type="text" name="opponents[0][address]"
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                            placeholder="Enter Address">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Documents --}}
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-5">
                            <div
                                class="flex items-center justify-center size-10 rounded-md bg-green-100 text-green-500 dark:bg-green-500/20">
                                <i data-lucide="paperclip" class="size-5"></i>
                            </div>
                            <h6 class="text-15 grow">Attachments</h6>
                        </div>

                        <div>
                            <label for="documents" class="inline-block mb-2 text-base font-medium">Select File
                                (Multiple Options)</label>
                            <div class="relative">
                                <input type="file" id="documents" multiple name="documents[]"
                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif" class="hidden"
                                    onchange="handleFileSelect(event)">
                                <label for="documents"
                                    class="flex items-center justify-center w-full px-4 py-8 border-2 border-dashed rounded-md cursor-pointer border-slate-300 dark:border-zink-500 hover:border-custom-500 dark:hover:border-custom-500 transition-colors">
                                    <div class="text-center">
                                        <i data-lucide="upload-cloud"
                                            class="inline-block size-12 text-slate-400 dark:text-zink-200 mb-2"></i>
                                        <p class="text-sm text-slate-500 dark:text-zink-200">
                                            <span class="font-medium text-custom-500">Click To Select</span>
                                            Or Drag And Drop Files
                                        </p>
                                        <p class="mt-1 text-xs text-slate-400 dark:text-zink-300">PDF, Word, Excel, Images
                                            (Max 10MB per file)</p>
                                    </div>
                                </label>
                            </div>

                            {{-- File Preview Container --}}
                            <div id="file-preview-container" class="mt-4 space-y-3 hidden">
                                <h6 class="text-sm font-medium text-slate-700 dark:text-zink-100 mb-3">Selected Files
                                </h6>
                                <div id="file-list" class="space-y-2"></div>
                            </div>

                            @error('documents')
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="flex justify-end gap-2 mt-4">
                    <a href="{{ route('cases.businessprotection') }}"
                        class="text-red-500 bg-white btn hover:text-red-500 hover:bg-red-100 focus:text-red-500 focus:bg-red-100 active:text-red-500 active:bg-red-100 dark:bg-zink-700 dark:hover:bg-red-500/10 dark:focus:bg-red-500/10 dark:active:bg-red-500/10">
                        <i data-lucide="x" class="inline-block size-4"></i>
                        <span class="align-middle">Cancel</span>
                    </a>
                    <button type="submit"
                        class="text-white transition-all duration-200 ease-linear btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                        <i data-lucide="save" class="inline-block size-4"></i>
                        <span class="align-middle">Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>



@section('script')
    <script>
        let relativeCount = 1;
        let opponentCount = 1;
        let selectedFiles = [];

        function addRelative() {
            const container = document.getElementById('relatives-container');
            const newRelative = `
                <div class="relative p-4 border rounded-md border-slate-200 dark:border-zink-500 bg-slate-50 dark:bg-zink-600">
                    <button type="button" onclick="this.parentElement.remove()" 
                        class="absolute top-2 right-2 flex items-center justify-center size-8 transition-all duration-200 ease-linear rounded-md text-red-500 bg-red-100 hover:text-white hover:bg-red-600 dark:bg-red-500/20 dark:hover:bg-red-500">
                        <i data-lucide="x" class="size-4"></i>
                    </button>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div>
                            <label class="inline-block mb-2 text-base font-medium">Name</label>
                            <input type="text" name="client_relative[${relativeCount}][name]" 
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" 
                                placeholder="Enter A Name">
                        </div>
                        <div>
                            <label class="inline-block mb-2 text-base font-medium">Contact</label>
                            <input type="text" name="client_relative[${relativeCount}][relationship]" 
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" 
                                placeholder="E.G.. Brothers">
                        </div>
                        <div>
                            <label class="inline-block mb-2 text-base font-medium">Phone Number</label>
                            <input type="text" name="client_relative[${relativeCount}][phone]" 
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" 
                                placeholder="Enter A Phone Number">
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', newRelative);
            relativeCount++;
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }

        function addOpponent() {
            const container = document.getElementById('opponents-container');
            const newOpponent = `
                <div class="relative p-4 border rounded-md border-slate-200 dark:border-zink-500 bg-slate-50 dark:bg-zink-600">
                    <button type="button" onclick="this.parentElement.remove()" 
                        class="absolute top-2 right-2 flex items-center justify-center size-8 transition-all duration-200 ease-linear rounded-md text-red-500 bg-red-100 hover:text-white hover:bg-red-600 dark:bg-red-500/20 dark:hover:bg-red-500">
                        <i data-lucide="x" class="size-4"></i>
                    </button>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                        <div>
                            <label class="inline-block mb-2 text-base font-medium">Name</label>
                            <input type="text" name="opponents[${opponentCount}][name]" 
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" 
                                placeholder="Enter A Name">
                        </div>
                        <div>
                            <label class="inline-block mb-2 text-base font-medium">Phone Number</label>
                            <input type="text" name="opponents[${opponentCount}][phone]" 
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" 
                                placeholder="Enter A Phone Number">
                        </div>
                        <div>
                            <label class="inline-block mb-2 text-base font-medium">Email</label>
                            <input type="email" name="opponents[${opponentCount}][email]" 
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" 
                                placeholder="Enter Email">
                        </div>
                        <div>
                            <label class="inline-block mb-2 text-base font-medium">Address</label>
                            <input type="text" name="opponents[${opponentCount}][address]" 
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" 
                                placeholder="Enter Address">
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', newOpponent);
            opponentCount++;
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }

        // File handling functions
        function handleFileSelect(event) {
            const files = Array.from(event.target.files);
            const maxSize = 10 * 1024 * 1024; // 10MB

            files.forEach(file => {
                if (file.size > maxSize) {
                    alert(`File "${file.name}" Too Large. Please Select A Smaller File 10MB`);
                    return;
                }
                selectedFiles.push(file);
            });

            updateFileList();
            updateFormFiles();
        }

        function updateFileList() {
            const fileList = document.getElementById('file-list');
            const container = document.getElementById('file-preview-container');

            if (selectedFiles.length === 0) {
                container.classList.add('hidden');
                return;
            }

            container.classList.remove('hidden');
            fileList.innerHTML = '';

            selectedFiles.forEach((file, index) => {
                const fileItem = createFilePreview(file, index);
                fileList.appendChild(fileItem);
            });

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }

        function createFilePreview(file, index) {
            const div = document.createElement('div');
            div.className =
                'flex items-center justify-between p-3 border rounded-md border-slate-200 dark:border-zink-500 bg-white dark:bg-zink-700';

            const fileIcon = getFileIcon(file.type, file.name);
            const fileSize = formatFileSize(file.size);
            const isImage = file.type.startsWith('image/');

            div.innerHTML = `
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    ${isImage ? `
                                                                            <div class="shrink-0">
                                                                                <img src="${URL.createObjectURL(file)}" alt="${file.name}" 
                                                                                    class="object-cover size-12 rounded border border-slate-200 dark:border-zink-500">
                                                                            </div>
                                                                        ` : `
                                                                            <div class="flex items-center justify-center size-12 rounded bg-slate-100 dark:bg-zink-600 shrink-0">
                                                                                <i data-lucide="${fileIcon}" class="size-6 text-slate-500 dark:text-zink-200"></i>
                                                                            </div>
                                                                        `}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate text-slate-700 dark:text-zink-100">${file.name}</p>
                        <p class="text-xs text-slate-500 dark:text-zink-300">${fileSize}</p>
                    </div>
                </div>
                <button type="button" onclick="removeFile(${index})" 
                    class="flex items-center justify-center shrink-0 size-8 transition-all duration-200 ease-linear rounded-md text-red-500 bg-red-100 hover:text-white hover:bg-red-600 dark:bg-red-500/20 dark:hover:bg-red-500">
                    <i data-lucide="x" class="size-4"></i>
                </button>
            `;

            return div;
        }

        function removeFile(index) {
            selectedFiles.splice(index, 1);
            updateFileList();
            updateFormFiles();
        }

        function updateFormFiles() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => {
                dataTransfer.items.add(file);
            });

            const fileInput = document.getElementById('documents');
            fileInput.files = dataTransfer.files;
        }

        function getFileIcon(mimeType, fileName) {
            const extension = fileName.split('.').pop().toLowerCase();

            if (mimeType.startsWith('image/')) return 'image';
            if (mimeType === 'application/pdf' || extension === 'pdf') return 'file-text';
            if (mimeType.includes('word') || ['doc', 'docx'].includes(extension)) return 'file-text';
            if (mimeType.includes('sheet') || mimeType.includes('excel') || ['xls', 'xlsx'].includes(extension))
                return 'file-spreadsheet';
            return 'file';
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }

        // Drag and drop support
        const dropZone = document.querySelector('label[for="documents"]');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.add('border-custom-500', 'bg-custom-50', 'dark:bg-custom-500/10');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('border-custom-500', 'bg-custom-50', 'dark:bg-custom-500/10');
            }, false);
        });

        dropZone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            document.getElementById('documents').files = files;
            handleFileSelect({
                target: {
                    files: files
                }
            });
        }, false);
    </script>
@endsection
@endsection
