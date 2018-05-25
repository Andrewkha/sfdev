<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/9/2018
 * Time: 12:48 PM
 */

namespace core\services\UsersStandings;


class ForecastGameItem
{
    public $homeTeam;
    public $guestTeam;
    public $homeTeamScore;
    public $guestTeamScore;
    public $homeForecastScore;
    public $guestForecastScore;
    public $date;
    public $tour;
    public $points;

    public function __construct(string $homeTeam, string $guestTeam, $tour, $date, $homeScore, $guestScore, $homeFScore, $guestFScore, $points)
    {
        $this->homeTeam = $homeTeam;
        $this->guestTeam = $guestTeam;
        $this->tour = $tour;
        $this->date = $date;
        $this->homeTeamScore = $homeScore;
        $this->guestTeamScore = $guestScore;
        $this->homeForecastScore = $homeFScore;
        $this->guestForecastScore = $guestFScore;
        $this->points = $points;
    }

    public function isForecastSet(): bool
    {
        return ($this->homeForecastScore !== NULL && $this->guestForecastScore !== NULL);
    }

    public function getForecast(): string
    {
        if ($this->isForecastSet()) {
            return $this->homeForecastScore . ' : ' . $this->guestForecastScore;
        } else {
            return '- : -';
        }
    }

    public function getParticipants(): string
    {
        return $this->homeTeam . ' - ' . $this->guestTeam;
    }
}