<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lawyerUserId = User::where('role', 'criminal')->first()->id ?? User::first()->id;

        $clients = [
            [
                'client_code' => 'CLI-001',
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'phone' => '0123456789',
                'address' => 'Phnom Penh, Cambodia',
                'gender' => 'male',
                'birth_date' => '1985-06-15',
                'id_card_num' => 'N-123456789',
                'client_type' => 'individual',
                'instructor_id' => $lawyerUserId,
                'notes' => 'Regular client for criminal defense.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'client_code' => 'CLI-002',
                'name' => 'Jane Smith',
                'email' => 'janesmith@example.com',
                'phone' => '0234567891',
                'address' => 'Siem Reap, Cambodia',
                'gender' => 'female',
                'birth_date' => '1990-10-25',
                'id_card_num' => 'N-987654321',
                'client_type' => 'individual',
                'instructor_id' => $lawyerUserId,
                'notes' => 'Client for civil dispute.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'client_code' => 'CLI-003',
                'name' => 'ABC Corporation',
                'email' => 'info@abccorp.com',
                'phone' => '0345678912',
                'address' => 'Business Center, Phnom Penh',
                'gender' => 'male',
                'birth_date' => null,
                'id_card_num' => 'V-ABC12345',
                'client_type' => 'company',
                'instructor_id' => $lawyerUserId,
                'notes' => 'Corporate client for contract law.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'client_code' => 'CLI-004',
                'name' => 'Family Trust',
                'email' => 'trust@example.com',
                'phone' => '0456789123',
                'address' => 'Battambang, Cambodia',
                'gender' => 'female',
                'birth_date' => null,
                'id_card_num' => 'V-TRST99',
                'client_type' => 'company',
                'instructor_id' => $lawyerUserId,
                'notes' => 'Estate management client.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($clients as $client) {
            DB::table('clients')->updateOrInsert(['client_code' => $client['client_code']], $client);
        }
    }
}
