<?php

/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/6/2018
 * Time: 12:58 PM
 */

/** @var $this View */
/** @var $model LoginForm */


use core\forms\auth\LoginForm;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Войти в систему';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-xs-12 col-xs-offset-0 col-sm-offset-1 col-sm-10 auth-login">

    <h1 class = 'text-center'><?= Html::encode($this->title) ?></h1>

    <p>Введите логин и пароль/<?= Html::a('Восстановление забытого пароля', ['reset/request']);?></p>

    <div class = "row">
        <div class="col-xs-8 col-sm-6 col-md-4 col-lg-3">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
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

                <?= $form->field($model, 'rememberMe', [
                    ])->checkbox(); ?>

                <div class="form-group">
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

