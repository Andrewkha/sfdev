<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/9/2018
 * Time: 2:14 PM
 */

use core\services\UsersStandings\ForecastStandingsItem;
use yii\data\ArrayDataProvider;
use yii\web\View;
use kartik\grid\GridView;

/* @var $dataProvider ArrayDataProvider */
/* @var $this View */
?>
<div class="row">
    <div class="col-xs-12 col-lg-8">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'bordered' => true,
            'hover' => true,
            'responsive' => false,
            'toolbar' => false,
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => 'Прогнозы',
                'footer' => false,
                'summary' => false,
                'after' => false,
            ],
            'summary' => false,
            'columns' => [
                [
                    'header' => '',
                    'class' => 'kartik\grid\SerialColumn',
                    'options' => [
                        'class' => 'col-xs-1'
                    ],
                ],

                [
                    'header' => 'Пользователь',
                    'value' => function (ForecastStandingsItem $item) {
                        return $this->render('_forecastByTour', ['item' => $item]);
                    },
                    'format' => 'raw'
                ],

                [
                    'attribute' => 'points',
                    'header' => 'Очки',
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                    'options' => [
                        'class' => 'col-xs-1'
                    ],
                ],

                [
                    'attribute' => 'exactCount',
                    'header' => 'Точный счет',
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                    'options' => [
                        'class' => 'col-xs-1'
                    ],
                ],

                [
                    'attribute' => 'scoreDiffCount',
                    'header' => 'Разница',
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                    'options' => [
                        'class' => 'col-xs-1'
                    ],
                ],

                [
                    'attribute' => 'outcomeCount',
                    'header' => 'Исход',
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                    'options' => [
                        'class' => 'col-xs-1'
                    ],
                ],

                [
                    'attribute' => 'forecastCount',
                    'header' => 'Кол-во прогнозов',
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                    'options' => [
                        'class' => 'col-xs-1'
                    ],
                ],

                [
                    'header' => 'Очков за прогноз',
                    'value' => function (ForecastStandingsItem $item) {
                        if ($item->forecastCount == 0) {
                            return null;
                        } else {
                            return round($item->points / $item->forecastCount, 2);
                        }
                    },
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                    'options' => [
                        'class' => 'col-xs-1'
                    ],
                ],
            ]
        ]);?>
    </div>
</div>
