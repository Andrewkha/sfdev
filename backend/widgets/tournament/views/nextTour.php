<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/11/2018
 * Time: 11:33 AM
 */

use core\entities\sf\Tournament;
use yii\helpers\Html;use yii\web\View;

/**@var $tour integer */
/**@var $this View */
/** @var $tournament Tournament */
?>
<div class="row">
    <div class="col-xs-6">
        <?= Html::a('Отправить напоминания на ' . $tour . ' тур', ['remind', 'tour' => $tour, 'slug' => $tournament->slug], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Отправвить напоминания?',
                'method' => 'post',
            ],
        ]);?>
    </div>
</div>
