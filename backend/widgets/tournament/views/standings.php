<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/5/2018
 * Time: 6:10 PM
 */

use core\services\TeamStandings\StandingsItem;
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\web\View;

/* @var $dataProvider ArrayDataProvider */
/* @var $this View */

?>
<div class="row">
    <div class="col-xs-12 col-lg-6">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'bordered' => true,
            'hover' => true,
            'responsive' => false,
            'toolbar' => false,
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => 'Турнирная таблица',
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
                    'header' => 'Команда',
                    'value' => function (StandingsItem $item) {
                        return $this->render('_byTour', ['item' => $item]);
                    },
                    'format' => 'raw'
                ],

                [
                    'attribute' => 'gamesPlayed',
                    'header' => 'И',
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                ],

                [
                    'attribute' => 'gamesWon',
                    'header' => 'В',
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                ],

                [
                    'attribute' => 'gamesDraw',
                    'header' => 'Н',
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                ],

                [
                    'attribute' => 'gamesLost',
                    'header' => 'П',
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                ],

                [
                    'header' => 'Мячи',
                    'value' => function (StandingsItem $item) {
                        return $item->goalsScored . '-' . $item->goalsMissed;
                    },
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                ],

                [
                    'attribute' => 'points',
                    'header' => 'О',
                    'hAlign' => 'center',
                    'vAlign' => 'middle',
                ],
            ]
        ]);?>
    </div>
</div>


