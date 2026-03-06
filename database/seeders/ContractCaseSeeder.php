<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Clients;

class ContractCaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        $client = Clients::skip(3)->first() ?: Clients::first();
        foreach (range(1, 15) as $i) {
            $id = DB::table('cases')->insertGetId([
                'case_number' => 'CONT-2026-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'case_title' => 'Legal Contract ' . $i,
                'case_type' => 'កិច្ចសន្យា',
                'description' => 'Drafting and sealing contract.',
                'client_id' => $client->id,
                'lawyer_id' => $admin->id,
                'filed_date' => now()->subMonths(15-$i),
                'case_price' => 2000,
                'payment_amount' => 2000,
                'payment_status' => 'paid',
                'case_status' => 'closed',
                'created_at' => now(),
            ]);
            DB::table('benefit_cases')->insert([
                'case_id' => $id,
                'client_name' => $client->name,
                'type_case' => 'កិច្ចសន្យា',
                'date' => now()->subMonths(15-$i),
                'service_fee' => 2000,
                'employee' => $admin->name,
                'lawyer' => $admin->name,
                'created_at' => now(),
            ]);
        }
    }
}
