<?php

$seeders = [
    'SOPCaseSeeder' => [
        'type' => 'ស្ដង់ដារអាជីវកម្ម',
        'benefit_type' => 'ស្ដង់ដារអាជីវកម្ម',
        'prefix' => 'SOP-2026',
        'price' => 500
    ],
    'BusinessProtectionCaseSeeder' => [
        'type' => 'គាំពារអាជីវកម្ម',
        'benefit_type' => 'អាជីវកម្មឯកជន',
        'prefix' => 'BIZ-2026',
        'price' => 3000
    ],
    'FamilyProtectionCaseSeeder' => [
        'type' => 'គាំពារគ្រួសារ',
        'benefit_type' => 'Protection Family',
        'prefix' => 'FAM-2026',
        'price' => 1500
    ],
    'PersonalProtectionCaseSeeder' => [
        'type' => 'គាំពារបុគ្គល',
        'benefit_type' => 'Personal Protection',
        'prefix' => 'PERS-2026',
        'price' => 1000
    ],
    'OtherCaseSeeder' => [
        'type' => 'ផ្សេងៗ',
        'benefit_type' => 'Other',
        'prefix' => 'OTH-2026',
        'price' => 300
    ]
];

foreach ($seeders as $name => $data) {
    $content = "<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Clients;

class $name extends Seeder
{
    public function run(): void
    {
        \$admin = User::first();
        \$client = Clients::first();
        for (\$i = 1; \$i <= 10; \$i++) {
            \$id = DB::table('cases')->insertGetId([
                'case_number' => '{$data['prefix']}-' . str_pad(\$i, 3, '0', STR_PAD_LEFT),
                'case_title' => 'Demo Case for {$data['type']}',
                'case_type' => '{$data['type']}',
                'client_id' => \$client->id,
                'lawyer_id' => \$admin->id,
                'filed_date' => now()->subMonths(10-\$i),
                'case_price' => {$data['price']},
                'payment_amount' => {$data['price']},
                'payment_status' => 'paid',
                'case_status' => 'open',
                'created_at' => now(),
            ]);
            DB::table('benefit_cases')->insert([
                'case_id' => \$id,
                'client_name' => \$client->name,
                'type_case' => '{$data['benefit_type']}',
                'date' => now()->subMonths(10-\$i),
                'service_fee' => {$data['price']},
                'employee' => \$admin->name,
                'lawyer' => \$admin->name,
                'created_at' => now(),
            ]);
        }
    }
}";
    file_put_contents("database/seeders/$name.php", $content);
}
