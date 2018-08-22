<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 8/20/2018
 * Time: 2:54 PM
 */

namespace core\services\notifier;

use core\entities\sf\Tournament;
use core\entities\user\User;
use core\services\UsersStandings\ForecastStandings;

class TourFinishedNotification implements NotificationInterface
{

    private $tournament;
    private $user;
    private $tour;
    private $standings;

    public function __construct(Tournament $tournament, User $user, $tour, ForecastStandings $forecastStandings)
    {
        $this->tournament = $tournament;
        $this->user = $user;
        $this->tour = $tour;
        $this->standings = $forecastStandings;
    }

    public function getToUser(): User
    {
        return $this->user;
    }

    public function getSubject()
    {
        return 'Завершился ' . $this->tour . ' тур турнира ' . $this->tournament->name;

    }

    public function getTemplate()
    {
        return 'notifications/tourFinishedNotification';
    }

    public function isAllowSendNotification(): bool
    {
        return $this->user->isSubsrcibedForTournamentNews($this->tournament);
    }

    public function getContent(): array
    {
        return [
            'tournament' => $this->tournament,
            'tour' => $this->tour,
            'games' => $this->standings->getForecastTourForUser($this->user, $this->tour),
            'user' => $this->user,
            'tourLeaders' => $this->standings->getTourLeaders($this->tour, 5),
            'position' => $this->standings->getPosition($this->user),
            'leader' => $this->standings->getLeader(),
            'numParticipants' => count($this->tournament->users)
        ];
    }

    public function getLoggerCategory()
    {
        return 'TourFinishedNotification';
    }

    public function getErrorMessage()
    {
        $user = $this->user->username;
        return 'Error sending tour finished notification. Tournament ' . $this->tournament->name . ', tour ' . $this->tour . ', user ' . $user;
    }

    public function getSuccessMessage()
    {
        $username = $this->user->username;
        return 'Tour finished. Tournament ' . $this->tournament->name . ', tour ' . $this->tour . ', user ' . $username . ' successfully sent';
    }

    public function afterAction()
    {

    }

}