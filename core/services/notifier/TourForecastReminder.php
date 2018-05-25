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
    private $games;

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
        return 'Напоминание: сделайте прогноз на ' . $this->tour . ' тур ' . $this->tournament->name;
    }

    public function getContent(User $user): array
    {
        $games = $this->tournament->getGames()->where(['tour' => $this->tour])->with(['forecasts' => function(ActiveQuery $query) use ($user) {
            $query->andWhere(['user_id' => $user->id]);
        }])->all();

        $data = ['tournament' => $this->tournament, 'tour' => $this->tour, 'games' => $games, 'user' => $user];

        return $data;
    }

    public function getTemplate()
    {
        return 'notifications/forecastReminder';
    }

    public function isAllowSendNotification(User $user): bool
    {
        $complete = $this->tournament->isTourForecastComplete($user, $this->tour);
        $count = $this->tournament->getForecastReminders()->where(['tour' => $this->tour])->andWhere(['user_id' => $user->id])->count();

        return ($count < $this->threshold) && !$complete;
    }

    public function getLoggerCategory()
    {
        return 'NotificationForecastReminder';
    }

    public function getErrorMessage($user)
    {
        return 'Error sending forecast reminder. Tournament ' . $this->tournament->name . ', tour ' . $this->tour . ', user ' . $user;
    }

    public function getSuccessMessage($username)
    {
        return 'Forecast reminder Tournament ' . $this->tournament->name . ', tour ' . $this->tour . ', user ' . $username . ' successfully sent';
    }
}