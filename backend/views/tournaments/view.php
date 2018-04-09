<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/29/2018
 * Time: 12:17 PM
 */

use backend\widgets\tournament\ForecastStandingsWidget;
use backend\widgets\tournament\StandingsWidget;
use backend\widgets\tournament\StatusManage;
use core\entities\sf\Tournament;
use core\helpers\TournamentHelper;
use kartik\detail\DetailView;
use yii\helpers\Html;
use backend\widgets\tournament\ParticipantsManage;

/* @var $this yii\web\View */
/* @var $tournament Tournament*/

$this->title = $tournament->name;
$this->params['breadcrumbs'][] = ['label' => 'Турниры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tournament-view">

    <p>
        <?= Html::a('Изменить', ['update', 'slug' => $tournament->slug], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'slug' => $tournament->slug], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= StatusManage::widget(['tournament' => $tournament]); ?>

    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading "><strong>Параметры</strong></div>
                <div class="panel-body">
                    <?= DetailView::widget([
                        'model' => $tournament,
                        'attributes' => [
                            'id',
                            'name',
                            'slug',
                            'tours',
                            [
                                'attribute' => 'type',
                                'value' => TournamentHelper::typeName($tournament->type)
                            ],
                            'autoprocess:boolean',
                            [
                                'attribute' => 'autoprocessUrl',
                                'value' => Html::tag('p', isset($tournament->autoprocessUrl) ? Html::a($tournament->autoprocessUrl, $tournament->autoprocessUrl) : '') .
                                Html::a('Назначить псевдонимы', ['aliases', 'slug' => $tournament->slug]),
                                'format' => 'raw',
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <?php if ($tournament->isNotStarted()) :?>
        <?= ParticipantsManage::widget(['tournament' => $tournament]); ?>
    <?php endif;?>

    <?php if ($tournament->isInProgress() || $tournament->isFinished()) : ?>
        <?= StandingsWidget::widget(['tournament' => $tournament]); ?>
        <?= ForecastStandingsWidget::widget(['tournament' => $tournament]); ?>
    <?php endif; ?>

</div>