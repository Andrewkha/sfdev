<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/28/2018
 * Time: 2:33 PM
 */

/* @var $this \yii\web\View */
/* @var $model \core\forms\auth\PasswordResetForm */

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

$this->title = 'Создание нового пароля';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="reset-reset">

    <h1 class = 'text-center'><?= Html::encode($this->title) ?></h1>

    <div class = 'row'>
        <div class="alert alert-info col-xs-6 col-xs-offset-3 text-center">
            Введите новый пароль
        </div>
    </div>
    <div class="row">
        <div class="col-xs-11 col-sm-7 col-md-5 col-lg-4">
            <?php $form = ActiveForm::begin([
                'id' => 'form-reset',
            ]); ?>

            <?= $form->field($model, 'password', [
                'feedbackIcon' => [
                    'success' => 'ok',
                    'error' => 'exclamation-sign'
                ],
                'options' => [
                    'class' => 'form-group has-feedback',
                ],
            ])->passwordInput()->label('Новый пароль'); ?>

            <?= $form->field($model, 'repeatPassword', [
                'feedbackIcon' => [
                    'success' => 'ok',
                    'error' => 'exclamation-sign'
                ],
                'options' => [
                    'class' => 'form-group has-feedback',
                ],
            ])->passwordInput()->label('Повторите пароль'); ?>

            <div class="form-group">
                <p>
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </p>
            </div>

            <?php ActiveForm::end();?>
        </div>
    </div>
</div>
