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
    <div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">
        <div
            class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4">
            <div class="card">
                <div class="card-body">
                    @if(session('error'))
                        <div class="px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('manage.benefit.update.case', $benefitCase->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 gap-4 xl:grid-cols-12">
                            {{-- Select Case --}}
                            <div class="xl:col-span-12">
                                <label class="inline-block mb-2 text-base font-medium">Select Case <span class="text-red-500">*</span></label>
                                <select id="caseSelect" name="case_id" required
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 ">
                                    <option value="">-- Select a Case --</option>
                                    @foreach($cases as $case)
                                        <option value="{{ $case->id }}" 
                                            {{ old('case_id', $benefitCase->case_id) == $case->id ? 'selected' : '' }}>
                                            {{ $case->case_number }} - {{ $case->case_title ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('case_id')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Code Case (Auto-filled) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">Code Case</label>
                                <input type="text" id="codeCase" readonly
                                    value="{{ $benefitCase->case->case_number ?? '' }}"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100"
                                    placeholder="Auto-filled from case">
                            </div>

                            {{-- Client (Auto-filled) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">Client Name</label>
                                <input type="text" name="client_name" id="clientName" 
                                    value="{{ old('client_name', $benefitCase->client_name) }}"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100"
                                    placeholder="Auto-filled from case" readonly>
                                @error('client_name')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Type Case (Auto-filled) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">Type Case</label>
                                <input type="text" name="type_case" id="typeCase" 
                                    value="{{ old('type_case', $benefitCase->type_case) }}"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100"
                                    placeholder="Auto-filled from case" readonly>
                                @error('type_case')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Date (Auto-filled) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">Date</label>
                                <input type="text" name="date" id="dateField" 
                                    value="{{ old('date', $benefitCase->date->format('Y-m-d')) }}"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100"
                                    placeholder="Auto-filled from case" readonly>
                                @error('date')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- {{ \Carbon\Carbon::parse($benefit->date)->format('d/m/Y') }} --}}

                            {{-- Chapter (Auto-filled) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">Chapter</label>
                                <input type="text" name="chapter" id="chapter" 
                                    value="{{ old('chapter', $benefitCase->chapter) }}"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100"
                                    placeholder="Auto-filled from case" readonly>
                            </div>

                            {{-- Sub Chapter (Auto-filled) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">Sub Chapter</label>
                                <input type="text" name="sub_chapter" id="subChapter" 
                                    value="{{ old('sub_chapter', $benefitCase->sub_chapter) }}"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100"
                                    placeholder="Auto-filled from case" readonly>
                            </div>

                            {{-- Service Fee (Auto-filled but editable) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">Service Fee ($)</label>
                                <input type="number" id="serviceFee" name="service_fee" step="0.01"
                                    value="{{ old('service_fee', $benefitCase->service_fee) }}"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100" readonly>
                                @error('service_fee')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Lawyer (Auto-filled) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">Lawyer</label>
                                <input type="text" name="lawyer" id="lawyer" 
                                    value="{{ old('lawyer', $benefitCase->lawyer) }}"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100" readonly>
                                @error('lawyer')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Employee (Editable) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">Employee</label>
                                <input type="text" name="employee" id="employee" 
                                    value="{{ old('employee', $benefitCase->employee) }}"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100" readonly
                                    placeholder="Enter Employee Name">
                                @error('employee')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Employee Fee (AUTO) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">Employee Fee (15%)</label>
                                <input type="number" name="employee_fee" id="employeeFee" readonly
                                    value="{{ old('employee_fee', $benefitCase->employee_fee) }}"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100">
                            </div>

                            {{-- Chapter Fee (AUTO) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">Chapter Fee (5%)</label>
                                <input type="number" name="chapter_fee" id="chapterFee" readonly
                                    value="{{ old('chapter_fee', $benefitCase->chapter_fee) }}"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100">
                            </div>

                            {{-- Admin Fee (AUTO) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">Admin Fee (2%)</label>
                                <input type="number" name="admin_fee" id="adminFee" readonly
                                    value="{{ old('admin_fee', $benefitCase->admin_fee) }}"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100">
                            </div>

                            {{-- IT Fee (AUTO) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">IT Fee (5%)</label>
                                <input type="number" name="it_fee" id="itFee" readonly
                                    value="{{ old('it_fee', $benefitCase->it_fee) }}"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100">
                            </div>

                            {{-- Lawyer Percent --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 font-medium">Lawyer Percent (%)</label>
                                <input type="number" id="lawyerPercent" name="lawyer_percent"
                                    value="{{ old('lawyer_percent', ($benefitCase->service_fee > 0 ? ($benefitCase->lawyer_fee / $benefitCase->service_fee * 100) : 30)) }}"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                @error('lawyer_percent')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Lawyer Fee (AUTO) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 font-medium">Lawyer Fee ($)</label>
                                <input type="number" name="lawyer_fee" id="lawyerFee" readonly
                                    value="{{ old('lawyer_fee', $benefitCase->lawyer_fee) }}"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100">
                            </div>

                            {{-- Net Fee (AUTO) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 font-medium">Net Fee ($)</label>
                                <input type="number" name="net_fee" id="netFee" readonly
                                    value="{{ old('net_fee', $benefitCase->net_fee) }}"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100">
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 mt-4">
                            <a href="{{ route('manage.benefit.case.list') }}" class="text-red-500 bg-white btn">Cancel</a>
                            <button type="submit" class="text-white btn bg-custom-500">Update Benefit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // When case is selected, fetch its details
        document.getElementById('caseSelect').addEventListener('change', function() {
            const caseId = this.value;
            
            if (!caseId) {
                return;
            }

            // Fetch case details - Using Laravel route helper
            const url = `{{ url('manage/benefit/case') }}/${caseId}/details`;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    // Populate form fields
                    document.getElementById('codeCase').value = data.case_number || '';
                    document.getElementById('clientName').value = data.client_name || '';
                    document.getElementById('typeCase').value = data.case_type || '';
                    document.getElementById('dateField').value = data.filed_date || '';
                    document.getElementById('chapter').value = data.chapter || '';
                    document.getElementById('subChapter').value = data.sub_chapter || '';
                    document.getElementById('serviceFee').value = data.service_fee || 0;
                    document.getElementById('lawyer').value = data.lawyer || '';
                    document.getElementById('employee').value = data.instructor || '';

                    // Trigger calculation
                    calculateFees();
                })
                .catch(error => {
                    console.error('Error fetching case details:', error);
                    alert('Failed to load case details: ' + error.message);
                });
        });

        function calculateFees() {
            let service = parseFloat(document.getElementById("serviceFee").value) || 0;
            let lawyerPercent = parseFloat(document.getElementById("lawyerPercent").value) || 0;

            let employee = service * 0.15;
            let chapter = service * 0.05;
            let admin = service * 0.02;
            let itFee = service * 0.05;
            let lawyer = service * (lawyerPercent / 100);

            let net = service - (employee + chapter + admin + itFee + lawyer);

            document.getElementById('employeeFee').value = employee.toFixed(2);
            document.getElementById('chapterFee').value = chapter.toFixed(2);
            document.getElementById('adminFee').value = admin.toFixed(2);
            document.getElementById('itFee').value = itFee.toFixed(2);
            document.getElementById('lawyerFee').value = lawyer.toFixed(2);
            document.getElementById('netFee').value = net.toFixed(2);
        }

        document.getElementById("serviceFee").addEventListener("input", calculateFees);
        document.getElementById("lawyerPercent").addEventListener("input", calculateFees);

        // Calculate fees on page load
        document.addEventListener('DOMContentLoaded', function() {
            calculateFees();
        });
    </script>
@endsection