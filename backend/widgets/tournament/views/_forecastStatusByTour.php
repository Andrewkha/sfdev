<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/9/2018
 * Time: 4:35 PM
 */

use core\services\UsersStandings\ForecastGameItem;
use core\services\UsersStandings\ForecastTour;
use kartik\grid\GridView;
use yii\helpers\Html;use yii\web\View;
use yii\bootstrap\Modal;

/** @var $this View */
/** @var $tour ForecastTour */

?>
<?php Modal::begin([
    'header' => Html::tag('strong', 'Детали прогноза'),
    'toggleButton' => [
        'label' => $tour->tour,
        'class' => ($tour->isTourForecastEmpty()) ? 'btn btn-danger' : (($tour->isTourForecastComplete()) ? 'btn btn-success' : 'btn btn-warning'),
        'style' => 'margin-bottom: 5px'
    ],
    'options' => ['tabindex' => false],
    'size' => Modal::SIZE_DEFAULT,
]); ?>
    <?= GridView::widget([
        'dataProvider' => $tour->gameItemsDataProvider(),
        'summary' => false,
        'condensed' => true,
        'showPageSummary' => true,
        'rowOptions' => function (ForecastGameItem $model) {
            return ($model->isForecastSet()) ? ['class' => 'success'] : ['class' => 'danger'];
        },
        'columns' => [
            [
                'attribute' => 'date',
                'format' => 'datetime',
                'vAlign' => 'middle',
                'headerOptions' => [
                    'class' => 'kv-align-center',
                ],
                'header' => 'Дата'
            ],

            [
                'attribute' => 'homeTeam',
                'header' => 'Хозяева',
                'headerOptions' => [
                    'class' => 'kv-align-center',
                ],
                'vAlign' => 'middle',
            ],

            [
                'header' => 'Прогноз',
                'headerOptions' => [
                    'class' => 'kv-align-center',
                ],
                'vAlign' => 'middle',
                'value' => function (ForecastGameItem $model) {
                    return $model->homeForecastScore . ' : ' . $model->guestForecastScore;
                }
            ],

            [
                'attribute' => 'guestTeam',
                'header' => 'Гости',
                'headerOptions' => [
                    'class' => 'kv-align-center',
                ],
                'vAlign' => 'middle',
            ],


        ]
    ]) ?>
<?php Modal::end();?>
