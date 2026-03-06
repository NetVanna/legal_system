<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChapterDepartments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class ChaptersController extends Controller
{
    public function index()
    {
        $chapterDepartments = ChapterDepartments::with('headUser')->latest()->get();
        $users = User::select('id', 'name')->get();
        return view("pages.admin.chapters.index", compact("chapterDepartments","users"));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:50|unique:chapter_departments,code',
            'description' => 'nullable|string',
            'head_user_id' => 'nullable|exists:users,id',
            'status'      => 'required|in:active,inactive',
        ]);

        try {

            // --- Create chapterDepartments ---
            $chapterDepartments = new ChapterDepartments();
            $chapterDepartments->fill([
                'name'         => $request->name,
                'code'         => $request->code,
                'description'  => $request->description,
                'head_user_id' => $request->head_user_id,
                'status'       => $request->status,
            ]);

            $chapterDepartments->save();
            flash()->success('Chapter departments added successfully.');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error($e);
            flash()->error('Failed to add chapter Departments.');
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $chapterDepartments = ChapterDepartments::findOrFail($id);

            $chapterDepartments->update([
                'name'         => $request->name,
                'code'         => $request->code,
                'description'  => $request->description,
                'head_user_id' => $request->head_user_id,
                'status'       => $request->status,
            ]);

            flash()->success('Chapter departments updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::info($e);
            flash()->error('Failed to update Chapter departments.');
            return redirect()->back();
        }
    }



    public function destroy($id)
    {

        try {
            $chapterDepartments = ChapterDepartments::findOrFail($id);
            $chapterDepartments->delete();

            flash()->success('Chapter departments deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::info($e);
            flash()->error('Delete record fail :)');
            return redirect()->back();
        }
    }
}
