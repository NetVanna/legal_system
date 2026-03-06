<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CaseCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $caseCodes = [
            ['code' => 'CC-CRIM-2026', 'description' => 'Criminal Case Master Code 2026'],
            ['code' => 'CC-CIVIL-2026', 'description' => 'Civil Case Master Code 2026'],
            ['code' => 'CC-CONT-2026', 'description' => 'Contract Law Master Code 2026'],
            ['code' => 'CC-FAM-2026', 'description' => 'Family Protection Master Code 2026'],
            ['code' => 'CC-BIZ-2026', 'description' => 'Business Protection Master Code 2026'],
            ['code' => 'CC-INDIV-2026', 'description' => 'Individual Protection Master Code 2026'],
            ['code' => 'CC-SOP-2026', 'description' => 'SOP Compliance Master Code 2026'],
            ['code' => 'CC-OUT-2026', 'description' => 'Outcourt Settlement Master Code 2026'],
        ];

        foreach ($caseCodes as $code) {
            DB::table('case_codes')->updateOrInsert(['code' => $code['code']], array_merge($code, [
                'date' => now()->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
