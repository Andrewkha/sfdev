<?php

use core\entities\sf\Tournament;
use core\entities\user\User;
use core\services\UsersStandings\ForecastTour;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 5/23/2018
 * Time: 5:35 PM
 */

/* @var User $user */
/* @var ForecastTour $games */
/* @var integer $tour */
/* @var Tournament $tournament */

?>
<h4><?= $user->username ;?></h4>
<?php if ($games->isTourForecastEmpty()) :?>
    <p>
        Вы не сделали прогноз на <?= $tour?> тур <?= $tournament->name ?>. У вас еще есть время!
    </p>
<?php else : ?>
    <p>
        Ваш прогноз на <?= $tour?> тур <?= $tournament->name ?> неполный. Сделайте прогноз на все матчи, чтобы заработать дополнительные очки!
    </p>
<?php endif; ?>

<table border="1">
    <thead>
        <tr>
            <th>Дата</th>
            <th>Команды</th>
            <th>Ваш прогноз</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($games->forecastGamesItem as $one) :?>
            <tr>
                <td><?= Yii::$app->formatter->asDatetime($one->date) ;?></td>
                <td><?= $one->getParticipants() ;?></td>
                <td style="text-align: center"><?= $one->getForecast() ;?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $link = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/']); ?>
<p>
    <?= Html::a('Сделать прогноз', $link);?>
</p>