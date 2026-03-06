<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::latest()->get();
        return view("pages.admin.positions.index", compact("positions"));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:100|unique:positions,code',
            'description' => 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ]);

        try {

            // --- Create chapterDepartments ---
            $positions = new Position();
            $positions->fill([
                'name'        => $request->name,
                'code'        => $request->code,
                'description' => $request->description,
                'status'      => $request->status,
            ]);

            $positions->save();
            flash()->success('Positions added successfully.');
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error($e);
            flash()->error('Failed to add Positions.');
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $positions = Position::findOrFail($id);

            $positions->update([
                'name'        => $request->name,
                'code'        => $request->code,
                'description' => $request->description,
                'status'      => $request->status,
            ]);

            flash()->success('Positions updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::info($e);
            flash()->error('Failed to update Positions.');
            return redirect()->back();
        }
    }



    public function destroy($id)
    {

        try {
            $positions = Position::findOrFail($id);
            $positions->delete();

            flash()->success('Positions deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::info($e);
            flash()->error('Delete record fail :)');
            return redirect()->back();
        }
    }
}
