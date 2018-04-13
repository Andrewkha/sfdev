<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/9/2018
 * Time: 2:29 PM
 */

use core\services\UsersStandings\ForecastStandingsItem;
use kartik\grid\GridView;
use yii\web\View;
use yii\bootstrap\Modal;
use yii\helpers\Html;

/** @var ForecastStandingsItem $item */
/** @var View $this */
?>

<?php Modal::begin([
    'header' => Html::tag('strong', $item->user->username) . ' - прогноз по турам',
    'toggleButton' => ['label' => $item->user->username, 'class' => 'btn btn-link'],
    'options' => ['tabindex' => false],
    'size' => Modal::SIZE_DEFAULT,
]); ?>

<h2 class = 'text-center'><?= $item->user->username;?></h2>

<?= Html::tag('h4', 'Прогноз - призеры турнира', ['class' => 'text-center'])?>

<div class = "text-center">
    <?php if ($item->forecastedWinnersDataProvider()->totalCount > 0): ?>
        <?= GridView::widget([
            'dataProvider' => $item->forecastedWinnersDataProvider(),
            'showPageSummary' => true,
            'summary' => false,
            'condensed' => true,
            'columns' => [
                [
                    'attribute' => 'position',
                    'header' => 'Место',
                    'headerOptions' => [
                        'class' => 'kv-align-center',
                    ],
                    'vAlign' => 'middle',
                    'options' => [
                        'class' => 'col-xs-6'
                    ],
                ],

                [
                    'attribute' => 'team.name',
                    'header' => 'Команда',
                    'headerOptions' => [
                        'class' => 'kv-align-center',
                    ],
                    'vAlign' => 'middle',
                    'options' => [
                        'class' => 'col-xs-6'
                    ],
                ]
            ]
        ]);?>
    <?php else :?>
        <?= Html::tag('h5', 'Прогноз не сделан', ['class' => 'text-center'])?>
    <?php endif; ?>

    <hr>

    <?= Html::tag('h4', 'Очки по турам', ['class' => 'text-center'])?>

    <?= GridView::widget([
        'dataProvider' => $item->forecastToursDataProvider(),
        'showPageSummary' => true,
        'summary' => false,
        'condensed' => true,
        'columns' => [
            [
                'attribute' => 'tour',
                'header' => 'Тур',
                'headerOptions' => [
                    'class' => 'kv-align-center',
                ],
                'vAlign' => 'middle',
                'options' => [
                    'class' => 'col-xs-6'
                ],
                'pageSummary' => 'Всего'
            ],

            [
                'attribute' => 'points',
                'header' => 'Очки',
                'headerOptions' => [
                    'class' => 'kv-align-center',
                ],
                'vAlign' => 'middle',
                'options' => [
                    'class' => 'col-xs-6'
                ],
                'pageSummary' => true,
                'pageSummaryOptions' => [
                    'align' => 'center'
                ]
            ]
        ]
    ]) ;?>
</div>
<?php Modal::end();
?>
