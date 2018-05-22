<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 5/18/2018
 * Time: 3:44 PM
 */

namespace core\services\notifier;


use core\entities\sf\Tournament;
use core\entities\user\User;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

class TourForecastReminder implements NotificationInterface
{
    private $tournament;
    private $tour;
    private $threshold;

    public function __construct(Tournament $tournament, $tour, $threshold)
    {
        $this->tournament = $tournament;
        $this->tour = $tour;
        $this->threshold = $threshold;
    }

    /**
     * @return User[]
     */

    public function getToUsers()
    {
        return $this->tournament->users;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return 'Напоминание: сделайте прогноз на ' . $this->tour . ' ' . $this->tournament->name;
    }

    public function getContent(User $user): array
    {
        $games = $this->tournament->getGames()->where(['tour' => $this->tour])->with(['forecasts' => function(ActiveQuery $query) use ($user) {
            $query->andWhere(['user_id' => $user->id]);
        }])->all();
        return $games;
    }

    public function getTemplate()
    {
        // TODO: Implement getTemplate() method.
    }

    public function isAllowSendNotification(User $user): bool
    {
        $query = $this->tournament->getForecastReminders()->where(['tour' => $this->tour])->andWhere(['user_id' => $user->id]);
        $row = $query->one();

        if (!$row) {
            return true;
        }

        $count = ArrayHelper::getValue($row, 'reminders');

        return ($count < $this->threshold);
    }

}