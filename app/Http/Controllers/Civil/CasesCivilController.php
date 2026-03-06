<?php

namespace App\Http\Controllers\Civil;

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

class CasesCivilController extends Controller
{
    public function index()
    {
        $cases = Cases::with(['client', 'lawyer', 'instructor'])
            ->where('case_type', 'រឿងក្ដីរដ្ឋប្បវេណី')
            ->orderBy('created_at', 'desc')
            ->get();
        return view("pages.civil.cases.civil.index", compact("cases"));
    }
    public function create()
    {
        $clients = Clients::all();
        $lawyers = User::all();
        $instructors = User::all();
        $chapters = ChapterDepartments::all();
        $subchapters = SubChapterDepartments::all();
        $casecodes = CaseCode::all();

        return view("pages.civil.cases.civil.create", compact(
            'clients',
            'lawyers',
            'instructors',
            'chapters',
            'subchapters',
            'casecodes'
        ));
    }
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'case_number' => 'required|string|max:255|unique:cases,case_number',
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

            // Payment fields
            'payment_type' => 'nullable|in:cash,bank_transfer,check',
            'case_price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|string|max:50',
            'payment_amount' => 'nullable|numeric|min:0',
            'payment_status' => 'nullable|in:unpaid,partial,paid',

            // Client relatives
            'client_relative.*.name' => 'nullable|string|max:255',
            'client_relative.*.relationship' => 'nullable|string|max:255',
            'client_relative.*.phone' => 'nullable|string|max:20',

            // Opponents
            'opponents.*.name' => 'nullable|string|max:255',
            'opponents.*.phone' => 'nullable|string|max:20',
            'opponents.*.email' => 'nullable|email|max:255',
            'opponents.*.address' => 'nullable|string|max:500',

            // Documents
            'documents' => 'nullable|array',
            'documents.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif|max:10240'
        ]);

        try {
            DB::beginTransaction();

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

            // Handle document uploads - Store in public path
            $documentsData = [];
            if ($request->hasFile('documents')) {
                // Create directory if it doesn't exist
                $documentPath = public_path('assets/documents/cases/civil');
                if (!File::exists($documentPath)) {
                    File::makeDirectory($documentPath, 0755, true);
                }

                foreach ($request->file('documents') as $file) {
                    try {
                        // GET FILE INFO BEFORE MOVING - THIS IS THE FIX
                        $originalName = $file->getClientOriginalName();
                        $fileExtension = $file->getClientOriginalExtension();
                        $fileSize = $file->getSize(); // Get size BEFORE move

                        // Generate unique filename
                        $fileName = time() . '_' . uniqid() . '.' . $fileExtension;

                        // Move file to public directory
                        $file->move($documentPath, $fileName);

                        // Store document info (using variables we saved earlier)
                        $documentsData[] = [
                            'file_name' => $originalName,
                            'file_path' => 'assets/documents/cases/civil/' . $fileName,
                            'file_type' => $fileExtension,
                            'file_size' => $fileSize, // Use the size we saved before moving
                            'uploaded_at' => now()->toDateTimeString(),
                        ];

                        Log::info('Document uploaded successfully', [
                            'original_name' => $originalName,
                            'saved_as' => $fileName
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Failed to upload document', [
                            'error' => $e->getMessage()
                        ]);
                        throw $e;
                    }
                }
            }

            // Create the case
            $case = Cases::create([
                'case_number' => $validated['case_number'],
                'case_type' => 'រឿងក្ដីរដ្ឋប្បវេណី',
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

                // JSON fields
                'client_relative' => !empty($clientRelatives) ? $clientRelatives : null,
                'opponents' => !empty($opponentsData) ? $opponentsData : null,
                'case_data' => !empty($caseData) ? $caseData : null,
                'documents' => !empty($documentsData) ? $documentsData : null,

                // Payment fields
                'payment_type' => $validated['payment_type'] ?? null,
                'case_price' => $validated['case_price'] ?? 0,
                'discount' => $validated['discount'] ?? null,
                'payment_amount' => $validated['payment_amount'] ?? 0,
                'payment_status' => $validated['payment_status'] ?? 'unpaid',
            ]);

            DB::commit();

            return redirect()->route('civil-cases.civil')
                ->with('success', 'សំណុំរឿងត្រូវបានបង្កើតដោយជោគជ័យ');
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete uploaded files if transaction fails
            if (!empty($documentsData)) {
                foreach ($documentsData as $doc) {
                    $filePath = public_path($doc['file_path']);
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
                }
            }

            Log::error('Case creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'មានបញ្ហាក្នុងការបង្កើតសំណុំរឿង: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $cases = Cases::findOrFail($id);

        $clients = Clients::all();
        $lawyers = User::all();
        $instructors = User::all();
        $chapters = ChapterDepartments::all();
        $subchapters = SubChapterDepartments::all();
        $casecodes = CaseCode::all();

        return view('pages.civil.cases.civil.edit', compact(
            'cases',
            'clients',
            'lawyers',
            'instructors',
            'chapters',
            'subchapters',
            'casecodes'
        ));
    }
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
                $documentPath = public_path('assets/documents/cases/civil');
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
                            'file_path' => 'assets/documents/cases/civil/' . $fileName,
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

            return redirect()->route('civil-cases.civil')
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
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            // Find case
            $case = Cases::findOrFail($id);

            // Delete uploaded documents if exist
            if (!empty($case->documents)) {
                foreach ($case->documents as $doc) {
                    $filePath = public_path($doc['file_path']);
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
                }
            }

            // Delete case record
            $case->delete();

            DB::commit();

            flash()->success('Case deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            flash()->error('Failed to delete case!');
            return redirect()->back();
        }
    }
}
