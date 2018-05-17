<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 5/7/2018
 * Time: 3:06 PM
 */

use core\forms\sf\GameForm;
use yii\helpers\Html;

/** @var $model GameForm */

?>

<div class="row">
    <div class="text-right col-xs-4">
        <?= $model->homeTeam; ?>
    </div>
    <div class="text-center col-xs-4">
        <?= Html::input('number', 'GameForm[' . $model->id . '][homeTeamScore]', $model->homeTeamScore, ['class' => 'score']) .
            Html::input('number', 'GameForm[' . $model->id . '][guestTeamScore]', $model->guestTeamScore, ['class' => 'score']) ;?>
    </div>
    <div class="text-left col-xs-4">
        <?= $model->guestTeam; ?>
    </div>
</div>
