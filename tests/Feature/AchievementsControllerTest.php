<?php

namespace Tests\Feature;

use App\Models\Badge;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use Database\Seeders\BadgesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AchievementsControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     */
    public function test_index_endpoint_returns_json()
    {
        $user = User::find(rand(1, 10));

        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'unlocked_achievements',
            'next_available_achievements',
            'current_badge',
            'next_badge',
            'remaing_to_unlock_next_badge',
        ]);
    }

    public function test_index_endpoint_handles_invalid_user()
    {
        $response = $this->get('/users/0/achievements');

        $response->assertStatus(404);
    }

}
