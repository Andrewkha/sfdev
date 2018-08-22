<?php

use core\entities\user\User;
use core\services\UsersStandings\ForecastStandingsItem;
use core\services\UsersStandings\ForecastTour;
use core\entities\sf\Tournament;
use core\services\UsersStandings\TourStandingsItem;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 8/20/2018
 * Time: 3:11 PM
 */

/* @var User $user */
/* @var ForecastTour $games */
/* @var integer $tour */
/* @var Tournament $tournament */
/* @var TourStandingsItem[] $tourLeaders */
/* @var array $position */
/* @var integer $numParticipants */
/* @var ForecastStandingsItem $leader */
?>

<h4><?= $user->username ;?></h4>

<p>
    Закончен <?= $tour;?> тур турнира <?= $tournament->name;?>. Ознакомьтесь с результатами Вашего прогноза.
</p>

<table border="1">
    <thead>
    <tr>
        <th>Дата</th>
        <th>Хозяева</th>
        <th>Счет матча</th>
        <th>Гости</th>
        <th>Ваш прогноз</th>
        <th>Очки</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($games->forecastGamesItem as $one) :?>
            <tr>
                <td><?= Yii::$app->formatter->asDatetime($one->date) ;?></td>
                <td style="text-align: right"><?= $one->homeTeam ;?></td>
                <td style="text-align: center"><?= $one->getScore() ;?></td>
                <td><?= $one->guestTeam ;?></td>
                <td style="text-align: center"><?= $one->getForecast() ;?></td>
                <td style="text-align: center"><strong><?= $one->getPoints() ;?></strong></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="5"><strong>Всего в туре:</strong></td>
            <td style="text-align: center"><strong><?= $games->points;?></strong></td>
        </tr>
    </tbody>
</table>

<h4>
    Лучшие прогнозисты тура
</h4>

<?php if (!$tourLeaders) : ?>
    <p>Никто в этом туре прогнозов не сделал</p>

<?php else :?>
    <table border="1">
        <thead>
        <tr>
            <th>Пользователь</th>
            <th>Очки</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tourLeaders as $one) :?>
            <tr>
                <td><?= $one->username ;?></td>
                <td style="text-align: center"><?= $one->points ;?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif;?>

<h4>
    Всего в турнире
</h4>

<table border="1">
    <thead>
    <tr>
        <th>Место</th>
        <th>Очки</th>
        <th>Всего участников</th>
        <th>Лидер</th>
        <th>Очки лидера</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: center"><?= $position['position'] ;?></td>
            <td style="text-align: center"><?= $position['points'];?></td>
            <td style="text-align: center"><?= $numParticipants;?></td>
            <td style="text-align: center"><?= $leader->user->username;?></td>
            <td style="text-align: center"><?= $leader->points;?></td>
        </tr>
    </tbody>
</table>

<?php $link = Yii::$app->frontendUrlManager->createAbsoluteUrl(['/']); ?>
<p>
    <?= Html::a($link, $link);?>
</p>