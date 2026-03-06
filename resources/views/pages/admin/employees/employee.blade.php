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
            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">Employee List</h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li
                        class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="#!" class="text-slate-400 dark:text-zink-200">HR Management</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">
                        Employee List
                    </li>
                </ul>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <h6 class="text-15 grow">Employee List</h6>
                        <div class="shrink-0">
                            <button data-modal-target="addEmployeeModal" type="button"
                                class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" data-lucide="plus"
                                    class="lucide lucide-plus inline-block size-4">
                                    <path d="M5 12h14"></path>
                                    <path d="M12 5v14"></path>
                                </svg>
                                <span class="align-middle">Add Employee</span>
                            </button>
                        </div>
                    </div>
                    <br>
                    <table id="alternativePagination" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th hidden>Employee ID</th>
                                <th class="ltr:!text-left rtl:!text-right">Name</th>
                                <th>Email</th>
                                <th>Employee ID</th>
                                <th>Phone</th>
                                <th>DOB</th>
                                <th>Gender</th>
                                <th>Role</th>
                                <th>Positon</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employeeList as $key => $employee)
                                @php
                                    $fullName = $employee->name;
                                    $parts = explode(' ', $fullName);
                                    $initials = '';
                                    foreach ($parts as $part) {
                                        $initials .= strtoupper(substr($part, 0, 1));
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td class="ids" hidden>{{ $employee->id }}</td>
                                    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="flex items-center justify-center font-medium rounded-full size-10 shrink-0 bg-slate-200 text-slate-800 dark:text-zink-50 dark:bg-zink-600">
                                                @if (!empty($employee->photo))
                                                    <img src="{{ URL::to('assets/images/user/' . $employee->photo) }}"
                                                        alt="" class="h-10 rounded-full">
                                                @else
                                                    <div
                                                        class="flex items-center justify-center font-medium rounded-full size-10 shrink-0 bg-slate-200 text-slate-800 dark:text-zink-50 dark:bg-zink-600">
                                                        {{ $initials }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="grow">
                                                <h6 class="mb-1"><a href="{{ url('page/account/' . $employee->user_id) }}"
                                                        class="name">{{ $employee->name }}</a></h6>
                                                <p class="text-slate-500 dark:text-zink-200 position">
                                                    {{ $employee->position }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $employee->employee_id  }}</td>
                                    <td>{{ $employee->phone }}</td>
                                    <td>{{ \Carbon\Carbon::parse($employee->dob)->format('d F Y') }}</td>

                                    <td>{{ $employee->gender }}</td>
                                    <td>{{ $employee->role }}</td>
                                    <td>{{ $employee->position }}</td>
                                    <td class="Action">
                                        <div class="flex gap-3">
                                            <a class="flex items-center justify-center transition-all duration-200 ease-linear rounded-md size-8 bg-slate-100 text-slate-500 hover:text-custom-500 hover:bg-custom-100 dark:bg-zink-600 dark:text-zink-200 dark:hover:bg-custom-500/20 dark:hover:text-custom-500"
                                                href="{{ url('page/account/' . $employee->id) }}"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    data-lucide="eye" class="lucide lucide-eye inline-block size-3">
                                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg> </a>
                                            <a data-modal-target="editEmployeeModal"
                                                class="editEmployeeBtn flex items-center justify-center transition-all duration-200 ease-linear rounded-md size-8 text-slate-500 bg-slate-100 hover:text-white hover:bg-slate-500"
                                                data-id="{{ $employee->id }}"
                                                data-employee_id="{{ $employee->employee_id }}"
                                                data-name="{{ $employee->name }}"
                                                data-username="{{ $employee->username }}"
                                                data-phone="{{ $employee->phone }}" data-email="{{ $employee->email }}"
                                                data-role="{{ $employee->role }}"
                                                data-date_birth="{{ $employee->date_birth }}"
                                                data-gender="{{ $employee->gender }}"
                                                data-position_id="{{ $employee->position_id }}"
                                                data-chapter_id="{{ $employee->chapter_id }}"
                                                data-sub_chapter_id="{{ $employee->sub_chapter_id }}"
                                                data-address="{{ $employee->address }}"
                                                data-status="{{ $employee->status }}"
                                                data-photo="{{ $employee->photo ? asset('assets/images/user/' . $employee->photo) : '' }}">
                                                <i data-lucide="pencil" class="size-4"></i>
                                            </a>
                                            @if ($employee->position !== 'Administrator')
                                                <a data-modal-target="deleteModal" id="deleteRecord"
                                                    class="flex items-center justify-center transition-all duration-200 ease-linear rounded-md size-8 bg-slate-100 text-slate-500 hover:text-red-500 hover:bg-red-100 dark:bg-zink-600 dark:text-zink-200 dark:hover:text-red-500 dark:hover:bg-red-500/20"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        data-lucide="trash-2" class="lucide lucide-trash-2 size-4">
                                                        <path d="M3 6h18"></path>
                                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                                        <line x1="10" x2="10" y1="11" y2="17">
                                                        </line>
                                                        <line x1="14" x2="14" y1="11"
                                                            y2="17">
                                                        </line>
                                                    </svg></a>
                                            @endif
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
    <!--add Employee-->
    <div id="addEmployeeModal" modal-center=""
        class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
        <div class="w-screen md:w-[30rem] bg-white shadow rounded-md dark:bg-zink-600">
            <div class="flex items-center justify-between p-4 border-b dark:border-zink-500">
                <h5 class="text-16">Add Employee</h5>
                <button data-modal-close="addEmployeeModal"
                    class="transition-all duration-200 ease-linear text-slate-400 hover:text-red-500">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
                <form class="create-form" id="create-form" action="{{ route('employee.manage.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div id="alert-error-msg"
                        class="hidden px-4 py-3 text-sm text-red-500 border border-transparent rounded-md bg-red-50 dark:bg-red-500/20">
                    </div>

                    <div class="grid grid-cols-1 gap-4 xl:grid-cols-12">

                        <!-- Profile Photo -->
                        <div class="xl:col-span-12 text-center mb-4">
                            <div
                                class="relative mx-auto rounded-full shadow-md size-24 bg-slate-100 profile-user dark:bg-zink-500">
                                <img src="{{ URL::to('assets/images/user.png') }}" alt=""
                                    class="object-cover w-full h-full rounded-full user-profile-image">
                                <div
                                    class="absolute bottom-0 right-0 flex items-center justify-center rounded-full size-8 profile-photo-edit">
                                    <input id="profile-img-file-input" name="photo" type="file" class="hidden">
                                    <label for="profile-img-file-input"
                                        class="flex items-center justify-center bg-white rounded-full shadow-lg cursor-pointer size-8 dark:bg-zink-600">
                                        <i data-lucide="image-plus"
                                            class="size-4 text-slate-500 fill-slate-200 dark:text-zink-200 dark:fill-zink-500"></i>
                                    </label>
                                </div>
                            </div>
                            @error('photo')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- Employee ID -->
                        <div class="xl:col-span-6">
                            <label for="employeeIdInput" class="mb-2 font-medium">Employee ID</label>
                            <input type="text" name="employee_id" id="employeeIdInput" placeholder="Employee ID"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                value="{{ old('employee_id') }}">
                            @error('employee_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div class="xl:col-span-6">
                            <label for="nameInput" class="mb-2 font-medium">Name</label>
                            <input type="text" name="name" id="nameInput" placeholder="Full Name"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="xl:col-span-6">
                            <label for="emailInput" class="mb-2 font-medium">Email</label>
                            <input type="email" name="email" id="emailInput" placeholder="example@domain.com"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                value="{{ old('email') }}">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="xl:col-span-6">
                            <label for="phoneInput" class="mb-2 font-medium">Phone</label>
                            <input type="tel" name="phone" id="phoneInput" placeholder="Phone Number"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                value="{{ old('phone') }}">
                            @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="xl:col-span-6">
                            <label for="passwordInput" class="mb-2 font-medium">Password</label>
                            <input type="password" name="password" id="passwordInput" placeholder="Password"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div class="xl:col-span-6">
                            <label for="dateBirthInput" class="mb-2 font-medium">Date of Birth</label>
                            <input type="date" name="date_birth" id="dateBirthInput"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                value="{{ old('date_birth') }}">
                            @error('date_birth')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="xl:col-span-6">
                            <label for="genderInput" class="mb-2 font-medium">Gender</label>
                            <select name="gender" id="genderInput"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                <option value="" disabled>Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div class="xl:col-span-6">
                            <label for="roleInput" class="mb-2 font-medium">Role</label>
                            <select name="role" id="roleInput"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                <option value="" disabled>Select Role</option>
                                <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee
                                </option>
                                <option value="lawyer" {{ old('role') == 'lawyer' ? 'selected' : '' }}>Lawyer</option>
                                <option value="criminal" {{ old('role') == 'criminal' ? 'selected' : '' }}>Criminal
                                </option>
                                <option value="civil" {{ old('role') == 'civil' ? 'selected' : '' }}>Civil</option>
                                <option value="outcourt" {{ old('role') == 'outcourt' ? 'selected' : '' }}>Outcourt
                                </option>
                                <option value="protection" {{ old('role') == 'protection' ? 'selected' : '' }}>Protected
                                </option>
                                <option value="contract" {{ old('role') == 'contract' ? 'selected' : '' }}>Contract
                                </option>
                                <option value="sop" {{ old('role') == 'sop' ? 'selected' : '' }}>SOP</option>
                                <option value="protectbusiness"
                                    {{ old('role') == 'protectbusiness' ? 'selected' : '' }}>Protect Business</option>
                                <option value="protectfamily" {{ old('role') == 'protectfamily' ? 'selected' : '' }}>
                                    Protect Family</option>
                                <option value="protectindividual"
                                    {{ old('role') == 'protectindividual' ? 'selected' : '' }}>Protect Individual</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Position -->
                        <div class="xl:col-span-6">
                            <label for="positionIdInput" class="mb-2 font-medium">Position</label>
                            <select name="position_id" id="positionIdInput"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                <option value="" disabled>Select Position</option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}"
                                        {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                        {{ $position->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('position_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Chapter Department -->
                        <div class="xl:col-span-6">
                            <label for="chapterIdInput" class="mb-2 font-medium">Chapter Department</label>
                            <select name="chapter_id" id="chapterIdInput"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                <option value="" disabled>Select Chapter</option>
                                @foreach ($chapters as $chapter)
                                    <option value="{{ $chapter->id }}"
                                        {{ old('chapter_id') == $chapter->id ? 'selected' : '' }}>
                                        {{ $chapter->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('chapter_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Sub Chapter Department -->
                        <div class="xl:col-span-12">
                            <label for="subChapterIdInput" class="mb-2 font-medium">Sub Chapter Department</label>
                            <select name="sub_chapter_id" id="subChapterIdInput"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                <option value="" disabled>Select Sub Chapter</option>
                                @foreach ($subChapters as $subChapter)
                                    <option value="{{ $subChapter->id }}"
                                        {{ old('sub_chapter_id') == $subChapter->id ? 'selected' : '' }}>
                                        {{ $subChapter->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sub_chapter_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="xl:col-span-12">
                            <label for="addressInput" class="mb-2 font-medium">Address</label>
                            <textarea type="text" name="address" id="addressInput" placeholder="Address"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                >{{ old('address') }}</textarea>
                            @error('address')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="xl:col-span-12">
                            <label for="statusInput" class="mb-2 font-medium">Status</label>
                            <select name="status" id="statusInput"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                                <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspended
                                </option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="reset" data-modal-close="addEmployeeModal"
                            class="btn bg-white text-red-500">Cancel</button>
                        <button type="submit" class="btn bg-custom-500 text-white">Add Employee</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!--end add Employee-->

    <!--edit Employee-->
    <div id="editEmployeeModal" modal-center=""
        class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show ">
        <div class="w-screen md:w-[30rem] bg-white shadow rounded-md dark:bg-zink-600">
            <div class="flex items-center justify-between p-4 border-b dark:border-zink-500">
                <h5 class="text-16">Edit Employee</h5>
                <button data-modal-close="editEmployeeModal"
                    class="transition-all duration-200 ease-linear text-slate-400 hover:text-red-500">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
                <form class="create-form" id="edit-form" action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="e_id" name="id">

                    <div class="grid grid-cols-1 gap-4 xl:grid-cols-12">

                        <!-- Profile Photo -->
                        <div class="xl:col-span-12 text-center mb-4">
                            <div
                                class="relative mx-auto rounded-full shadow-md size-24 bg-slate-100 profile-user dark:bg-zink-500">
                                <img src="{{ URL::to('assets/images/user.png') }}" alt=""
                                    class="object-cover w-full h-full rounded-full edit-user-profile-image">
                                <div
                                    class="absolute bottom-0 right-0 flex items-center justify-center rounded-full size-8 profile-photo-edit">
                                    <input id="e_profile-img-file-input" name="photo" type="file" class="hidden">
                                    <label for="e_profile-img-file-input"
                                        class="flex items-center justify-center bg-white rounded-full shadow-lg cursor-pointer size-8 dark:bg-zink-600">
                                        <i data-lucide="image-plus"
                                            class="size-4 text-slate-500 fill-slate-200 dark:text-zink-200 dark:fill-zink-500"></i>
                                    </label>
                                </div>
                            </div>
                            @error('photo')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- Employee ID -->
                        <div class="xl:col-span-6">
                            <label for="e_employeeIdInput" class="mb-2 font-medium">Employee ID</label>
                            <input type="text" name="employee_id" id="e_employeeIdInput" placeholder="Employee ID"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                value="{{ old('employee_id') }}">
                            @error('employee_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div class="xl:col-span-6">
                            <label for="e_nameInput" class="mb-2 font-medium">Name</label>
                            <input type="text" name="name" id="e_nameInput" placeholder="Full Name"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="xl:col-span-12">
                            <label for="e_emailInput" class="mb-2 font-medium">Email</label>
                            <input type="email" name="email" id="e_emailInput" placeholder="example@domain.com"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                value="{{ old('email') }}">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="xl:col-span-6">
                            <label for="e_phoneInput" class="mb-2 font-medium">Phone</label>
                            <input type="tel" name="phone" id="e_phoneInput" placeholder="Phone Number"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                value="{{ old('phone') }}">
                            @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="xl:col-span-6">
                            <label for="e_passwordInput" class="mb-2 font-medium">Password</label>
                            <input type="password" name="password" id="e_passwordInput" placeholder="Password"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div class="xl:col-span-6">
                            <label for="e_dateBirthInput" class="mb-2 font-medium">Date of Birth</label>
                            <input type="date" name="date_birth" id="e_dateBirthInput"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                value="{{ old('date_birth') }}">
                            @error('date_birth')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="xl:col-span-6">
                            <label for="e_genderInput" class="mb-2 font-medium">Gender</label>
                            <select name="gender" id="e_genderInput"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                <option value="" disabled>Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- Role --}}

                        <div class="xl:col-span-6">
                            <label for="e_roleInput" class="mb-2 font-medium">Role</label>
                            <select name="role" id="e_roleInput"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                <option value="" disabled>Select Role</option>
                                <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee
                                </option>
                                <option value="lawyer" {{ old('role') == 'lawyer' ? 'selected' : '' }}>Lawyer</option>
                                <option value="criminal" {{ old('role') == 'criminal' ? 'selected' : '' }}>Criminal
                                </option>
                                <option value="civil" {{ old('role') == 'civil' ? 'selected' : '' }}>Civil</option>
                                <option value="outcourt" {{ old('role') == 'outcourt' ? 'selected' : '' }}>Outcourt
                                </option>
                                <option value="protection" {{ old('role') == 'protection' ? 'selected' : '' }}>Protected
                                </option>
                                <option value="contract" {{ old('role') == 'contract' ? 'selected' : '' }}>Contract
                                </option>
                                <option value="sop" {{ old('role') == 'sop' ? 'selected' : '' }}>SOP</option>
                                <option value="protectbusiness"
                                    {{ old('role') == 'protectbusiness' ? 'selected' : '' }}>Protect Business</option>
                                <option value="protectfamily" {{ old('role') == 'protectfamily' ? 'selected' : '' }}>
                                    Protect Family</option>
                                <option value="protectindividual"
                                    {{ old('role') == 'protectindividual' ? 'selected' : '' }}>Protect Individual</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Position -->
                        <div class="xl:col-span-6">
                            <label for="e_positionIdInput" class="mb-2 font-medium">Position</label>
                            <select name="position_id" id="e_positionIdInput"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                <option value="" disabled>Select Position</option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}"
                                        {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                        {{ $position->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('position_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Chapter Department -->
                        <div class="xl:col-span-6">
                            <label for="e_chapterIdInput" class="mb-2 font-medium">Chapter Department</label>
                            <select name="chapter_id" id="e_chapterIdInput"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                <option value="" disabled>Select Chapter</option>
                                @foreach ($chapters as $chapter)
                                    <option value="{{ $chapter->id }}"
                                        {{ old('chapter_id') == $chapter->id ? 'selected' : '' }}>
                                        {{ $chapter->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('chapter_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Sub Chapter Department -->
                        <div class="xl:col-span-6">
                            <label for="e_subChapterIdInput" class="mb-2 font-medium">Sub Chapter Department</label>
                            <select name="sub_chapter_id" id="e_subChapterIdInput"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                <option value="" disabled>Select Sub Chapter</option>
                                @foreach ($subChapters as $subChapter)
                                    <option value="{{ $subChapter->id }}"
                                        {{ old('sub_chapter_id') == $subChapter->id ? 'selected' : '' }}>
                                        {{ $subChapter->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sub_chapter_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="xl:col-span-12">
                            <label for="e_addressInput" class="mb-2 font-medium">Address</label>
                            <textarea name="address" id="e_addressInput" rows="3" placeholder="Address"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">{{ old('address') }}</textarea>
                            @error('address')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>


                        <!-- Status -->
                        <div class="xl:col-span-12">
                            <label for="e_statusInput" class="mb-2 font-medium">Status</label>
                            <select name="status" id="e_statusInput"
                                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                                <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspended
                                </option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="flex justify-end gap-2 mt-4">
                        <button type="reset" id="close-modal" data-modal-close="editEmployeeModal"
                            class="text-red-500 bg-white btn hover:text-red-500 hover:bg-red-100 focus:text-red-500 focus:bg-red-100 active:text-red-500 active:bg-red-100 dark:bg-zink-600 dark:hover:bg-red-500/10 dark:focus:bg-red-500/10 dark:active:bg-red-500/10">Cancel</button>
                        <button type="submit" id="addNew"
                            class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20 ">Update
                            Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end edit Employee-->
    <!-- delete modal-->
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
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id_delete" id="e_idDelete" value="">
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
    {{-- update js --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll(".editEmployeeBtn").forEach(btn => {
                btn.addEventListener("click", function() {
                    // Fill hidden ID
                    document.getElementById("e_id").value = this.dataset.id || '';

                    // Fill input fields - matching the form IDs
                    document.getElementById("e_employeeIdInput").value = this.dataset.employee_id ||
                        '';
                    document.getElementById("e_nameInput").value = this.dataset.name || '';
                    document.getElementById("e_emailInput").value = this.dataset.email || '';
                    document.getElementById("e_phoneInput").value = this.dataset.phone || '';

                    // Date of Birth
                    let dob = this.dataset.date_birth || '';
                    if (dob) {
                        const date = new Date(dob);
                        if (!isNaN(date)) {
                            const yyyy = date.getFullYear();
                            const mm = String(date.getMonth() + 1).padStart(2, '0');
                            const dd = String(date.getDate()).padStart(2, '0');
                            dob = `${yyyy}-${mm}-${dd}`;
                        } else {
                            dob = '';
                        }
                    }
                    document.getElementById("e_dateBirthInput").value = dob;

                    // Gender (select) - matching form values (lowercase)
                    let genderSelect = document.getElementById("e_genderInput");
                    if (genderSelect) {
                        let genderValue = this.dataset.gender || '';
                        genderValue = genderValue.trim().toLowerCase();
                        genderSelect.value = genderValue;
                    }

                    // Position
                    document.getElementById("e_roleInput").value = this.dataset.role ||
                        '';
                    // Position
                    document.getElementById("e_positionIdInput").value = this.dataset.position_id ||
                        '';

                    // Chapter Department
                    document.getElementById("e_chapterIdInput").value = this.dataset.chapter_id ||
                        '';

                    // Sub Chapter Department
                    document.getElementById("e_subChapterIdInput").value = this.dataset
                        .sub_chapter_id || '';

                    // Address
                    document.getElementById("e_addressInput").value = this.dataset.address || '';

                    // Status
                    document.getElementById("e_statusInput").value = this.dataset.status ||
                        'active';
                    // handle image
                    let preview = document.querySelector(".edit-user-profile-image");
                    let photo = this.dataset.photo;

                    // Use full URL directly
                    if (photo && photo !== "") {
                        preview.src = photo;
                    } else {
                        preview.src = "/assets/images/user.png"; // default image
                    }



                    // Set form action URL
                    const form = document.getElementById("edit-form");
                    if (form) {
                        form.action = `/employee/manage/${this.dataset.id}`;
                    }
                });
            });
        });
    </script>
    {{-- delete js --}}
    <script>
        $(document).on('click', '#deleteRecord', function() {
            var _this = $(this).closest('tr'); // get the row
            var id = _this.find('.ids').text(); // get employee id
            $('#e_idDelete').val(id); // fill hidden input

            // dynamically set form action
            var url = "{{ route('employee.manage.destroy', ':id') }}";
            url = url.replace(':id', id);
            $('#deleteForm').attr('action', url);
        });
    </script>

    <script>
        // ADD Profile Preview
        if (document.querySelector("#profile-img-file-input")) {
            document.querySelector("#profile-img-file-input").addEventListener("change", function(e) {
                let preview = document.querySelector(".user-profile-image");
                let file = e.target.files[0];
                let reader = new FileReader();
                reader.onload = () => preview.src = reader.result;
                if (file) reader.readAsDataURL(file);
            });
        }

        // EDIT Profile Preview (Correct)
        if (document.querySelector("#e_profile-img-file-input")) {
            document.querySelector("#e_profile-img-file-input").addEventListener("change", function(e) {
                let preview = document.querySelector(".edit-user-profile-image");
                let file = e.target.files[0];
                let reader = new FileReader();
                reader.onload = () => preview.src = reader.result;
                if (file) reader.readAsDataURL(file);
            });
        }
    </script>
@endsection
@endsection
