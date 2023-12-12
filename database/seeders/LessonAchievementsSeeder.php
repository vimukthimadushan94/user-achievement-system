<?php

namespace Database\Seeders;

use App\Models\LessonAchievement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LessonAchievementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lesson_achievements')->truncate();
        $achievements = [
            [
                'name'=>'First Lesson Watched',
                'min_value'=>1,
                'max_value'=>4
            ],
            [
                'name'=>'5 Lessons Watched',
                'min_value'=>5,
                'max_value'=>9
            ],
            [
                'name'=>'10 Lessons Watched',
                'min_value'=>10,
                'max_value'=>24
            ],
            [
                'name'=>'25 Lessons Watched',
                'min_value'=>25,
                'max_value'=>49
            ],
            [
                'name'=>'50 Lessons Watched',
                'min_value'=>50,
                'max_value'=>1000
            ]
        ];

        LessonAchievement::insert($achievements);
    }
}
