<?php

namespace Database\Seeders;

use App\Models\CommentsAchievements;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsAchivementsSeeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('comments_achievements')->truncate();
        $achievements = [
            [
                'name'=>'First Comment Written',
                'min_value'=>1,
                'max_value'=>2
            ],
            [
                'name'=>'3 Comments Written',
                'min_value'=>3,
                'max_value'=>4
            ],
            [
                'name'=>'5 Comments Written',
                'min_value'=>5,
                'max_value'=>9
            ],
            [
                'name'=>'10 Comments Written',
                'min_value'=>10,
                'max_value'=>19
            ],
            [
                'name'=>'20 Comments Written',
                'min_value'=>20,
                'max_value'=>1000
            ]
        ];

        CommentsAchievements::insert($achievements);
    }
}
