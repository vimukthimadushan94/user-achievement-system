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
            'next_badge' => $this->userRepository->getNextBadge($user)->name,
            'remaing_to_unlock_next_badge' => $this->userRepository->getRemainingToNextBadge($user)
        ]);
    }
}
