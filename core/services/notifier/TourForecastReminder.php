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
use core\services\UsersStandings\ForecastStandings;

class TourForecastReminder implements NotificationInterface
{
    private $tournament;
    private $tour;
    private $threshold;
    private $user;
    private $forecastTour;


    public function __construct(Tournament $tournament, User $user, ForecastStandings $forecastStandings, $tour, $threshold)
    {
        $this->tournament = $tournament;
        $this->user = $user;
        $this->tour = $tour;
        $this->threshold = $threshold;
        $this->forecastTour = $forecastStandings->getForecastTourForUser($user, $tour);
    }

    public function getToUser(): User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        if ($this->forecastTour->isTourForecastEmpty()) {
            return 'Напоминание: сделайте прогноз на ' . $this->tour . ' тур ' . $this->tournament->name;
        } else {
            return 'Внимание: прогноз на ' . $this->tour . ' тур ' . $this->tournament->name . ' неполный';
        }

    }

    public function getContent(): array
    {
        return ['tournament' => $this->tournament, 'tour' => $this->tour, 'games' => $this->forecastTour, 'user' => $this->user];
    }

    public function getTemplate()
    {
        return 'notifications/forecastReminder';
    }

    public function isAllowSendNotification(): bool
    {
        $user = $this->user;

        $subscribed = $this->user->isSubsrcibedForTournamentNews($this->tournament);
        $complete = $this->forecastTour->isTourForecastComplete();
        $count = $this->tournament->getForecastReminders()->where(['tour' => $this->tour])->andWhere(['user_id' => $user->id])->count();

        return ($count < $this->threshold) && !$complete && $subscribed;
    }

    public function getLoggerCategory()
    {
        return 'NotificationForecastReminder';
    }

    public function getErrorMessage()
    {
        $user = $this->user->username;
        return 'Error sending forecast reminder. Tournament ' . $this->tournament->name . ', tour ' . $this->tour . ', user ' . $user;
    }

    public function getSuccessMessage()
    {
        $username = $this->user->username;
        return 'Forecast reminder Tournament ' . $this->tournament->name . ', tour ' . $this->tour . ', user ' . $username . ' successfully sent';
    }

    public function afterAction()
    {
        $this->tournament->addForecastReminder($this->tour, $this->user->id, time());
    }
}