<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/6/2018
 * Time: 11:17 AM
 */

namespace core\services\TeamStandings;

/**
 * Class GameItem
 * @package core\services\TeamStandings
 *
 * @property integer $tour
 * @property integer $date
 * @property string $details
 * @property string $outcome
 */

class GameItem
{
    const RESULT_WIN = 'win';
    const RESULT_LOST = 'lost';
    const RESULT_DRAW = 'draw';

    public $tour;
    public $date;
    public $outcome;
    public $details;

    public function __construct($tour, $date, $outcome, $homeTeam, $guestTeam, $homeScore, $guestScore)
    {
        $this->tour = $tour;
        $this->date = $date;
        $this->outcome = $outcome;
        $this->details = $this->getDetails($homeTeam, $guestTeam, $homeScore, $guestScore);
    }

    private function getDetails($homeTeam, $guestTeam, $homeScore, $guestScore): string
    {
        $string = $homeTeam . ' ' . $homeScore . ' : ' . $guestScore . ' ' . $guestTeam;

        return $string;
    }
}