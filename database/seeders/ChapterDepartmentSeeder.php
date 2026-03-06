<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChapterDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chapters = [
            ['name' => 'General Administration', 'code' => 'GEN-ADM', 'description' => 'Main management and administrative tasks.'],
            ['name' => 'Legal Services', 'code' => 'LEG-SRV', 'description' => 'Legal consultation and direct lawyer services.'],
            ['name' => 'Criminal Law Chapter', 'code' => 'CRIM-CH', 'description' => 'Dedicated to criminal litigation.'],
            ['name' => 'Civil Litigation Chapter', 'code' => 'CIVIL-CH', 'description' => 'Dedicated to civil law disputes.'],
            ['name' => 'Contract Law Chapter', 'code' => 'CONT-CH', 'description' => 'Focusing on contract drafting and disputes.'],
            ['name' => 'Family Protection Chapter', 'code' => 'FAM-CH', 'description' => 'Focused on family legal affairs.'],
            ['name' => 'Business Protection Chapter', 'code' => 'BIZ-CH', 'description' => 'Focused on corporate legal support.'],
            ['name' => 'Individual Protection Chapter', 'code' => 'INDIV-CH', 'description' => 'Focused on personal legal rights.'],
            ['name' => 'SOP Chapter', 'code' => 'SOP-CH', 'description' => 'Standard operating procedures and compliance.'],
            ['name' => 'Outcourt Settlements', 'code' => 'OUT-CH', 'description' => 'Mediation and alternative dispute resolutions.'],
        ];

        foreach ($chapters as $chapter) {
            DB::table('chapter_departments')->updateOrInsert(['code' => $chapter['code']], array_merge($chapter, [
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
