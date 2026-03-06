<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database in the correct order.
     */
    public function run(): void
    {
        // 1. Initial Master Data
        $this->call([
            PositionSeeder::class,
            ChapterDepartmentSeeder::class,
            SubChapterDepartmentSeeder::class,
        ]);

        // 2. Core Users and Roles
        $this->call([
            UserSeeder::class,
        ]);

        // 3. Application Data - Categorized Cases
        $this->call([
            ClientSeeder::class,
            CaseCodeSeeder::class,
            CriminalCaseSeeder::class,
            CivilCaseSeeder::class,
            ProtectionCaseSeeder::class,
            OutcourtCaseSeeder::class,
            ContractCaseSeeder::class,
            SOPCaseSeeder::class,
            BusinessProtectionCaseSeeder::class,
            FamilyProtectionCaseSeeder::class,
            PersonalProtectionCaseSeeder::class,
            OtherCaseSeeder::class,
        ]);
    }
}
