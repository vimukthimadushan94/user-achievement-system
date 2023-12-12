<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAllUsers()
    {
        return $this->user->all();
    }

    public function getUserById($id)
    {
        return $this->user->find($id);
    }

    public function getCurrentBadge($user)
    {
        $totalAchievements = $user->watched->count()+$user->writtenComments->count();
        switch (true) {
            case ($totalAchievements >= 10):
                $result = User::MASTER;
                break;
            case ($totalAchievements >= 8):
                $result = User::ADVANCED;
                break;

            case ($totalAchievements >= 4):
                $result = User::INTERMEDIATE;
                break;

            case ($totalAchievements >= 0):
                $result = User::BEGINNER;
                break;

            default:
                $result = User::BEGINNER;
        }

        return $result;
    }

    public function getUnlockedAchievements($user)
    {
        return $user->watched->pluck('title')->merge($user->writtenComments->pluck('body'));
    }
}
