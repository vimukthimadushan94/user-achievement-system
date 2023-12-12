<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(User $user)
    {
        return response()->json([
            'unlocked_achievements' => $this->userRepository->getUnlockedAchievements($user),
            'next_available_achievements' => $this->userRepository->getNextAvailableAchievements($user),
            'current_badge' => $this->userRepository->getCurrentBadge($user),
            'next_badge' => '',
            'remaing_to_unlock_next_badge' => 0
        ]);
    }
}
