<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChapterDepartments;
use App\Models\SubChapterDepartments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubChaptersController extends Controller
{
    public function index()
    {
        // Fix: Remove ::all() - just use get()
        $subChapterDepartments = SubChapterDepartments::with(['chapter', 'headUser'])->get();
        $users = User::select('id', 'name')->get();
        $chapterDepartments = ChapterDepartments::select('id', 'name')->get();

        return view("pages.admin.subchapters.index", compact("subChapterDepartments", "users", "chapterDepartments"));
    }

    public function store(Request $request)
    {
        $request->validate([
            'chapter_id' => 'required|exists:chapter_departments,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:sub_chapter_departments,code',
            'description' => 'nullable|string',
            'head_user_id' => 'nullable|exists:users,id',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $subchapterDepartments = new SubChapterDepartments();
            $subchapterDepartments->fill([
                'chapter_id' => $request->chapter_id,
                'name' => $request->name,
                'code' => $request->code,
                'description' => $request->description,
                'head_user_id' => $request->head_user_id,
                'status' => $request->status,
            ]);
            // dd($request->all());

            $subchapterDepartments->save();
            flash()->success('SubChapter departments added successfully.');
        } catch (\Exception $e) {
            Log::error($e);
            dd($e->getMessage());
            flash()->error('Failed to add subchapter Departments.');
        }
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'chapter_id' => 'required|exists:chapter_departments,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:sub_chapter_departments,code,' . $id,
            'description' => 'nullable|string',
            'head_user_id' => 'nullable|exists:users,id',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $subChapterDepartments = SubChapterDepartments::findOrFail($id);

            $subChapterDepartments->update([
                'chapter_id' => $request->chapter_id,
                'name' => $request->name,
                'code' => $request->code,
                'description' => $request->description,
                'head_user_id' => $request->head_user_id,
                'status' => $request->status,
            ]);

            flash()->success('SubChapter departments updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::info($e);
            flash()->error('Failed to update SubChapter departments.');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $subChapterDepartments = SubChapterDepartments::findOrFail($id);
            $subChapterDepartments->delete();

            flash()->success('SubChapter departments deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::info($e);
            flash()->error('Delete record fail :)');
            return redirect()->back();
        }
    }
}
