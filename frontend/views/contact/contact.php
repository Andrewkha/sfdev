<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/13/2018
 * Time: 2:38 PM
 */


/** @var $this View */
/** @var $model ContactForm */


use core\entities\user\User;
use core\forms\ContactForm;
use himiklab\yii2\recaptcha\ReCaptcha;
use kartik\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Обратная связь';
$this->params['breadcrumbs'][] = $this->title;

if (!\Yii::$app->user->isGuest) {
    /** @var $user User */
    $user = \Yii::$app->user->identity;
} else {
    $user = false;
}

?>

<div class="contact-contact">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class = "row">
        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
            <?php $form = ActiveForm::begin([
                'id' => 'contact-form',
            ]); ?>

                <?php if (!$user): ?>
                    <?= $form->field($model, 'username', [
                            'template' => '{label} <div class="row"><div class="col-lg-6">{input}{error}{hint}</div></div>',
                            'options' => [
                                'class' => 'form-group has-feedback',
                            ],
                        ])->textInput([
                            'autofocus' => true,
                            'placeholder' => $model->getAttributeLabel('username')
                        ])->label(false); ?>

                    <?= $form->field($model, 'email', [
                            'template' => '{label} <div class="row"><div class="col-lg-6">{input}{error}{hint}</div></div>',
                            'addon' => ['prepend' => ['content' => '@']],
                            'options' => [
                                'class' => 'form-group has-feedback',
                            ],
                        ])->textInput([
                            'placeholder' => $model->getAttributeLabel('email')
                        ])->label(false); ?>

                <?php else : ?>
                    <?= Html::activeHiddenInput($model, 'username', ['value' => $user->username]); ?>
                    <?= Html::activeHiddenInput($model, 'email', ['value' => $user->email]); ?>
                <?php endif; ?>

                <?= $form->field($model, 'subject', [
                    'template' => '{label} <div class="row"><div class="col-lg-6">{input}{error}{hint}</div></div>',
                    'options' => [
                        'class' => 'form-group has-feedback',
                    ],
                ])->textInput([
                    'placeholder' => $model->getAttributeLabel('subject')
                ])->label(false); ?>

                <?= $form->field($model, 'body')->widget(CKEditor::className(), [
                    'editorOptions' => [
                        'preset' => 'basic'
                    ]
                ]) ?>

                <?= $form->field($model, 'reCaptcha')->widget(ReCaptcha::class)->label(false); ?>

                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>