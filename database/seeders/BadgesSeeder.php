<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BadgesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('badges')->truncate();
        $achievements = [
            [
                'name'=>'Beginner',
                'min_value'=>0,
                'max_value'=>3
            ],
            [
                'name'=>'Intermediate',
                'min_value'=>4,
                'max_value'=>7
            ],
            [
                'name'=>'Advanced',
                'min_value'=>8,
                'max_value'=>9
            ],
            [
                'name'=>'Master',
                'min_value'=>10,
                'max_value'=>1000
            ]
        ];

        Badge::insert($achievements);
    }
}
