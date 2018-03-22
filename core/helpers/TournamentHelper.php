<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/22/2018
 * Time: 12:05 PM
 */

namespace core\helpers;

use core\entities\sf\Tournament;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class TournamentHelper
{
    public static function statusList(): array
    {
        return [
            Tournament::STATUS_NOT_STARTED => 'Не начался',
            Tournament::STATUS_IN_PROGRESS => 'Проходит',
            Tournament::STATUS_FINISHED => 'Закончен',
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case Tournament::STATUS_NOT_STARTED:
                $class = 'label label-warning';
                break;
            case Tournament::STATUS_IN_PROGRESS:
                $class = 'label label-success';
                break;
            case Tournament::STATUS_FINISHED:
                $class = 'label label-danger';
                break;
            default:
                $class = 'label label-default';
        }
        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}