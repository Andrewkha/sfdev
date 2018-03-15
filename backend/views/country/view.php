<?php

use core\entities\sf\Country;
use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $country Country */

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

                </div>
            </div>
        </div>
    </div>

</div>