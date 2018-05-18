<?php

use core\entities\sf\Tournament;
use core\forms\sf\TournamentForm;
use core\helpers\CountryHelper;
use core\helpers\TournamentHelper;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model TournamentForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tournament-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6 col-lg-5">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Параметры</strong></div>
                <div class="panel-body">
                    <?= $form->field($model, 'name')->textInput([
                        'maxlength' => true,
                        'autofocus' => true,
                        'placeholder' => $model->getAttributeLabel('name')
                    ])->label(false) ?>

                    <?= $form->field($model, 'slug')->textInput([
                        'maxlength' => true,
                        'placeholder' => $model->getAttributeLabel('slug')
                    ])->label(false) ?>

                    <?= $form->field($model, 'type')->widget(SwitchInput::class, [
                        'options' => [
                            'uncheck' => Tournament::TYPE_PLAY_OFF,
                            'value' => Tournament::TYPE_REGULAR,
                        ],
                        'pluginOptions' => [
                            'onText' => TournamentHelper::typeName(Tournament::TYPE_REGULAR),
                            'offText' => TournamentHelper::typeName(Tournament::TYPE_PLAY_OFF),
                        ]
                    ]) ;?>

                    <?= $form->field($model, 'country_id')->widget(Select2::class, [
                        'data' => CountryHelper::countryList(),
                        'options' => ['placeholder' => $model->getAttributeLabel('country_id')],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ]
                    ]) ;?>

                    <?= $form->field($model, 'tours')->textInput(['maxlength' => 2, 'style' => 'width:3em']) ;?>

                    <?= $form->field($model, 'startDate')->widget(DatePicker::class,
                        [
                            'removeButton' => false,
                            'options' => [
                                'value' => isset($model->startDate) ? Yii::$app->formatter->asDate($model->startDate) : null,
                            ],
                            'pluginOptions' => [
                                'todayHighlight' => true,
                                'autoclose' => true,
                            ]
                        ]
                    );?>

                    <?= $form->field($model, 'winnersForecastDue')->widget(DatePicker::class,
                        [
                            'options' => [
                                'value' => isset($model->winnersForecastDue) ? Yii::$app->formatter->asDate($model->winnersForecastDue) : null,
                            ],
                            'removeButton' => false,
                            'pluginOptions' => [
                                'todayHighlight' => true,
                                'autoclose' => true,
                            ]
                        ]
                    );?>

                    <?= $form->field($model, 'autoprocess')->widget(SwitchInput::class, [
                        'pluginOptions' => [
                            'onText' => 'Вкл',
                            'offText' => 'Выкл',
                        ]
                    ]) ;?>

                    <?= $form->field($model, 'autoprocessUrl')->textInput() ;?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>