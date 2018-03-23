<?php

use backend\forms\TournamentSearch;
use core\entities\sf\Tournament;
use core\helpers\TournamentHelper;
use kartik\grid\ActionColumn;
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

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'bordered' => true,
                'hover' => true,
                'responsive' => false,
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => $this->title,
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
                        'label' => 'Название',
                        'attribute' => 'name',
                        'value' => function (Tournament $tournament) {
                            return Html::a(Html::encode($tournament->name), ['view', 'slug' => $tournament->slug]);
                        },
                        'format' => 'raw',
                    ],
                    'slug',
                    [
                        'label' => 'Страна',
                        'filter' => \core\helpers\CountryHelper::coutnryList(),
                        'attribute' => 'country_id',
                        'value' => 'country.name'
                    ],

                    [
                        'label' => 'Статус',
                        'attribute' => 'status',
                        'filter' => TournamentHelper::statusList(),
                        'value' => function (Tournament $tournament) {
                            return TournamentHelper::statusLabel($tournament->status);
                        },
                        'hAlign' => 'center',
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Дата начала',
                        'attribute' => 'startDate',
                        'value' => function (Tournament $tournament) {
                            return date('d.m.Y', $tournament->startDate);
                        },
                        'format' => 'raw',
                        'hAlign' => 'center',
                    ],
                    [
                        'label' => "Прогнозы на победителя до",
                        'attribute' => 'winnersForecastDue',
                        'value' => function (Tournament $tournament) {
                            return (null !== $tournament->winnersForecastDue) ? date('d.m.Y', $tournament->winnersForecastDue) : '-';
                        },
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
    </div>
</div>
