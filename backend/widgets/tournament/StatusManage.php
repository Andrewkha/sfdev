<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/30/2018
 * Time: 12:19 PM
 */

namespace backend\widgets\tournament;

use yii\helpers\Html;
use core\entities\sf\Tournament;
use yii\base\Widget;

/**
 * Class StateManage
 * @package backend\widgets\tournament
 * @property Tournament $tournament
 */

class StatusManage extends Widget
{
    public $tournament;

    public function run(): string
    {
        $this->tournament->isInProgress() ? $progressClass = ' disabled' : $progressClass = '';
        $this->tournament->isFinished() ? $finishedClass = ' disabled' : $finishedClass = '';

        $buttons = Html::a('Начать', ['start', 'slug' => $this->tournament->slug], ['class' => 'btn btn-success' . $progressClass . $finishedClass, 'data' => ['method' => 'post']]) .
                    Html::a('Завершить', ['finish', 'slug' => $this->tournament->slug], ['class' => 'btn btn-danger col-xs-offset-1' . $finishedClass, 'data' => ['method' => 'post']]);

        return $this->render('StatusManage', ['buttons' => $buttons, 'tournament' => $this->tournament]);
    }
}