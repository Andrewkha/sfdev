<?php

use core\entities\sf\Team;
use core\forms\sf\TeamForm;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model TeamForm */
/* @var $team Team */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="team-form">

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

                    <?= $form->field($model, 'logo', [
                        'options' => [
                            'class' => 'form-group'
                        ]
                    ])->widget(FileInput::class, [
                        'options' => ['accept' => 'image/*'],
                        'pluginOptions' => [
                            'initialPreview' =>
                                (isset($team)) ? [$team->getThumbFileUrl('logo', 'updatePreview')] : null,
                            'initialPreviewConfig' =>
                                (isset($team)) ? [
                                    [
                                        'width' => '1000px',
                                        'caption' => $team->name,
                                    ]
                                ] : null,
                            'initialPreviewAsData'=>true,
                            'showRemove' => false,
                            'showUpload' => false,
                            'msgPlaceholder' => $model->getAttributeLabel('logo')
                        ]
                    ])->label(false); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>