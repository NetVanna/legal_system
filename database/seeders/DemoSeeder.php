<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUserId = User::where('role', 'admin')->first()->id ?? 1;
        $lawyerUserId = User::where('role', 'criminal')->first()->id ?? 2;

        // 1. Seed Chapter Departments
        $chapterId = DB::table('chapter_departments')->insertGetId([
            'name' => 'Main Headquarter',
            'code' => 'HQ-001',
            'description' => 'Main legal branch department.',
            'head_user_id' => $adminUserId,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Seed Sub Chapter Departments
        $subChapterId = DB::table('sub_chapter_departments')->insertGetId([
            'chapter_id' => $chapterId,
            'name' => 'Criminal Law Division',
            'code' => 'CRIM-001',
            'description' => 'Handles all criminal cases in HQ.',
            'head_user_id' => $lawyerUserId,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Seed Case Codes
        $caseCodeId = DB::table('case_codes')->insertGetId([
            'code' => 'CC-CRIM-2026',
            'description' => 'Criminal Case Code 2026',
            'date' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Seed Clients
        $clientId = DB::table('clients')->insertGetId([
            'client_code' => 'CLI-0001',
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone' => '1234567890',
            'address' => '123 Main St, City, Country',
            'gender' => 'male',
            'birth_date' => '1985-06-15',
            'id_card_num' => 'N-123456789',
            'client_type' => 'individual',
            'instructor_id' => $lawyerUserId,
            'notes' => 'First demo client.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 5. Seed Cases
        DB::table('cases')->insert([
            'case_number' => 'CASE-2026-001',
            'case_title' => 'John Doe vs State',
            'case_type' => 'Criminal',
            'description' => 'A standard demo criminal case.',
            'client_id' => $clientId,
            'lawyer_id' => $lawyerUserId,
            'instructor_id' => $adminUserId,
            'chapter_id' => $chapterId,
            'subchapter_id' => $subChapterId,
            'casecode_id' => $caseCodeId,
            'filed_date' => now()->subDays(10)->toDateString(),
            'payment_type' => 'Cash',
            'case_price' => 5000.00,
            'payment_amount' => 1000.00,
            'payment_status' => 'partial',
            'case_status' => 'open',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Add another demo case
        DB::table('cases')->insert([
            'case_number' => 'CASE-2026-002',
            'case_title' => 'John Doe Business Issue',
            'case_type' => 'Business Protection',
            'description' => 'Second demo business protection case.',
            'client_id' => $clientId,
            'lawyer_id' => $adminUserId,
            'instructor_id' => $adminUserId,
            'chapter_id' => $chapterId,
            'subchapter_id' => $subChapterId,
            'casecode_id' => $caseCodeId,
            'filed_date' => now()->subDays(2)->toDateString(),
            'payment_type' => 'Bank Transfer',
            'case_price' => 12000.00,
            'payment_amount' => 12000.00,
            'payment_status' => 'paid',
            'case_status' => 'closed',
            'outcome' => 'Won',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
