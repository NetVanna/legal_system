<?php

namespace Database\Seeders;

use App\Models\Cases;
use App\Models\User;
use App\Models\Clients;
use App\Models\CaseCode;
use App\Models\ChapterDepartments;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CivilCaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $lawyer = User::where('role', 'civil')->first() ?: $admin;
        $client = Clients::skip(1)->first() ?: Clients::first();
        $chapter = ChapterDepartments::first();
        $caseCode = CaseCode::where('code', 'CC-CIVIL-2026')->first();

        foreach (range(1, 10) as $i) {
            $caseId = DB::table('cases')->insertGetId([
                'case_number' => 'CIVIL-2026-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'case_title' => 'Civil Litigation Case ' . $i,
                'case_type' => 'រឿងក្ដីរដ្ឋប្បវេណី',
                'description' => 'A sample civil law dispute for demo purposes.',
                'client_id' => $client->id,
                'lawyer_id' => $lawyer->id,
                'instructor_id' => $admin->id,
                'chapter_id' => $chapter->id,
                'casecode_id' => $caseCode->id ?? null,
                'filed_date' => now()->subMonths(10-$i)->subDays(rand(1, 15)),
                'payment_status' => 'paid',
                'payment_type' => 'cash',
                'case_price' => 3500,
                'payment_amount' => 3500,
                'case_status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('benefit_cases')->insert([
                'case_id' => $caseId,
                'client_name' => $client->name,
                'type_case' => 'រដ្ឋប្បវេណី',
                'date' => now()->subMonths(10-$i),
                'chapter' => $chapter->name,
                'service_fee' => 3500,
                'employee' => $admin->name,
                'employee_fee' => 350,
                'chapter_fee' => 350,
                'admin_fee' => 350,
                'it_fee' => 150,
                'lawyer' => $lawyer->name,
                'lawyer_fee' => 1200,
                'net_fee' => 1100,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
