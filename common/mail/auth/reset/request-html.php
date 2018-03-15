<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/28/2018
 * Time: 1:43 PM
 */

/* @var $this \yii\web\View */
/* @var $user \core\entities\user\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/reset/confirm', 'token' => $user->password_reset_token]);
?>
<div class = "passreset-confirmation">
    <p>
        <?= \yii\helpers\Html::encode($user->username);?>,
    </p>

    <p>
        Пройдите по сслыке, чтобы восстановить пароль
    </p>

    <p>
        <?= \yii\helpers\Html::a(\yii\helpers\Html::encode($confirmLink), $confirmLink) ?>
    </p>
</div>
