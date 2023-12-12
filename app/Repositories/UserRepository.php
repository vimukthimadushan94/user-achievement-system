<?php

namespace App\Repositories;

use App\Models\Badge;
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

    /**
     * @param $user
     * @return string
     * get current badge for the specific user
     */
    public function getCurrentBadge($user)
    {
        $totalAchievements = $user->watched->count()+$user->writtenComments->count();

        $badge = $this->getCurrentUserBadge($user,$totalAchievements);
        return $badge->name;
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

    /**
     * @param $user
     * @return array
     * get the next achievements
     */
    public function getNextAvailableAchievements($user)
    {
        try {
            $lessonAchievementsCount = $user->watched->count();
            $commentAchievementsCount = $user->writtenComments->count();
            $lessonAchivCategory = $this->getLessonAchievementByCount($lessonAchievementsCount);
            $commentAchivCategory = $this->getCommentAchievementByCount($commentAchievementsCount);

            //these value refers to the next level value range.Next levels should be within those values
            $nextLessonValueRange = $lessonAchivCategory->max_value+1;
            $nextCommentValueRange = $commentAchivCategory->max_value+1;

            $nextLessonAchiement = LessonAchievement::where('min_value','<=',$nextLessonValueRange)
                ->where('max_value','>=',$nextLessonValueRange)
                ->first();

            $nextCommentAchiement = CommentsAchievements::where('min_value','<=',$nextCommentValueRange)
                ->where('max_value','>=',$nextCommentValueRange)
                ->first();

            return [
                $nextLessonAchiement->name,
                $nextCommentAchiement->name
            ];
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
            return [];
        }

    }

    public function getLessonAchievementByCount($count)
    {
        return LessonAchievement::where('min_value','<=',$count)->where('max_value','>=',$count)->first();
    }

    public function getCommentAchievementByCount($count)
    {
        return CommentsAchievements::where('min_value','<=',$count)->where('max_value','>=',$count)->first();
    }

    public function getNextBadge($user)
    {
        $totalAchievements = $this->getTotalAchievements($user);

        //get the current badge
        $currentBadge = $this->getCurrentUserBadge($user,$totalAchievements);

        $nextBadgeStartRange = $currentBadge->max_value+1;
        return Badge::where('min_value','<=',$nextBadgeStartRange)->where('max_value','>=',$nextBadgeStartRange)->first();

    }

    public function getCurrentUserBadge($user,$count)
    {
        return Badge::where('min_value','<=',$count)->where('max_value','>=',$count)->first();
    }

    /**
     * @param $user
     * @return mixed
     */
    public function getTotalAchievements($user)
    {
        return $user->watched->count()+$user->writtenComments->count();
    }

    public function getRemainingToNextBadge($user)
    {
        $totalAchievements = $this->getTotalAchievements($user);

        $nextBadge = $this->getNextBadge($user);
        return $nextBadge->min_value - $totalAchievements;
    }

}
