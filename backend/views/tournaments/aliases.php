<?php

use core\entities\sf\Tournament;
use core\forms\sf\TournamentAliasesForm;
use yii\web\View;
use kartik\form\ActiveForm;
use yii\helpers\Html;
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/2/2018
 * Time: 2:42 PM
 */

/**
 * @var $this View
 * @var $tournament Tournament
 * @var $forms TournamentAliasesForm
 */

$this->title = 'Псевдонимы автопроцессинга';
$this->params['breadcrumbs'][] = ['label' => 'Турниры', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $tournament->name, 'url' => ['view', 'slug' => $tournament->slug]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tournament-aliases">
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6 col-lg-5">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Псевдонимы</strong></div>
                <div class="panel-body">
                    <?php foreach ($forms->aliasForms as $item) :?>
                        <?= $form->field($item, 'alias')->textInput([
                            'placeholder' => 'Псевдоним команды ' . $item->name
                        ])->label(false);?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>