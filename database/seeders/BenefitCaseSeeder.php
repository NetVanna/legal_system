<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class BenefitCaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cases = DB::table('cases')->get();
        if ($cases->isEmpty()) {
            $this->command->warn('No cases found. Seed CaseSeeder first.');
            return;
        }

        // Module keys mapping for dashboard distribution
        $module_types = [
            'អាជីវកម្មឯកជន', 'រដ្ឋប្បវេណី', 'កិច្ចសន្យា', 'ព្រហ្មទណ្ឌ', 'Protection Family', 'Personal Protection', 'Outcourt', 'Protection', 'ស្ដង់ដារអាជីវកម្ម'
        ];

        foreach ($cases as $index => $case) {
            $serviceFee = rand(1000, 5000);
            $lawyerFee = $serviceFee * 0.4;
            $employeeFee = $serviceFee * 0.1;
            $adminFee = $serviceFee * 0.1;
            $chapterFee = $serviceFee * 0.1;
            $itFee = $serviceFee * 0.05;
            $netFee = $serviceFee - ($lawyerFee + $employeeFee + $adminFee + $chapterFee + $itFee);

            // Use the Khmer or structured names expected by your dashboard (based on my previous controller patching)
            $type_case = $module_types[$index % count($module_types)];

            DB::table('benefit_cases')->insert([
                'case_id' => $case->id,
                'client_name' => DB::table('clients')->where('id', $case->client_id)->value('name') ?? 'Client Name',
                'type_case' => $type_case,
                'date' => $case->filed_date,
                'chapter' => 'HQ Chapter',
                'sub_chapter' => 'Legal Div',
                'service_fee' => $serviceFee,
                'employee' => User::where('id', $case->instructor_id)->value('name') ?? 'Employee Name',
                'employee_fee' => $employeeFee,
                'chapter_fee' => $chapterFee,
                'admin_fee' => $adminFee,
                'it_fee' => $itFee,
                'lawyer' => User::where('id', $case->lawyer_id)->value('name') ?? 'Lawyer Name',
                'lawyer_fee' => $lawyerFee,
                'net_fee' => $netFee,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Add some historical data for the 12-month chart
            for ($m = 1; $m <= 11; $m++) {
                $pastDate = now()->subMonths($m)->toDateString();
                $histFee = rand(500, 2000);
                DB::table('benefit_cases')->insert([
                    'case_id' => $case->id, // Reusing ID for demo
                    'client_name' => 'Historical Client',
                    'type_case' => $type_case,
                    'date' => $pastDate,
                    'service_fee' => $histFee,
                    'employee' => 'System Auto',
                    'employee_fee' => $histFee * 0.2,
                    'chapter_fee' => $histFee * 0.2,
                    'admin_fee' => $histFee * 0.2,
                    'it_fee' => $histFee * 0.1,
                    'lawyer' => 'System Lawyer',
                    'lawyer_fee' => $histFee * 0.3,
                    'net_fee' => 0,
                    'created_at' => now()->subMonths($m),
                    'updated_at' => now()->subMonths($m),
                ]);
            }
        }
    }
}
