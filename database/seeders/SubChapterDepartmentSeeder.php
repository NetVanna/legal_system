<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubChapterDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch chapters to link sub-chapters
        $chapters = DB::table('chapter_departments')->get();
        if ($chapters->isEmpty()) {
            $this->command->warn('Chapter departments are missing. Please seed ChapterDepartmentSeeder first.');
            return;
        }

        foreach ($chapters as $chapter) {
            $subs = [
                ['name' => $chapter->name . ' - North Division', 'code' => $chapter->code . '-ND'],
                ['name' => $chapter->name . ' - South Division', 'code' => $chapter->code . '-SD'],
                ['name' => $chapter->name . ' - Central Office', 'code' => $chapter->code . '-CO'],
            ];

            foreach ($subs as $sub) {
                DB::table('sub_chapter_departments')->updateOrInsert(['code' => $sub['code']], [
                    'chapter_id' => $chapter->id,
                    'name' => $sub['name'],
                    'code' => $sub['code'],
                    'description' => 'Regional sub-division for ' . $chapter->name,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
