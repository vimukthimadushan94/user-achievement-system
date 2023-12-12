<?php

namespace App\Repositories;

use App\Models\CommentsAchievements;
use App\Models\LessonAchievement;
use App\Models\User;
use Illuminate\Support\Facades\Log;

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

    /**
     * @param $user
     * @return string
     * get current badge for the specific user
     */
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

    /**
     * @param $user
     * @return mixed
     * get total unlocked achievements
     */
    public function getUnlockedAchievements($user)
    {
        return $user->watched->pluck('title')->merge($user->writtenComments->pluck('body'));
    }

    public function getNextAvailableAchievements($user)
    {
        try {
            $lessonAchievementsCount = $user->watched->count();
            $commentAchievementsCount = $user->writtenComments->count();
            $lessonAchivCategory = $this->getLessonAchievementByCount($lessonAchievementsCount);
            $commentAchivCategory = $this->getCommentAchievementByCount($commentAchievementsCount);

            //this value refers to the next level value range
            $nextLessonValueRange = $lessonAchivCategory->max_value+1;
            $nextCommentValueRange = $commentAchivCategory->max_value+1;

            $nextLessonAchiement = LessonAchievement::where('min_value','<=',$nextLessonValueRange)
                ->where('max_value','>',$nextLessonValueRange)
                ->first();

            $nextCommentAchiement = CommentsAchievements::where('min_value','<=',$nextCommentValueRange)
                ->where('max_value','>',$nextCommentValueRange)
                ->first();

            return [
                $nextLessonAchiement->name,$nextCommentAchiement->name
            ];
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
            return [];
        }

    }

    public function getLessonAchievementByCount($count)
    {
        $achievement = LessonAchievement::where('min_value','<=',$count)->where('max_value','>',$count)->first();
        return $achievement;
    }

    public function getCommentAchievementByCount($count)
    {
        $achievement = CommentsAchievements::where('min_value','<=',$count)->where('max_value','>',$count)->first();
        return $achievement;
    }

}
