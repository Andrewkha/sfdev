<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/29/2018
 * Time: 12:17 PM
 */

use core\entities\sf\Tournament;
use kartik\detail\DetailView;
use yii\helpers\Html;

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
                        ],
                    ]) ?>
                </div>
            </div>
</div>