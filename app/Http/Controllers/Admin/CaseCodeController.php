<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CaseCodeController extends Controller
{
    public function index()
    {
        $caseCodes = CaseCode::all();
        return view("pages.admin.casecodes.index", compact("caseCodes"));
    }


    public function store(Request $request)
    {
        $request->validate([
            'code'        => 'required|string|max:255',
            'description'     => 'nullable|string|max:255',
            'date'  => 'nullable|date',
        ]);
        try {

            // --- Create Client ---
            $caseCodes = new CaseCode();
            $caseCodes->fill([
                'code' => $request->code,
                'description' => $request->description,
                'date' => $request->date,
            ]);
            $caseCodes->save();
            flash()->success('Case Code added successfully.');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error($e);
            flash()->error('Failed to add case code.');
            return redirect()->back();
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $caseCodes = CaseCode::findOrFail($id);

            $caseCodes->update([
                'code' => $request->code,
                'description' => $request->description,
                'date' => $request->date,
            ]);

            flash()->success('Case code updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            // dd($e->getMessage());
            Log::info($e);
            flash()->error('Failed to update case code.');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $caseCodes = CaseCode::findOrFail($id);
            $caseCodes->delete();

            flash()->success('Case code deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::info($e);
            flash()->error('Delete record fail :)');
            return redirect()->back();
        }
    }
}
