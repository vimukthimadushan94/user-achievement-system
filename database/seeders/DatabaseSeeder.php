<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Lesson;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $comments = Comment::factory()->count(20)->create();
        $lessons = Lesson::factory()
            ->count(20)
            ->create();
    }
}
