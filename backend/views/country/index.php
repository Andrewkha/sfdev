<?php

use backend\forms\CountrySearch;
use core\entities\sf\Country;
use kartik\grid\ActionColumn;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel CountrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Страны';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-index">

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'id',
                    [
                        'label' => 'Название',
                        'attribute' => 'name',
                        'value' => function (Country $country) {
                            return Html::a(Html::encode($country->name), ['view', 'slug' => $country->slug]);
                        },
                        'format' => 'raw',
                    ],
                    'slug',
                    ['class' => ActionColumn::class],
                ],
            ]); ?>
        </div>
    </div>
</div>
