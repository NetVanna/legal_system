@extends('layouts.master')
{{-- left sidebar --}}
@section('sidebar')
    <div id="scrollbar"
        class="group-data-[sidebar-size=md]:max-h-[calc(100vh_-_theme('spacing.header')_*_1.2)] group-data-[sidebar-size=lg]:max-h-[calc(100vh_-_theme('spacing.header')_*_1.2)] group-data-[layout=horizontal]:h-56 group-data-[layout=horizontal]:md:h-auto group-data-[layout=horizontal]:overflow-auto group-data-[layout=horizontal]:md:overflow-visible group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:mx-auto">
        @include('pages.sop.sidebar.sidebar')
        <!-- Left Sidebar End -->
    </div>
@endsection
{{-- content --}}
@section('content')
    <!-- Page-content -->
    <div
        class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">SOP List</h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li
                        class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="#!" class="text-slate-400 dark:text-zink-200">HR Management</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">
                        SOP List
                    </li>
                </ul>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <h6 class="text-15 grow">SOP</h6>
                        <div class="flex gap-2 shrink-0">
                            
                            <a href="{{ route('sop-cases.create-sop-case') }}"
                                class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" data-lucide="plus"
                                    class="lucide lucide-plus inline-block size-4">
                                    <path d="M5 12h14"></path>
                                    <path d="M12 5v14"></path>
                                </svg>
                                <span class="align-middle">Add SOP Cases</span>
                            </a>
                        </div>
                    </div>
                    <br>
                    <table id="alternativePagination" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                                    Numbering</th>
                                <th hidden>ID</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                                    Services</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                                    Case Number</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                                    Dated</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                                    Institutions</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                                    Lawyer</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                                    Client</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                                    The Other Side</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                                    Service Fee</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                                    Discount</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                                    Amount Paid</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                                    Payment Status</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                                    Payment Type</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                                    File</th>
                                <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                                    Activities</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($cases as $key => $value)
                                <tr>
                                    <td class="px-3.5 py-2.5 border-b border-slate-200 dark:border-zink-500">
                                        {{ ++$key }}</td>
                                    <td class="ids" hidden>{{ $value->id }}</td>
                                    <td class="px-3.5 py-2.5 border-b border-slate-200 dark:border-zink-500">
                                        {{ $value->case_type }}</td>
                                    <td class="px-3.5 py-2.5 border-b border-slate-200 dark:border-zink-500">
                                        {{ $value->case_number }}</td>
                                    <td class="px-3.5 py-2.5 border-b border-slate-200 dark:border-zink-500">
                                        {{ $value->filed_date ? $value->filed_date->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="px-3.5 py-2.5 border-b border-slate-200 dark:border-zink-500">
                                        {{ isset($value->case_data[0]['court']) ? $value->case_data[0]['court'] : '-' }}
                                    </td>
                                    <td class="px-3.5 py-2.5 border-b border-slate-200 dark:border-zink-500">
                                        {{ $value->lawyer->name ?? '-' }}
                                    </td>
                                    <td class="px-3.5 py-2.5 border-b border-slate-200 dark:border-zink-500">
                                        {{ $value->client->name ?? '-' }}</td>
                                    <td class="px-3.5 py-2.5 border-b border-slate-200 dark:border-zink-500">
                                        @if ($value->opponents && count($value->opponents) > 0)
                                            <button type="button" onclick="showOpponents({{ $value->id }})"
                                                class="text-custom-500 hover:underline focus:outline-none">
                                                Look The Other Way ({{ count($value->opponents) }})
                                            </button>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-3.5 py-2.5 border-b border-slate-200 dark:border-zink-500">
                                        ${{ number_format($value->case_price, 2) }}
                                    </td>
                                    <td class="px-3.5 py-2.5 border-b border-slate-200 dark:border-zink-500">
                                        ${{ $value->discount ?? '-' }}
                                    </td>
                                    <td class="px-3.5 py-2.5 border-b border-slate-200 dark:border-zink-500">
                                        ${{ number_format($value->payment_amount, 2) }}
                                    </td>
                                    <td class="px-3.5 py-2.5 border-b border-slate-200 dark:border-zink-500">
                                        <span
                                            class="px-2.5 py-0.5 text-xs inline-block font-medium rounded border 
                                        {{ $value->payment_status == 'paid'
                                            ? 'bg-green-100 border-green-200 text-green-500'
                                            : ($value->payment_status == 'partial'
                                                ? 'bg-yellow-100 border-yellow-200 text-yellow-500'
                                                : 'bg-red-100 border-red-200 text-red-500') }}">
                                            {{ $value->payment_status == 'paid'
                                                ? 'Paid'
                                                : ($value->payment_status == 'partial'
                                                    ? 'Part Payment'
                                                    : 'Unpaid') }}
                                        </span>
                                    </td>
                                    <td class="px-3.5 py-2.5 border-b border-slate-200 dark:border-zink-500">
                                        {{ $value->payment_type ? ucfirst(str_replace('_', ' ', $value->payment_type)) : '-' }}
                                    </td>
                                    <td class="px-3.5 py-2.5 border-b border-slate-200 dark:border-zink-500">
                                        @if ($value->documents && count($value->documents) > 0)
                                            <button type="button"
                                                onclick="showDocuments({{ $value->id }})"class="text-custom-500 hover:underline focus:outline-none">
                                                View Document ({{ count($value->documents) }})
                                            </button>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-3.5 py-2.5 border-b border-slate-200 dark:border-zink-500">
                                        <div class="flex gap-2">
                                            <button type="button" onclick="showClientRelatives({{ $value->id }})"
                                                class="flex items-center justify-center size-8 transition-all duration-200 ease-linear rounded-md bg-blue-100 text-blue-500 hover:bg-blue-500"
                                                title="See Relatives">
                                                <i data-lucide="users" class="size-4"></i>
                                            </button>
                                            <a href="{{ route('sop-cases.edit-sop-case', $value->id) }}"
                                                class="flex items-center justify-center size-8 transition-all duration-200 ease-linear rounded-md bg-slate-100 text-slate-500 hover:text-custom-500 hover:bg-custom-100"
                                                title="Edit">
                                                <i data-lucide="pencil" class="size-4"></i>
                                            </a>
                                            <a href="#!" data-modal-target="deleteModal" id="deleteRecord"
                                                class="flex items-center justify-center transition-all duration-200 ease-linear rounded-md size-8 bg-slate-100 dark:bg-zink-600 dark:text-zink-200 text-slate-500 hover:text-red-500 dark:hover:text-red-500 hover:bg-red-100 dark:hover:bg-red-500/20"><i
                                                    data-lucide="trash-2" class="size-4"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page-content -->
    <!-- Hidden data containers - OUTSIDE the table -->
    @foreach ($cases as $case)
        <script type="application/json" id="case-relatives-{{ $case->id }}">
            {!! json_encode($case->client_relative) !!}
        </script>
        <script type="application/json" id="case-opponents-{{ $case->id }}">
            {!! json_encode($case->opponents) !!}
        </script>
        <script type="application/json" id="case-documents-{{ $case->id }}">
            {!! json_encode($case->documents) !!}
        </script>
    @endforeach
    <!-- Client Relatives Modal -->
    <div id="clientRelativesModal" class="fixed inset-0 z-[1000] hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 transition-opacity bg-black opacity-50"
                onclick="closeModal('clientRelativesModal')">
            </div>
            <div class="relative w-full max-w-2xl bg-white rounded-lg shadow-xl dark:bg-zink-600">
                <div class="flex items-center justify-between p-4 border-b dark:border-zink-500">
                    <h5 class="text-16">Customer Relative Information</h5>
                    <button onclick="closeModal('clientRelativesModal')" class="text-slate-500 hover:text-red-500">
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>
                <div class="max-h-[60vh] overflow-y-auto p-4">
                    <div id="relativesContent" class="space-y-3"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Opponents Modal -->
    <div id="opponentsModal" class="fixed inset-0 z-[1000] hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 transition-opacity bg-black opacity-50" onclick="closeModal('opponentsModal')">
            </div>
            <div class="relative w-full max-w-2xl bg-white rounded-lg shadow-xl dark:bg-zink-600">
                <div class="flex items-center justify-between p-4 border-b dark:border-zink-500">
                    <h5 class="text-16">Opposition News</h5>
                    <button onclick="closeModal('opponentsModal')" class="text-slate-500 hover:text-red-500">
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>
                <div class="max-h-[60vh] overflow-y-auto p-4">
                    <div id="opponentsContent" class="space-y-3"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents Modal -->
    <div id="documentsModal" class="fixed inset-0 z-[1000] hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 transition-opacity bg-black opacity-50" onclick="closeModal('documentsModal')">
            </div>
            <div class="relative w-full max-w-2xl bg-white rounded-lg shadow-xl dark:bg-zink-600">
                <div class="flex items-center justify-between p-4 border-b dark:border-zink-500">
                    <h5 class="text-16">Attachments</h5>
                    <button onclick="closeModal('documentsModal')" class="text-slate-500 hover:text-red-500">
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>
                <div class="max-h-[60vh] overflow-y-auto p-4">
                    <div id="documentsContent" class="space-y-2"></div>
                </div>
            </div>
        </div>
    </div>

    <!--delete modal-->
    <div id="deleteModal" modal-center=""
        class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
        <div class="w-screen md:w-[25rem] bg-white shadow rounded-md dark:bg-zink-600">
            <div class="max-h-[calc(theme('height.screen')_-_180px)] overflow-y-auto px-6 py-8">
                <div class="float-right">
                    <button data-modal-close="deleteModal"
                        class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <img src="data:image/png;base64,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"
                    alt="" class="block h-12 mx-auto">
                <form action="#" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id_delete" id="e_id_delete" value="">
                    <div class="mt-5 text-center">
                        <h5 class="mb-1">Are you sure?</h5>
                        <p class="text-slate-500 dark:text-zink-200">Are you certain you want to delete this record?</p>
                        <div class="flex justify-center gap-2 mt-6">
                            <button type="reset" data-modal-close="deleteModal"
                                class="bg-white text-slate-500 btn hover:text-slate-500 hover:bg-slate-100 focus:text-slate-500 focus:bg-slate-100 active:text-slate-500 active:bg-slate-100 dark:bg-zink-600 dark:hover:bg-slate-500/10 dark:focus:bg-slate-500/10 dark:active:bg-slate-500/10">Cancel</button>
                            <button type="submit"
                                class="text-white bg-red-500 border-red-500 btn hover:text-white hover:bg-red-600 hover:border-red-600 focus:text-white focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:border-red-600 active:ring active:ring-red-100 dark:ring-custom-400/20">Yes,
                                Delete It!</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end delete modal-->

@section('script')
    {{-- delete js --}}
    <script>
        $(document).on('click', '#deleteRecord', function() {
            var id = $(this).closest('tr').find('.ids').text();

            $('#e_id_delete').val(id);

            var url = "{{ route('sop-cases.destroy-sop-case', ':id') }}";
            url = url.replace(':id', id);

            $('#deleteForm').attr('action', url);
        });
    </script>
    <script>
        // Modal functions
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function showModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('opacity-50')) {
                const modals = ['clientRelativesModal', 'opponentsModal', 'documentsModal'];
                modals.forEach(modalId => {
                    const modal = document.getElementById(modalId);
                    if (modal && !modal.classList.contains('hidden')) {
                        closeModal(modalId);
                    }
                });
            }
        });
        // Initialize lucide icons on page load
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
    {{-- show client relative model --}}
    <script>
        function showClientRelatives(caseId) {
            const dataElement = document.getElementById(`case-relatives-${caseId}`);
            if (!dataElement) return console.error('Data element not found for case:', caseId);

            const data = JSON.parse(dataElement.textContent);
            const content = document.getElementById('relativesContent');

            if (!data || data.length === 0) {
                content.innerHTML = '<p class="text-center text-slate-500 py-4">No Information</p>';
            } else {
                content.innerHTML = data.map((relative, index) => `
                <div class="p-4 border rounded-md border-slate-200 dark:border-zink-500 bg-slate-50 dark:bg-zink-700">
                    <h6 class="mb-3 text-sm font-semibold">Relatives #${index + 1}</h6>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <p class="text-xs text-slate-500">Name</p>
                            <p class="font-medium">${relative.name || '-'}</p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500">Contact</p>
                            <p class="font-medium">${relative.relationship || '-'}</p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500">Phone Number</p>
                            <p class="font-medium">${relative.phone || '-'}</p>
                        </div>
                    </div>
                </div>
            `).join('');
            }

            showModal('clientRelativesModal');
            if (typeof lucide !== 'undefined') lucide.createIcons();
        }
    </script>
    {{-- show opponent model --}}
    <script>
        function showOpponents(caseId) {
            const dataElement = document.getElementById(`case-opponents-${caseId}`);
            if (!dataElement) return console.error('Data element not found for case:', caseId);

            const data = JSON.parse(dataElement.textContent);
            const content = document.getElementById('opponentsContent');

            if (!data || data.length === 0) {
                content.innerHTML = '<p class="text-center text-slate-500 py-4">No Information</p>';
            } else {
                content.innerHTML = data.map((opponent, index) => `
                <div class="p-4 border rounded-md border-slate-200 bg-slate-50 dark:bg-zink-700 dark:border-zink-500">
                    <h6 class="mb-3 text-sm font-semibold">Opponent #${index + 1}</h6>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <p class="text-xs text-slate-500">Name</p>
                            <p class="font-medium">${opponent.name || '-'}</p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500">Phone Number</p>
                            <p class="font-medium">${opponent.phone || '-'}</p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500">Email</p>
                            <p class="font-medium">${opponent.email || '-'}</p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500">Address</p>
                            <p class="font-medium">${opponent.address || '-'}</p>
                        </div>
                    </div>
                </div>
            `).join('');
            }

            showModal('opponentsModal');
            if (typeof lucide !== 'undefined') lucide.createIcons();
        }
    </script>

    {{-- show file model --}}
    <script>
        // Get file icon by type
        function getFileIcon(fileType) {
            const type = fileType.toLowerCase();
            if (['jpg', 'jpeg', 'png', 'gif'].includes(type)) return 'image';
            if (type === 'pdf') return 'file-text';
            if (['doc', 'docx'].includes(type)) return 'file-text';
            if (['xls', 'xlsx'].includes(type)) return 'file-spreadsheet';
            return 'file';
        }

        // Show documents
        function showDocuments(caseId) {
            const dataElement = document.getElementById(`case-documents-${caseId}`);
            if (!dataElement) return console.error('Data element not found for case:', caseId);

            const data = JSON.parse(dataElement.textContent);
            const content = document.getElementById('documentsContent');

            if (!data || data.length === 0) {
                content.innerHTML = '<p class="text-center text-slate-500 py-4">No File</p>';
            } else {
                content.innerHTML = data
                    .map(doc => {
                        const fileSize = (doc.file_size / 1024).toFixed(2);
                        const fileIcon = getFileIcon(doc.file_type);

                        return `
                        <a href="/${doc.file_path}" target="_blank"
                           class="flex items-center gap-3 p-3 border rounded-md border-slate-200 dark:border-zink-500 hover:bg-slate-50 dark:hover:bg-zink-700">
                            <div class="flex items-center justify-center size-10 rounded bg-slate-100 dark:bg-zink-600">
                                <i data-lucide="${fileIcon}" class="size-5 text-slate-500"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium truncate">${doc.file_name}</p>
                                <p class="text-xs text-slate-500">${fileSize} KB</p>
                            </div>
                            <i data-lucide="external-link" class="size-4 text-slate-400"></i>
                        </a>
                    `;
                    })
                    .join('');
            }

            showModal('documentsModal');
            if (typeof lucide !== 'undefined') lucide.createIcons();
        }
    </script>
@endsection
@endsection
