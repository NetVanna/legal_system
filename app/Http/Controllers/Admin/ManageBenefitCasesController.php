<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BenefitCases;
use App\Models\Cases;
use Illuminate\Http\Request;

class ManageBenefitCasesController extends Controller
{
    public function index(Request $request)
    {

        $query = BenefitCases::with('case');

        // Filter by month if provided
        if ($request->has('month') && $request->month) {
            $query->whereMonth('date', $request->month);
        }

        // Filter by year if provided
        if ($request->has('year') && $request->year) {
            $query->whereYear('date', $request->year);
        }

        $benefits = $query->orderBy('date', 'desc')->get();

        // Get available months and years for filter dropdown
        $availableMonths = BenefitCases::selectRaw('DISTINCT MONTH(date) as month, YEAR(date) as year')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
        return view("pages.admin.benefit_cases.index", compact("benefits","availableMonths"));
    }

    public function create()
    {
        // Get all cases with related data
        $cases = Cases::with(['client', 'lawyer', 'chapter', 'subchapter', 'casecode'])
            ->whereDoesntHave('benefitCase') // Only cases without benefit records
            ->get();

        return view("pages.admin.benefit_cases.create", compact('cases'));
    }

    public function getCaseDetails($id)
    {
        try {
            // API endpoint to get case details
            $case = Cases::with(['client', 'lawyer', 'instructor', 'chapter', 'subchapter', 'casecode'])
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'case_number' => $case->case_number ?? '',
                'client_name' => $case->client->name ?? ($case->client->first_name ?? '') . ' ' . ($case->client->last_name ?? ''),
                'case_type' => $case->case_type ?? '',
                'filed_date' => $case->filed_date ? $case->filed_date->format('Y-m-d') : '',
                'chapter' => $case->chapter->name ?? '',
                'sub_chapter' => $case->subchapter->name ?? '',
                'lawyer' => $case->lawyer->name ?? ($case->lawyer->first_name ?? '') . ' ' . ($case->lawyer->last_name ?? ''),
                'instructor' => $case->instructor->name ?? ($case->instructor->first_name ?? '') . ' ' . ($case->instructor->last_name ?? ''),
                'service_fee' => $case->payment_amount ?? 0,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch case details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'case_id' => 'required|exists:cases,id',
            'client_name' => 'required|string|max:255',
            'type_case' => 'required|string|max:255',
            'date' => 'required|date',
            'chapter' => 'nullable|string|max:255',
            'sub_chapter' => 'nullable|string|max:255',
            'service_fee' => 'required|numeric|min:0',
            'lawyer' => 'required|string|max:255',
            'employee' => 'required|string|max:255',
            'employee_fee' => 'required|numeric|min:0',
            'chapter_fee' => 'required|numeric|min:0',
            'admin_fee' => 'required|numeric|min:0',
            'it_fee' => 'required|numeric|min:0',
            'lawyer_percent' => 'required|numeric|min:0|max:100',
            'lawyer_fee' => 'required|numeric|min:0',
            'net_fee' => 'required|numeric',
        ]);

        try {
            // Check if benefit case already exists for this case
            $existingBenefit = BenefitCases::where('case_id', $validated['case_id'])->first();

            if ($existingBenefit) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Benefit case already exists for this case!');
            }

            // Create the benefit_case record
            BenefitCases::create([
                'case_id' => $validated['case_id'],
                'client_name' => $validated['client_name'],
                'type_case' => $validated['type_case'],
                'date' => $validated['date'],
                'chapter' => $validated['chapter'],
                'sub_chapter' => $validated['sub_chapter'],
                'service_fee' => $validated['service_fee'],
                'employee' => $validated['employee'],
                'employee_fee' => $validated['employee_fee'],
                'chapter_fee' => $validated['chapter_fee'],
                'admin_fee' => $validated['admin_fee'],
                'it_fee' => $validated['it_fee'],
                'lawyer' => $validated['lawyer'],
                'lawyer_fee' => $validated['lawyer_fee'],
                'net_fee' => $validated['net_fee'],
            ]);

            return redirect()
                ->route('manage.benefit.case.list')
                ->with('success', 'Benefit case created successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create benefit case: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        // Get the benefit case with its related case
        $benefitCase = BenefitCases::with('case')->findOrFail($id);

        // Get all cases for the dropdown (including the current one)
        $cases = Cases::with(['client', 'lawyer', 'chapter', 'subchapter', 'casecode'])
            ->where(function ($query) use ($benefitCase) {
                $query->whereDoesntHave('benefitCase')
                    ->orWhere('id', $benefitCase->case_id);
            })
            ->get();

        return view("pages.admin.benefit_cases.edit", compact('benefitCase', 'cases'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'case_id' => 'required|exists:cases,id',
            'client_name' => 'required|string|max:255',
            'type_case' => 'required|string|max:255',
            'date' => 'required|date',
            'chapter' => 'nullable|string|max:255',
            'sub_chapter' => 'nullable|string|max:255',
            'service_fee' => 'required|numeric|min:0',
            'lawyer' => 'required|string|max:255',
            'employee' => 'required|string|max:255',
            'employee_fee' => 'required|numeric|min:0',
            'chapter_fee' => 'required|numeric|min:0',
            'admin_fee' => 'required|numeric|min:0',
            'it_fee' => 'required|numeric|min:0',
            'lawyer_percent' => 'required|numeric|min:0|max:100',
            'lawyer_fee' => 'required|numeric|min:0',
            'net_fee' => 'required|numeric',
        ]);

        try {
            $benefitCase = BenefitCases::findOrFail($id);

            // Check if case_id is being changed to one that already has a benefit case
            if ($benefitCase->case_id != $validated['case_id']) {
                $existingBenefit = BenefitCases::where('case_id', $validated['case_id'])
                    ->where('id', '!=', $id)
                    ->first();

                if ($existingBenefit) {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->with('error', 'The selected case already has a benefit case!');
                }
            }

            // Update the benefit case
            $benefitCase->update([
                'case_id' => $validated['case_id'],
                'client_name' => $validated['client_name'],
                'type_case' => $validated['type_case'],
                'date' => $validated['date'],
                'chapter' => $validated['chapter'],
                'sub_chapter' => $validated['sub_chapter'],
                'service_fee' => $validated['service_fee'],
                'employee' => $validated['employee'],
                'employee_fee' => $validated['employee_fee'],
                'chapter_fee' => $validated['chapter_fee'],
                'admin_fee' => $validated['admin_fee'],
                'it_fee' => $validated['it_fee'],
                'lawyer' => $validated['lawyer'],
                'lawyer_fee' => $validated['lawyer_fee'],
                'net_fee' => $validated['net_fee'],
            ]);

            return redirect()
                ->route('manage.benefit.case.list')
                ->with('success', 'Benefit case updated successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update benefit case: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $benefitCase = BenefitCases::findOrFail($id);
            $benefitCase->delete();

            return redirect()
                ->route('manage.benefit.case.list')
                ->with('success', 'Benefit case deleted successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete benefit case: ' . $e->getMessage());
        }
    }
}
