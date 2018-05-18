<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 5/18/2018
 * Time: 12:47 PM
 */

use core\entities\sf\Tournament;
use core\forms\sf\GameForm;
use yii\web\View;
use kartik\form\ActiveForm;
use kartik\widgets\DateTimePicker;
use kartik\select2\Select2;
use yii\helpers\Html;

/* @var $this View */
/* @var $model GameForm */
/* @var $tournament Tournament */

$this->title = 'Добавить игру';
$this->params['breadcrumbs'][] = ['label' => 'Турниры', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $tournament->name, 'url' => ['view', 'slug' => $tournament->slug]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="game-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6 col-lg-5">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Новая игра</strong></div>
                <div class="panel-body">
                    <?= $form->field($model, 'homeTeam')->widget(Select2::class, [
                        'data' => $model->getParticipants($tournament),
                        'options' => ['placeholder' => 'Команда хозяев'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ]
                    ])->label(false) ;?>

                    <?= $form->field($model, 'guestTeam')->widget(Select2::class, [
                        'data' => $model->getParticipants($tournament),
                        'options' => ['placeholder' => 'Команда гостей'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ]
                    ])->label(false) ;?>

                    <?= $form->field($model, 'tour')->textInput(['maxlength' => 2, 'style' => 'width:3em'])->label('Тур') ;?>

                    <?= $form->field($model, 'date')->widget(DateTimePicker::class,
                                [
                                    'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
                                    'pluginOptions' => [
                                        'format' => 'dd.mm.yyyy hh:ii',
                                        'todayHighlight' => true,
                                        'autoclose' => true,
                                    ]
                                ]
                    )->label('Дата');?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
