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

use yii\helpers\Html;

class GameItem
{
    const RESULT_WIN = 'win';
    const RESULT_LOST = 'lost';
    const RESULT_DRAW = 'draw';

    public $tour;
    public $date;
    public $outcome;
    public $details;

    public function __construct($tour, $date, $outcome, $homeTeam, $guestTeam, bool $ownerTeamHome, $homeScore, $guestScore)
    {
        $this->tour = $tour;
        $this->date = $date;
        $this->outcome = $outcome;
        $this->details = $this->getDetails($homeTeam, $guestTeam, $ownerTeamHome, $homeScore, $guestScore);
    }

    private function getDetails($homeTeam, $guestTeam, $ownerTeamHome, $homeScore, $guestScore): string
    {
        if ($ownerTeamHome) {
            $home = Html::tag('b', $homeTeam);
            $guest = $guestTeam;
        } else {
            $home = $homeTeam;
            $guest = Html::tag('b', $guestTeam);
        }

        $string = $home . ' ' . $homeScore . ': ' . $guestScore . ' ' . $guest;

        return $string;
    }
}