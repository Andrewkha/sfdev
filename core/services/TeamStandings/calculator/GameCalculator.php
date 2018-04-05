<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/5/2018
 * Time: 2:03 PM
 */

namespace core\services\TeamStandings\calculator;


use core\entities\sf\Game;
use core\entities\sf\Tournament;

/**
 * Class GameCalculator
 * @package core\services\TeamStandings\calculator
 *
 * @property GameCalculatorInterface $calculator
 */

class GameCalculator
{
    private $calculator;

    public function __construct(Tournament $tournament)
    {
        $this->calculator = $this->getCalculator($tournament);
    }

    private function getCalculator(Tournament $tournament): GameCalculatorInterface
    {
        if ($tournament->isRegular()) {
            return new StandardGameCalculator();
        } else {
            return new PlayoffGameCalculator();
        }
    }

    public function assignGamePoints(Game &$game)
    {
        $this->calculator->assignGamePoints($game);
    }

    /**
     * @param Game[] $games
     */
    public function assignGamesPoints(array &$games)
    {
        foreach ($games as $game) {
            $this->assignGamePoints($game);
        }
    }
}