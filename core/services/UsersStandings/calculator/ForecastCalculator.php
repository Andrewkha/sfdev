<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/6/2018
 * Time: 4:15 PM
 */

namespace core\services\UsersStandings\calculator;
use core\entities\sf\Forecast;

/**
 * Class ForecastCalculator
 * @package core\services\UsersStandings\calculator
 *
 * @property ForecastCalculatorInterface $calculator
 */

class ForecastCalculator
{
    private $calculator;

    public function __construct()
    {
        $this->calculator = $this->getCalculator();
    }

    private function getCalculator(): ForecastCalculatorInterface
    {
        return new StandardForecastCalculator();
    }

    public function assignForecastPoints(Forecast &$forecast, $homeScore, $guestScore): void
    {
        $this->calculator->assignForecastPoints($forecast, $homeScore, $guestScore);
    }
}