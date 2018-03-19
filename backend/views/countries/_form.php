<?php

use core\forms\sf\CountryForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model CountryForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="country-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
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
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>