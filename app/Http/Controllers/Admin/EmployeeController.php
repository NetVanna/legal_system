<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChapterDepartments;
use App\Models\Position;
use App\Models\SubChapterDepartments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /** Employee list */
    public function index()
    {
        $employeeList = User::orderBy('id', 'desc')->get();

        $positions = Position::where('status', 'active')->get();
        $chapters = ChapterDepartments::where('status', 'active')->get();
        $subChapters = SubChapterDepartments::where('status', 'active')->get();

        return view('pages.admin.employees.employee', compact('employeeList', 'positions', 'chapters', 'subChapters'));
    }


    /** save record employee */
    public function store(Request $request)
    {
        $request->validate([
            // your validation rules
        ]);

        try {
            $photoName = null;

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $photoName = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/images/user'), $photoName);
            }

            $user = new User();

            $user->employee_id = $request->employee_id;
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->email_verified_at = null;
            $user->password = Hash::make($request->password);
            $user->role = $request->role ?? 'employee';
            $user->date_birth = $request->date_birth;
            $user->gender = $request->gender;
            $user->address = $request->address;
            $user->photo = $photoName;
            $user->status = $request->status ?? 'active';

            $user->position_id = $request->position_id;

            if ($request->position_id) {
                $position = \App\Models\Position::find($request->position_id);
                $user->position = $position ? $position->name : null;
            } else {
                $user->position = null;
            }

            $user->chapter_id = $request->chapter_id;
            $user->sub_chapter_id = $request->sub_chapter_id;

            $user->save();
            flash()->success('Employee added successfully.');
            return redirect()->route('employee.manage.index'); // or wherever the list page is

        } catch (\Exception $e) {
            // dd('Exception: ' . $e->getMessage());
            Log::error($e->getMessage());
            flash()->error('Failed to add employee.');
            return redirect()->back()->withInput();
        }
    }




    /** Update Record Employee */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'photo'           => 'nullable|image|max:2048',
            'employee_id'     => ['nullable', Rule::unique('users', 'employee_id')->ignore($id)],
            'name'            => 'required|string|max:255',
            'username'        => ['nullable', Rule::unique('users', 'username')->ignore($id)],
            'phone'           => ['nullable', Rule::unique('users', 'phone')->ignore($id)],
            'email'           => ['nullable', 'email', Rule::unique('users', 'email')->ignore($id)],
            'role'            => 'nullable|string',
            'date_birth'      => 'nullable|date',
            'gender'          => ['nullable', Rule::in(['male', 'female', 'other'])],
            'position_id'     => 'nullable|exists:positions,id',
            'chapter_id'      => 'nullable|exists:chapter_departments,id',
            'sub_chapter_id'  => 'nullable|exists:sub_chapter_departments,id',
            'address'         => 'nullable|string|max:500',
            'status'          => ['nullable', Rule::in(['active', 'inactive', 'suspended'])],
            'password'        => 'nullable|min:6',
        ]);

        try {

            /** Handle image upload */
            if ($request->hasFile('photo')) {

                // delete old photo safely
                if ($user->photo) {
                    $oldPath = public_path('assets/images/user/' . $user->photo);
                    if (is_file($oldPath)) {
                        @unlink($oldPath);
                    }
                }

                // upload new
                $photoName = time() . '.' . $request->photo->extension();
                $request->photo->move(public_path('assets/images/user'), $photoName);
                $user->photo = $photoName;
            }

            /** Update basic fields */
            $user->fill([
                'employee_id'     => $request->employee_id,
                'name'            => $request->name,
                'username'        => $request->username,
                'email'           => $request->email,
                'phone'           => $request->phone,
                'role'            => $request->role ?? $user->role,
                'date_birth'      => $request->date_birth,
                'gender'          => $request->gender,
                'address'         => $request->address,
                'status'          => $request->status ?? $user->status,
                'position_id'     => $request->position_id,
                'chapter_id'      => $request->chapter_id,
                'sub_chapter_id'  => $request->sub_chapter_id,
            ]);

            /** Update password only if provided */
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            /** Store position name for legacy UI (optional) */
            if ($request->position_id) {
                $position = \App\Models\Position::find($request->position_id);
                $user->position = $position?->name;
            }

            $user->save();

            flash()->success('User updated successfully.');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error('Update User Error: ' . $e->getMessage());
            flash()->error('Failed to update user.');
            return redirect()->back()->withInput();
        }
    }



    /** Delete Record Employee */
    public function destroy(Request $request)
    {
        try {
            $deleteRecord = User::findOrFail($request->id_delete);
            $deleteRecord->delete();
            if (!empty($request->del_photo)) {
                unlink(public_path('assets/images/user/' . $request->del_photo));
            }

            flash()->success('Delete record successfully :)');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();
            flash()->error('Delete record fail :)');
            return redirect()->back();
        }
    }
}
