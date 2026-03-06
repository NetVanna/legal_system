<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure Chapters and Positions are Seeded
        $adminPosition = Position::where('code', 'admin')->first() ?: Position::create(['name' => 'Administrator', 'code' => 'admin', 'status' => 'active']);
        $lawyerPosition = Position::where('code', 'lawyer')->first() ?: Position::create(['name' => 'Lawyer', 'code' => 'lawyer', 'status' => 'active']);
        $staffPosition = Position::where('code', 'staff')->first() ?: Position::create(['name' => 'Staff', 'code' => 'staff', 'status' => 'active']);

        $mainChapter = DB::table('chapter_departments')->where('code', 'GEN-ADM')->first() ?: DB::table('chapter_departments')->insertGetId([
            'name' => 'General Administration', 'code' => 'GEN-ADM', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()
        ]);
        if (is_int($mainChapter)) {
            $mainChapter = DB::table('chapter_departments')->where('id', $mainChapter)->first();
        }

        $roles = [
            'admin' => 'System Administrator',
            'criminal' => 'Criminal Staff Member',
            'civil' => 'Civil Staff Member',
            'protection' => 'General Protection Staff',
            'outcourt' => 'Outcourt Specialist',
            'contract' => 'Legal Contract Specialist',
            'sop' => 'Compliance Staff',
            'protectbusiness' => 'Business Shield Manager',
            'protectfamily' => 'Family Support Staff',
            'protectindividual' => 'Individual Protector',
            'viewer' => 'Demo Access / Auditor',
        ];

        $i = 1;
        foreach ($roles as $role => $name) {
            $employee_id = 'EMP' . str_pad($i, 3, '0', STR_PAD_LEFT);
            $email = $role . '@example.com';
            
            User::updateOrCreate([
                'email' => $email,
            ], [
                'employee_id' => $employee_id,
                'name' => $name,
                'phone' => '01234567' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'), 
                'role' => $role,
                'date_birth' => '1990-01-01',
                'gender' => ($i % 2 == 0) ? 'female' : 'male',
                'position' => str_contains($role, 'admin') ? 'Administrator' : ($role === 'viewer' ? 'Staff' : 'Lawyer'),
                'position_id' => str_contains($role, 'admin') ? $adminPosition->id : ($role === 'viewer' ? $staffPosition->id : $lawyerPosition->id),
                'chapter_id' => $mainChapter->id ?? null,
                'status' => 'active',
            ]);
            
            $i++;
        }

        // Specifically create an admin with a normal name
        User::updateOrCreate([
            'email' => 'admin@admin.com',
        ], [
            'employee_id' => 'ADMIN-001',
            'name' => 'Super Admin',
            'phone' => '0123456789',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'position_id' => $adminPosition->id,
            'chapter_id' => $mainChapter->id ?? null,
            'status' => 'active',
        ]);
    }
}
