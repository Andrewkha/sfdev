<?php

use backend\forms\TournamentSearch;
use backend\widgets\grid\WinnersForecastColumn;
use core\entities\sf\Tournament;
use core\helpers\TournamentHelper;
use kartik\grid\ActionColumn;
use kartik\widgets\DatePicker;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel TournamentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Турниры';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tournament-index">

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'bordered' => true,
        'hover' => true,
        'emptyCell' => '-',
        'responsive' => false,
        'toolbar' => false,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<i class="glyphicon glyphicon-glass"></i>' . ' ' . $this->title,
            'footer' => false,
        ],
        'columns' => [
            [
                'attribute' => 'id',
                'filter' => false,
                'width' => '30px',
                'mergeHeader' => true,
                'hAlign' => 'center'
            ],
            [
                'attribute' => 'name',
                'value' => function (Tournament $tournament) {
                    return Html::a(Html::encode($tournament->name), ['view', 'slug' => $tournament->slug]);
                },
                'format' => 'raw',
            ],
            'slug',
            [
                'filter' => \core\helpers\CountryHelper::countryListWithTournaments(),
                'attribute' => 'country_id',
                'value' => function (Tournament $tournament) {
                    return Html::a(Html::encode($tournament->country->name), ['countries/view', 'slug' => $tournament->country->slug]);
                },
                'format' => 'raw'
            ],

            [
                'attribute' => 'status',
                'filter' => TournamentHelper::statusList(),
                'value' => function (Tournament $tournament) {
                    return TournamentHelper::statusLabel($tournament->status);
                },
                'hAlign' => 'center',
                'format' => 'raw'
            ],
            [
                'attribute' => 'startDate',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_from',
                    'attribute2' => 'date_to',
                    'type' => DatePicker::TYPE_RANGE,
                    'separator' => '-',
                    'pluginOptions' => [
                        'todayHighlight' => true,
                        'autoclose' => true,
                    ]
                ]),

                'format' => 'date',
                'hAlign' => 'center',
            ],
            [
                'attribute' => 'winnersForecastDue',
                'class' => WinnersForecastColumn::class,
                'hAlign' => 'center',
                'format' => 'html',
                'mergeHeader' => true,
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{delete}'
            ],
        ],
    ]); ?>
</div>
