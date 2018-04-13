<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/11/2018
 * Time: 2:54 PM
 */

namespace core\services\UsersStandings\WinnersForecastCalculator;

use core\entities\sf\WinnersForecast;
use core\entities\sf\Team;
use core\services\UsersStandings\WinnersForecastResultItem;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class StandardWinnersForecastCalculator
 * @package core\services\UsersStandings\WinnersForecastCalculator
 *
 * @property WinnersForecastResultItem[] $items
 */

class StandardWinnersForecastCalculator implements WinnersForecastCalculatorInterface
{
    const WFE_TEAM_IN_WINNERS = 1;
    const WFE_TEAM_POSITION = 2;
    const WFE_ALL_3_WINNERS = 3;

    const POINTS_TEAM_IN_WINNERS = 10;
    const POINTS_TEAM_POSITION = 20;
    const POINTS_ALL_3_WINNERS = 20;

    public $items = [];

    /**
     * @param WinnersForecast[] $forecastedWinners
     * @param Team[] $winners
     */

    public function __construct($forecastedWinners, $winners)
    {
        $this->assignEvents($forecastedWinners, $winners);
        $this->assignPoints();
    }

    private function assignEvents($forecastedWinners, $winners):void
    {
        $result = [];
        $positionCount = 0;

        foreach ($winners as $position => $winner) {
            $filtered = array_filter($forecastedWinners, function (WinnersForecast $one) use ($winner) {
                return $one->team_id == $winner->id;
            });

            $found = array_shift($filtered);

            if ($found && $found->position == $position + 1 ) {
                $result[] = new WinnersForecastResultItem(self::WFE_TEAM_POSITION, $winner->name);
                $positionCount++;
            } elseif ($found) {
                $result[] = new WinnersForecastResultItem(self::WFE_TEAM_IN_WINNERS, $winner->name);
            }
        }

        if ($positionCount == 3) {
            $result[] = new WinnersForecastResultItem(self::WFE_ALL_3_WINNERS);
        }
        $this->items = $result;
    }

    private function assignPoints(): void
    {
        foreach ($this->items as $k => $item) {
            if ($item->event === self::WFE_TEAM_IN_WINNERS) {
                $this->items[$k]->points = self::POINTS_TEAM_IN_WINNERS;
                $this->items[$k]->text = 'Попадание тройку призеров команды ' . Html::tag('strong', $this->items[$k]->team) . ' - ' . $this->items[$k]->points . ' очков';
            }
            if ($item->event === self::WFE_TEAM_POSITION) {
                $this->items[$k]->points = self::POINTS_TEAM_POSITION;
                $this->items[$k]->text = 'Точно угаданное место команды  ' . Html::tag('strong', $this->items[$k]->team) . ' - ' . $this->items[$k]->points . ' очков';
            }
            if ($item->event === self::WFE_ALL_3_WINNERS) {
                $this->items[$k]->points = self::POINTS_ALL_3_WINNERS;
                $this->items[$k]->text = 'Дополнительные ' . $this->items[$k]->points . ' очков за точно угаданную тройку призеров';
            }
        }
    }

    public function calculate(): array
    {
        return $this->items;
    }

    public function totalPoints(): int
    {
        return array_sum(ArrayHelper::getColumn($this->items, 'points'));
    }
}