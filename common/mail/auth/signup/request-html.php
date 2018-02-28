<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/28/2018
 * Time: 1:43 PM
 */

/* @var $this \yii\web\View */
/* @var $user \core\entities\user\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/signup/confirm', 'token' => $user->email_confirm_token]);
?>
<div class = "email-confirmation">
    <p>
        <?= \yii\helpers\Html::encode($user->username);?>,
    </p>

    <p>
        Пройдите по сслыке, чтобы закончить регистрацию
    </p>

    <p>
        <?= \yii\helpers\Html::a(\yii\helpers\Html::encode($confirmLink), $confirmLink) ?>
    </p>
</div>
