<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseCode;
use App\Models\Cases;
use App\Models\ChapterDepartments;
use App\Models\Clients;
use App\Models\SubChapterDepartments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class CasesController extends Controller
{
    public function index()
    {
        $casesCriminalCount = Cases::where('case_type', 'រឿងក្ដីព្រហ្មទណ្ឌ')->count();
        $casesCivilCount = Cases::where('case_type', 'រឿងក្ដីរដ្ឋប្បវេណី')->count();
        $casesProtectionCount = Cases::where('case_type', 'រឿងក្ដីរក្សាការពារ')->count();
        $casesOutcourtCount = Cases::where('case_type', 'ដោះស្រាយក្រៅតុលាការ')->count();
        $casesContractCount = Cases::where('case_type', 'កិច្ចសន្យា')->count();
        $casesSOPCount = Cases::where('case_type', 'ស្ដង់ដារអាជីវកម្ម')->count();
        $casesBusinessProtectionCount = Cases::where('case_type', 'គាំពារអាជីវកម្ម')->count();
        $casesFamilyProtectionCount = Cases::where('case_type', 'គាំពារគ្រួសារ')->count();
        $casesPersonalProtectionCount = Cases::where('case_type', 'គាំពារបុគ្គល')->count();
        $casesOtherCount = Cases::where('case_type', 'ផ្សេងៗ')->count();
        return view("pages.admin.cases.index", compact("casesCriminalCount", "casesCivilCount", "casesProtectionCount", "casesOutcourtCount", "casesContractCount", "casesSOPCount", "casesBusinessProtectionCount", "casesFamilyProtectionCount","casesPersonalProtectionCount","casesOtherCount"));
    }


    /*================================= Start Protection ===================================================*/
    public function createProtection()
    {
        return view("pages.admin.cases.protections.index");
    }
    /*================================= End Protection ===================================================*/
    /*================================= Start Outcourt ===================================================*/
    public function createOutcourt()
    {
        return view("pages.admin.cases.outcourts.index");
    }
    /*================================= End Outcourt ===================================================*/
    /*================================= Start Contract ===================================================*/
    public function createContract()
    {
        return view("pages.admin.cases.contract.index");
    }
    /*================================= End Contract ===================================================*/
    public function createSop()
    {
        return view("pages.admin.cases.sop.index");
    }
    /*================================= End Sop ===================================================*/
    /*================================= Start BusinessProtection ===================================================*/
    public function createBusinessProtection()
    {
        return view("pages.admin.cases.business_protection.index");
    }
    /*================================= End BusinessProtection ===================================================*/
    /*================================= Start FamilyProtection ===================================================*/
    public function createFamilyProtection()
    {
        return view("pages.admin.cases.family_protection.index");
    }
    /*================================= End FamilyProtection ===================================================*/
    /*================================= Start PersonalProtection ===================================================*/
    public function createPersonalProtection()
    {
        return view("pages.admin.cases.personal_protection.index");
    }
    /*================================= End PersonalProtection ===================================================*/
    /*================================= Start Others ===================================================*/

    public function createOthers()
    {
        return view("pages.admin.cases.others.index");
    }
    /*================================= End Others ===================================================*/

    public function update(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'case_number' => 'required|string|max:255|unique:cases,case_number,' . $id,
            'case_title' => 'nullable|string|max:255',
            'filed_date' => 'required|date',
            'client_id' => 'required|exists:clients,id',
            'lawyer_id' => 'required|exists:users,id',
            'instructor_id' => 'nullable|exists:users,id',
            'chapter_id' => 'nullable|exists:chapter_departments,id',
            'subchapter_id' => 'nullable|exists:sub_chapter_departments,id',
            'casecode_id' => 'nullable|exists:case_codes,id',
            'case_status' => 'required|in:open,in_progress,closed,won,lost,settled',
            'day_judge' => 'nullable|date',
            'day_show' => 'nullable|date',
            'case_data.0.court' => 'nullable|string|max:255',
            'closed_date' => 'nullable|date',
            'description' => 'nullable|string',
            'outcome' => 'nullable|string',
            'payment_type' => 'nullable|in:cash,bank_transfer,check',
            'case_price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|string|max:50',
            'payment_amount' => 'nullable|numeric|min:0',
            'payment_status' => 'nullable|in:unpaid,partial,paid',
            'client_relative.*.name' => 'nullable|string|max:255',
            'client_relative.*.relationship' => 'nullable|string|max:255',
            'client_relative.*.phone' => 'nullable|string|max:20',
            'opponents.*.name' => 'nullable|string|max:255',
            'opponents.*.phone' => 'nullable|string|max:20',
            'opponents.*.email' => 'nullable|email|max:255',
            'opponents.*.address' => 'nullable|string|max:500',
            'existing_documents' => 'nullable|array',
            'documents' => 'nullable|array',
            'documents.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif|max:10240'
        ]);

        try {
            DB::beginTransaction();

            $case = Cases::findOrFail($id);

            // Get old documents for potential cleanup
            $oldDocuments = [];
            if (is_string($case->documents)) {
                $oldDocuments = json_decode($case->documents, true) ?? [];
            } elseif (is_array($case->documents)) {
                $oldDocuments = $case->documents;
            }

            // Prepare client relatives data
            $clientRelatives = [];
            if ($request->has('client_relative')) {
                foreach ($request->client_relative as $relative) {
                    if (!empty($relative['name'])) {
                        $clientRelatives[] = [
                            'name' => $relative['name'],
                            'relationship' => $relative['relationship'] ?? null,
                            'phone' => $relative['phone'] ?? null,
                        ];
                    }
                }
            }

            // Prepare opponents data
            $opponentsData = [];
            if ($request->has('opponents')) {
                foreach ($request->opponents as $opponent) {
                    if (!empty($opponent['name'])) {
                        $opponentsData[] = [
                            'name' => $opponent['name'],
                            'phone' => $opponent['phone'] ?? null,
                            'email' => $opponent['email'] ?? null,
                            'address' => $opponent['address'] ?? null,
                        ];
                    }
                }
            }

            // Prepare case_data
            $caseData = [];
            if ($request->filled('case_data.0.court')) {
                $caseData[] = [
                    'court' => $request->input('case_data.0.court')
                ];
            }

            // ⭐ PHP CHANGE #1: Handle existing documents (documents to keep) ⭐
            $existingDocuments = [];
            if ($request->has('existing_documents')) {
                // 🔥 ADDED: Debug logging
                Log::info('Existing documents received', [
                    'count' => count($request->existing_documents),
                    'data' => $request->existing_documents
                ]);

                foreach ($request->existing_documents as $docJson) {
                    $doc = json_decode($docJson, true);
                    if ($doc && isset($doc['file_path']) && !empty($doc['file_path'])) {
                        $existingDocuments[] = $doc;
                    }
                }

                // 🔥 ADDED: Debug logging after processing
                Log::info('Existing documents after processing', [
                    'count' => count($existingDocuments)
                ]);
            } else {
                // 🔥 ADDED: Debug logging if no documents
                Log::info('No existing_documents in request');
            }

            // ⭐ PHP CHANGE #2: Determine which documents were removed (for deletion) ⭐
            $documentsToDelete = [];
            // 🔥 ADDED: Debug logging for comparison
            Log::info('Comparing documents', [
                'old_count' => count($oldDocuments),
                'existing_count' => count($existingDocuments)
            ]);

            foreach ($oldDocuments as $oldDoc) {
                $found = false;
                foreach ($existingDocuments as $existingDoc) {
                    if (
                        isset($oldDoc['file_path']) && isset($existingDoc['file_path'])
                        && $oldDoc['file_path'] === $existingDoc['file_path']
                    ) {
                        $found = true;
                        break;
                    }
                }
                if (!$found && isset($oldDoc['file_path'])) {
                    $documentsToDelete[] = $oldDoc['file_path'];
                    // 🔥 ADDED: Debug logging for each deletion
                    Log::info('Document marked for deletion', [
                        'file_path' => $oldDoc['file_path']
                    ]);
                }
            }

            // Handle new document uploads
            $newDocuments = [];
            if ($request->hasFile('documents')) {
                $documentPath = public_path('assets/documents/cases');
                if (!File::exists($documentPath)) {
                    File::makeDirectory($documentPath, 0755, true);
                }

                foreach ($request->file('documents') as $file) {
                    try {
                        $originalName = $file->getClientOriginalName();
                        $fileExtension = $file->getClientOriginalExtension();
                        $fileSize = $file->getSize();
                        $fileName = time() . '_' . uniqid() . '.' . $fileExtension;

                        $file->move($documentPath, $fileName);

                        $newDocuments[] = [
                            'file_name' => $originalName,
                            'file_path' => 'assets/documents/cases/' . $fileName,
                            'file_type' => $fileExtension,
                            'file_size' => $fileSize,
                            'uploaded_at' => now()->toDateTimeString(),
                        ];

                        Log::info('Document uploaded successfully', [
                            'original_name' => $originalName,
                            'saved_as' => $fileName,
                            'case_id' => $id
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Failed to upload document', [
                            'error' => $e->getMessage(),
                            'case_id' => $id
                        ]);
                        throw $e;
                    }
                }
            }

            // Merge existing and new documents
            $allDocuments = array_merge($existingDocuments, $newDocuments);

            // Update the case
            $case->update([
                'case_number' => $validated['case_number'],
                'case_title' => $validated['case_title'] ?? null,
                'filed_date' => $validated['filed_date'],
                'client_id' => $validated['client_id'],
                'lawyer_id' => $validated['lawyer_id'],
                'instructor_id' => $validated['instructor_id'] ?? null,
                'chapter_id' => $validated['chapter_id'] ?? null,
                'subchapter_id' => $validated['subchapter_id'] ?? null,
                'casecode_id' => $validated['casecode_id'] ?? null,
                'case_status' => $validated['case_status'],
                'day_judge' => $validated['day_judge'] ?? null,
                'day_show' => $validated['day_show'] ?? null,
                'closed_date' => $validated['closed_date'] ?? null,
                'description' => $validated['description'] ?? null,
                'outcome' => $validated['outcome'] ?? null,
                'client_relative' => !empty($clientRelatives) ? $clientRelatives : null,
                'opponents' => !empty($opponentsData) ? $opponentsData : null,
                'case_data' => !empty($caseData) ? $caseData : null,
                'documents' => !empty($allDocuments) ? $allDocuments : null,
                'payment_type' => $validated['payment_type'] ?? null,
                'case_price' => $validated['case_price'] ?? 0,
                'discount' => $validated['discount'] ?? null,
                'payment_amount' => $validated['payment_amount'] ?? 0,
                'payment_status' => $validated['payment_status'] ?? 'unpaid',
            ]);

            // Delete removed documents from filesystem
            foreach ($documentsToDelete as $filePath) {
                $fullPath = public_path($filePath);
                if (File::exists($fullPath)) {
                    File::delete($fullPath);
                    Log::info('Deleted document', [
                        'file_path' => $filePath,
                        'case_id' => $id
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('cases.index')
                ->with('success', 'សំណុំរឿងត្រូវបានកែប្រែដោយជោគជ័យ');
        } catch (\Exception $e) {
            DB::rollBack();

            if (!empty($newDocuments)) {
                foreach ($newDocuments as $doc) {
                    $filePath = public_path($doc['file_path']);
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
                }
            }

            Log::error('Case update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'case_id' => $id
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'មានបញ្ហាក្នុងការកែប្រែសំណុំរឿង: ' . $e->getMessage());
        }
    }
}
