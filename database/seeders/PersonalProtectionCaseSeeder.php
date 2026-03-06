<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Clients;

class PersonalProtectionCaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        $client = Clients::first();
        for ($i = 1; $i <= 10; $i++) {
            $id = DB::table('cases')->insertGetId([
                'case_number' => 'PERS-2026-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'case_title' => 'Demo Case for គាំពារបុគ្គល',
                'case_type' => 'គាំពារបុគ្គល',
                'client_id' => $client->id,
                'lawyer_id' => $admin->id,
                'instructor_id' => $admin->id,
                'filed_date' => now()->subMonths(10-$i),
                'case_price' => 1000,
                'payment_amount' => 1000,
                'payment_status' => 'paid',
                'case_status' => 'open',
                'created_at' => now(),
            ]);
            DB::table('benefit_cases')->insert([
                'case_id' => $id,
                'client_name' => $client->name,
                'type_case' => 'Personal Protection',
                'date' => now()->subMonths(10-$i),
                'service_fee' => 1000,
                'employee' => $admin->name,
                'lawyer' => $admin->name,
                'created_at' => now(),
            ]);
        }
    }
}
