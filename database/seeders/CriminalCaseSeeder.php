<?php

namespace Database\Seeders;

use App\Models\Cases;
use App\Models\User;
use App\Models\Clients;
use App\Models\CaseCode;
use App\Models\ChapterDepartments;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CriminalCaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $lawyer = User::where('role', 'criminal')->first() ?: $admin;
        $client = Clients::first();
        $chapter = ChapterDepartments::first();
        $caseCode = CaseCode::where('code', 'CC-CRIM-2026')->first();

        foreach (range(1, 12) as $i) {
            $caseId = DB::table('cases')->insertGetId([
                'case_number' => 'CRIM-2026-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'case_title' => 'Criminal Case - Demo ' . $i,
                'case_type' => 'រឿងក្ដីព្រហ្មទណ្ឌ',
                'description' => 'A sample criminal case for demo purposes.',
                'client_id' => $client->id,
                'lawyer_id' => $lawyer->id,
                'instructor_id' => $admin->id,
                'chapter_id' => $chapter->id,
                'casecode_id' => $caseCode->id ?? null,
                'filed_date' => now()->subMonths(12-$i)->subDays(rand(1, 28)),
                'payment_status' => 'paid',
                'payment_type' => 'bank_transfer',
                'case_price' => 2000,
                'payment_amount' => 2000,
                'case_status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('benefit_cases')->insert([
                'case_id' => $caseId,
                'client_name' => $client->name,
                'type_case' => 'ព្រហ្មទណ្ឌ', // Used by analytics trait for chart mapping
                'date' => now()->subMonths(12-$i),
                'chapter' => $chapter->name,
                'service_fee' => 2000,
                'employee' => $admin->name,
                'employee_fee' => 200,
                'chapter_fee' => 200,
                'admin_fee' => 200,
                'it_fee' => 100,
                'lawyer' => $lawyer->name,
                'lawyer_fee' => 800,
                'net_fee' => 500,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
