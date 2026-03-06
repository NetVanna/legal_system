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
                    @if (session('error'))
                        <div class="px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('manage.benefit.store.case') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 gap-4 xl:grid-cols-12">
                            {{-- Select Case --}}
                            <div class="xl:col-span-12">
                                <label class="inline-block mb-2 text-base font-medium">Select Case <span
                                        class="text-red-500">*</span></label>
                                <select id="caseSelect" name="case_id" data-choices
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                    required>
                                    <option value="">-- Select Case --</option>

                                    @foreach ($cases as $case)
                                        <option value="{{ $case->id }}"
                                            {{ old('case_id') == $case->id ? 'selected' : '' }}>
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
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100"
                                    placeholder="Auto-filled from case">
                            </div>

                            {{-- Client (Auto-filled) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">Client Name</label>
                                <input type="text" name="client_name" id="clientName" value="{{ old('client_name') }}"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100"
                                    placeholder="Auto-filled from case" readonly>
                            </div>

                            {{-- Type Case (Auto-filled) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">Type Case</label>
                                <input type="text" name="type_case" id="typeCase" value="{{ old('type_case') }}"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100"
                                    placeholder="Auto-filled from case" readonly>
                            </div>

                            {{-- Date (Auto-filled) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">Date</label>
                                <input type="text" name="date" id="dateField" value="{{ old('date') }}"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100"
                                    placeholder="Auto-filled from case" readonly>
                            </div>

                            {{-- Chapter (Auto-filled) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">Chapter</label>
                                <input type="text" name="chapter" id="chapter" value="{{ old('chapter') }}"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100"
                                    placeholder="Auto-filled from case" readonly>
                            </div>

                            {{-- Sub Chapter (Auto-filled) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">Sub Chapter</label>
                                <input type="text" name="sub_chapter" id="subChapter" value="{{ old('sub_chapter') }}"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100"
                                    placeholder="Auto-filled from case" readonly>
                            </div>

                            {{-- Service Fee (Auto-filled but editable) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">Service Fee ($)</label>
                                <input type="number" id="serviceFee" name="service_fee" step="0.01"
                                    value="{{ old('service_fee', 0) }}" readonly
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100">
                            </div>

                            {{-- Lawyer (Auto-filled) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">Lawyer</label>
                                <input type="text" name="lawyer" id="lawyer" value="{{ old('lawyer') }}"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100" readonly>
                            </div>

                            {{-- Employee (Editable) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">Employee</label>
                                <input type="text" name="employee" id="employee" value="{{ old('employee') }}"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100" readonly
                                    placeholder="Enter Employee Name">
                            </div>

                            {{-- Employee Fee (AUTO) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">Employee Fee (15%)</label>
                                <input type="number" name="employee_fee" id="employeeFee" readonly
                                   class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100">
                            </div>

                            {{-- Chapter Fee (AUTO) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">Chapter Fee (5%)</label>
                                <input type="number" name="chapter_fee" id="chapterFee" readonly
                                   class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100">
                            </div>

                            {{-- Admin Fee (AUTO) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">Admin Fee (2%)</label>
                                <input type="number" name="admin_fee" id="adminFee" readonly
                                   class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100">
                            </div>

                            {{-- IT Fee (AUTO) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 text-base font-medium">IT Fee (5%)</label>
                                <input type="number" name="it_fee" id="itFee" readonly
                                   class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100">
                            </div>

                            {{-- Lawyer Percent --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 font-medium">Lawyer Percent (%)</label>
                                <input type="number" id="lawyerPercent" value="30" name="lawyer_percent"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                            </div>

                            {{-- Lawyer Fee (AUTO) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 font-medium">Lawyer Fee ($)</label>
                                <input type="number" name="lawyer_fee" id="lawyerFee" readonly
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100">
                            </div>

                            {{-- Net Fee (AUTO) --}}
                            <div class="xl:col-span-6">
                                <label class="inline-block mb-2 font-medium">Net Fee ($)</label>
                                <input type="number" name="net_fee" id="netFee" readonly
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 bg-slate-100">
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 mt-4">
                            <a href="{{ route('manage.benefit.case.list') }}"
                                class="text-red-500 bg-white btn">Cancel</a>
                            <button type="submit" class="text-white btn bg-custom-500">Add Benefit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@section('script')
    <script>
        // When case is selected, fetch its details
        document.getElementById('caseSelect').addEventListener('change', function() {
            const caseId = this.value;

            if (!caseId) {
                clearForm();
                return;
            }

            // Show loading state
            console.log('Fetching case ID:', caseId);

            // Fetch case details - Using Laravel route helper
            const url = `{{ url('manage/benefit/case') }}/${caseId}/details`;
            console.log('Fetching from URL:', url);

            fetch(url)
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Received data:', data);

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

        function clearForm() {
            document.getElementById('codeCase').value = '';
            document.getElementById('clientName').value = '';
            document.getElementById('typeCase').value = '';
            document.getElementById('dateField').value = '';
            document.getElementById('chapter').value = '';
            document.getElementById('subChapter').value = '';
            document.getElementById('serviceFee').value = 0;
            document.getElementById('lawyer').value = '';
            document.getElementById('employee').value = '';

            document.getElementById('employeeFee').value = 0;
            document.getElementById('chapterFee').value = 0;
            document.getElementById('adminFee').value = 0;
            document.getElementById('itFee').value = 0;
            document.getElementById('lawyerFee').value = 0;
            document.getElementById('netFee').value = 0;
        }

        document.getElementById("serviceFee").addEventListener("input", calculateFees);
        document.getElementById("lawyerPercent").addEventListener("input", calculateFees);
    </script>
@endsection
@endsection
