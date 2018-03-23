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

    <div class="row">
        <div class="box col-md-6">
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
                    'itemLabelSingle' => 'страна',
                    'itemLabelPlural' => 'страны',
                    'toolbar' => false,
                    'columns' => [
                        [
                            'attribute' => 'id',
                            'filter' => false,
                            'width' => '50px',
                            'hAlign' => 'center',
                            'mergeHeader' => true,
                        ],
                        [
                            'label' => 'Название',
                            'attribute' => 'name',
                            'value' => function (Country $country) {
                                return Html::a(Html::encode($country->name), ['view', 'slug' => $country->slug]);
                            },
                            'format' => 'raw',
                        ],
                        'slug',
                        [
                            'class' => ActionColumn::class,
                            'template' => '{delete}'
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>

</div>
