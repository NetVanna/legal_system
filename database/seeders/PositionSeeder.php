<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            ['name' => 'Administrator', 'code' => 'admin', 'description' => 'System Administrator with full access.'],
            ['name' => 'Lawyer', 'code' => 'lawyer', 'description' => 'Legal professional handling cases.'],
            ['name' => 'Staff', 'code' => 'staff', 'description' => 'Regular office staff.'],
            ['name' => 'Clerk', 'code' => 'clerk', 'description' => 'Documentation and filing clerk.'],
            ['name' => 'Manager', 'code' => 'manager', 'description' => 'Department manager.'],
            ['name' => 'Junior Lawyer', 'code' => 'jr_lawyer', 'description' => 'Assistant legal professional.'],
            ['name' => 'Senior Lawyer', 'code' => 'sr_lawyer', 'description' => 'Senior legal expert.'],
        ];

        foreach ($positions as $position) {
            Position::firstOrCreate(['code' => $position['code']], $position);
        }
    }
}
