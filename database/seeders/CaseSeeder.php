<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUserId = User::where('role', 'admin')->first()->id ?? 1;
        $lawyerUserId = User::where('role', 'criminal')->first()->id ?? 2;
        $clientId = DB::table('clients')->first()->id ?? 1;
        $chapterId = DB::table('chapter_departments')->where('code', 'LEG-SRV')->first()->id ?? 1;
        $subChapterId = DB::table('sub_chapter_departments')->where('chapter_id', $chapterId)->first()->id ?? 1;
        $caseCodeId = DB::table('case_codes')->where('code', 'CC-CRIM-2026')->first()->id ?? 1;

        $case_types = [
            'Criminal', 'Civil', 'Contract', 'Protection', 'Outcourt', 'SOP', 'Business Protection', 'Family Protection', 'Individual Protection'
        ];

        foreach ($case_types as $index => $type) {
            $case_number = 'CASE-2026-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);
            DB::table('cases')->updateOrInsert(['case_number' => $case_number], [
                'case_title' => 'Sample Case for ' . $type,
                'case_type' => $type,
                'description' => 'A demo ' . strtolower($type) . ' case for statistical visualization.',
                'client_id' => $clientId,
                'lawyer_id' => $lawyerUserId,
                'instructor_id' => $adminUserId,
                'chapter_id' => $chapterId,
                'subchapter_id' => $subChapterId,
                'casecode_id' => $caseCodeId,
                'filed_date' => now()->subDays(rand(1, 30))->toDateString(),
                'payment_type' => 'Cash',
                'case_price' => 5000.00,
                'payment_amount' => 5000.00,
                'payment_status' => 'paid',
                'case_status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
