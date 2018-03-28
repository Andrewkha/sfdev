<?php

use core\entities\sf\Country;
use core\entities\sf\Team;
use core\entities\sf\Tournament;
use core\helpers\TournamentHelper;
use kartik\grid\ActionColumn;
use yii\data\ActiveDataProvider;
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $country Country */
/* @var $tournaments ActiveDataProvider */
/* @var $teams ActiveDataProvider */

$this->title = $country->name;
$this->params['breadcrumbs'][] = ['label' => 'Страны', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-view">

    <p>
        <?= Html::a('Изменить', ['update', 'slug' => $country->slug], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'slug' => $country->slug], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading "><strong>Параметры</strong></div>
                <div class="panel-body">
                    <?= DetailView::widget([
                        'model' => $country,
                        'attributes' => [
                            'id',
                            'name',
                            'slug',
                        ],
                    ]) ?>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading "><strong>Команды</strong></div>
                <div class="panel-body">
                    <p>
                        <?= Html::a('Создать команду', ['teams/create', 'slug' => $country->slug], ['class' => 'btn btn-success']) ?>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $teams,
                        'columns' => [
                            'id',
                            [
                                'attribute' => 'name',
                                'value' => function (Team $team) use ($country) {
                                    return Html::a(Html::encode($team->name), ['teams/update', 'country_slug' => $country->slug, 'slug' => $team->slug]);
                                },

                                'format' => 'raw',
                            ],
                            'slug',
                            [
                                'class' => ActionColumn::class,
                                'controller' => 'teams',
                                'template' => '{delete}',
                            ],
                        ]
                    ]); ?>
                </div>
            </div>


            <div class="panel panel-default">
                <div class="panel-heading "><strong>Турниры</strong></div>
                <div class="panel-body">
                    <p>
                        <?= Html::a('Создать турнир', ['tournaments/create', 'country_id' => $country->id], ['class' => 'btn btn-success']) ?>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $tournaments,
                        'columns' => [
                            [
                                'attribute' => 'name',
                                'value' => function (Tournament $tournament) {
                                    return Html::a(Html::encode($tournament->name), ['tournaments/view', 'slug' => $tournament->slug]);
                                },

                                'format' => 'raw',
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
                        ]
                    ]); ?>
                </div>
            </div>
        </div>
    </div>

</div>