<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Clients;

class OutcourtCaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        $client = Clients::first();
        foreach (range(1, 6) as $i) {
            $id = DB::table('cases')->insertGetId([
                'case_number' => 'OUT-2026-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'case_title' => 'Out-Of-Court Resolution ' . $i,
                'case_type' => 'ដោះស្រាយក្រៅតុលាការ',
                'description' => 'Mediation and Reconciliation trial.',
                'client_id' => $client->id,
                'lawyer_id' => $admin->id,
                'filed_date' => now()->subMonths(rand(1,6)),
                'case_price' => 1500,
                'payment_amount' => 1500,
                'payment_status' => 'paid',
                'case_status' => 'settled',
                'created_at' => now(),
            ]);
            DB::table('benefit_cases')->insert([
                'case_id' => $id,
                'client_name' => $client->name,
                'type_case' => 'Outcourt',
                'date' => now(),
                'service_fee' => 1500,
                'employee' => $admin->name,
                'lawyer' => $admin->name,
                'created_at' => now(),
            ]);
        }
    }
}
