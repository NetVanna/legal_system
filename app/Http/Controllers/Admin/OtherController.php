<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Costs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OtherController extends Controller
{
    public function listCost(){
        $itemCosts = Costs::all();
        return view("pages.admin.others.costs.index",compact("itemCosts"));
    }

    public function costStore(Request $request)
    {
        $request->validate([
            'purchase_date'=> 'nullable|date',
            'purchased_by'=> 'nullable|string|max:255',
            'paid_by'=> 'nullable|string|max:255',
            'item_name'=> 'nullable|string|max:255',
            'item_description'=> 'nullable|string|max:255',
            'amount'=> 'nullable',
        ]);
        try {
            // --- Create Client ---
            $itemCosts = new Costs();
            $itemCosts->fill([
                'purchase_date' => $request->purchase_date,
                'purchased_by' => $request->purchased_by,
                'paid_by' => $request->paid_by,
                'item_name' => $request->item_name,
                'item_description' => $request->item_description,
                'amount' => $request->amount,
            ]);
            $itemCosts->save();
            flash()->success('Item cost added successfully.');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error($e);
            flash()->error('Failed to add item cost.');
            return redirect()->back();
        }
    }
    public function costUpdate(Request $request, $id)
    {
        try {
            $itemCosts = Costs::findOrFail($id);
            $itemCosts->update([
                'purchase_date' => $request->purchase_date,
                'purchased_by' => $request->purchased_by,
                'paid_by' => $request->paid_by,
                'item_name' => $request->item_name,
                'item_description' => $request->item_description,
                'amount' => $request->amount,
            ]);

            flash()->success('item costs updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            // dd($e->getMessage());
            Log::info($e);
            flash()->error('Failed to update item costs.');
            return redirect()->back();
        }
    }

    public function costDestroy($id)
    {
        try {
            $itemCosts = Costs::findOrFail($id);
            $itemCosts->delete();

            flash()->success('Item costs deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::info($e);
            flash()->error('Delete record fail :)');
            return redirect()->back();
        }
    }
}
