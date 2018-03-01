<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/28/2018
 * Time: 2:33 PM
 */

/* @var $this \yii\web\View */
/* @var $model \core\forms\auth\SignupForm */

use himiklab\yii2\recaptcha\ReCaptcha;
use kartik\widgets\FileInput;
use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="signup-request">

    <h1 class = 'text-center'><?= Html::encode($this->title) ?></h1>

    <div class = 'row'>
        <div class="alert alert-info col-xs-6 col-xs-offset-3 text-center">
            Добро пожаловать! Введите регистрационные данные
        </div>
    </div>
    <div class="row">
        <div class="col-xs-11 col-sm-7 col-md-5 col-lg-4">
            <?php $form = ActiveForm::begin([
                'id' => 'form-signup',
                'options' => [
                    'enctype' => 'multipart/form-data'
                ]
            ]); ?>
                <?= $form->field($model, 'username', [
                        'feedbackIcon' => [
                             'success' => 'ok',
                            'error' => 'exclamation-sign'
                        ],
                        'options' => [
                            'class' => 'form-group has-feedback',
                        ],
                    ])->textInput([
                        'autofocus' => true,
                        'placeholder' => $model->getAttributeLabel('username')
                    ])->label(false); ?>

                <?= $form->field($model, 'email', [
                        'addon' => ['prepend' => ['content' => '@']],
                        'feedbackIcon' => [
                            'default' => 'envelope',
                            'success' => 'ok',
                            'error' => 'exclamation-sign'
                        ],
                        'options' => [
                            'class' => 'form-group has-feedback',
                        ],
                    ])->textInput([
                        'placeholder' => $model->getAttributeLabel('email')
                    ])->label(false); ?>


                <?= $form->field($model, 'password', [
                    'feedbackIcon' => [
                        'success' => 'ok',
                        'error' => 'exclamation-sign'
                    ],
                        'options' => [
                            'class' => 'form-group has-feedback',
                        ],
                    ])->passwordInput([
                        'placeholder' => $model->getAttributeLabel('password')
                    ])->label(false); ?>

                <?= $form->field($model, 'repeatPassword', [
                        'feedbackIcon' => [
                            'success' => 'ok',
                            'error' => 'exclamation-sign'
                        ],
                        'options' => [
                            'class' => 'form-group has-feedback',
                        ],
                    ])->passwordInput([
                        'placeholder' => $model->getAttributeLabel('repeatPassword')
                    ])->label(false); ?>

                <?= $form->field($model, 'firstName', [
                        'feedbackIcon' => [
                            'success' => 'ok',
                            'error' => 'exclamation-sign'
                        ],
                        'options' => [
                            'class' => 'form-group has-feedback',
                        ],
                    ])->textInput([
                        'placeholder' => $model->getAttributeLabel('firstName')
                    ])->label(false); ?>

                <?= $form->field($model, 'lastName', [
                        'feedbackIcon' => [
                            'success' => 'ok',
                            'error' => 'exclamation-sign'
                        ],
                        'options' => [
                            'class' => 'form-group has-feedback',
                        ],
                    ])->textInput([
                        'placeholder' => $model->getAttributeLabel('lastName')
                    ])->label(false); ?>

                <?= $form->field($model, 'avatar', [
                        'options' => [
                            'class' => 'form-group'
                        ]
                    ])->widget(FileInput::class, [
                        'options' => ['accept' => 'image/*'],
                        'pluginOptions' => [
                            'showRemove' => false,
                            'showUpload' => false,
                            'msgPlaceholder' => $model->getAttributeLabel('avatar')
                        ]
                    ])->label(false); ?>

                <?= $form->field($model, 'notification', [
                    ])->widget(SwitchInput::class, [
                        'pluginOptions' => [
                            'onText' => 'Вкл',
                            'offText' => 'Выкл',
                        ]
                    ]); ?>

                <?= $form->field($model, 'reCaptcha')->widget(ReCaptcha::class)->label(false); ?>

                <div class="form-group">
                    <p>
                        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                    </p>
                </div>

            <?php ActiveForm::end();?>
        </div>
    </div>
</div>
