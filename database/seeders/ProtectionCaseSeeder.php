<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Clients;

class ProtectionCaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $client = Clients::skip(2)->first() ?: Clients::first();

        foreach (range(1, 8) as $i) {
            $id = DB::table('cases')->insertGetId([
                'case_number' => 'PROT-2026-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'case_title' => 'Protection Case Demo ' . $i,
                'case_type' => 'រឿងក្ដីរក្សាការពារ',
                'description' => 'Defendant case protecting rights and property.',
                'client_id' => $client->id,
                'lawyer_id' => $admin->id,
                'filed_date' => now()->subMonths(rand(1,6)),
                'case_price' => 1200.00,
                'payment_amount' => 1200.00,
                'payment_status' => 'paid',
                'case_status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('benefit_cases')->insert([
                'case_id' => $id,
                'client_name' => $client->name,
                'type_case' => 'Protection',
                'date' => now()->subMonths(rand(1,6)),
                'service_fee' => 1200,
                'employee' => $admin->name,
                'lawyer' => $admin->name,
                'created_at' => now(),
            ]);
        }
    }
}
