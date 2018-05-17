<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/16/2018
 * Time: 5:47 PM
 */

use core\entities\sf\Tournament;
use core\forms\sf\GameForm;
use core\forms\sf\TourGamesForm;
use kartik\datetime\DateTimePicker;
use kartik\form\ActiveForm;
use yii\data\ArrayDataProvider;
use kartik\grid\GridView;
use yii\web\View;
use yii\helpers\Html;

/** @var Tournament $tournament */
/** @var $this View */
/** @var TourGamesForm[] $forms */


$this->title = 'Расписание игр турнира ' . $tournament->name;
$this->params['breadcrumbs'][] = ['label' => 'Турниры', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $tournament->name, 'url' => ['view', 'slug' => $tournament->slug]];
$this->params['breadcrumbs'][] = 'Расписание';
?>

<div class="tournament-schedule">
    <?php foreach ($forms as $tour => $form) :?>
        <br>
        <?php $tourForm = ActiveForm::begin(['type' => ActiveForm::TYPE_INLINE]) ?>
        <div class="row">
            <?= Html::hiddenInput('tour', $form->tour) ?>
            <?= GridView::widget([
                'dataProvider' => new ArrayDataProvider([
                    'allModels' => $form->gameForms,
                    'key' => function (GameForm $gameForm) {
                        return [
                            'id' => $gameForm->id
                        ];
                    }
                ]),

                'condensed' => true,
                'hover' => true,
                'summary' => false,
                'toolbar' => false,
                'options' => [
                    'class' => 'col-xs-12 col-md-10 col-lg-8',
                ],
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => 'Тур ' . $form->tour,
                    'footer' => Html::submitButton('Сохранить', ['class' => 'btn btn-success']),
                    'footerOptions' => [
                        'class' => 'kv-align-center',
                    ],
                ],
                'panelFooterTemplate' => '<p>{footer}</p>',
                'columns' => [
                    [
                        //'header' => 'ID',
                        'value' => function (GameForm $model) {
                            return $model->id;
                        },
                        'options' => [
                            'class' => 'col-xs-1',
                        ],
                        'vAlign' => 'middle'
                    ],

                    [
                        'value' => function (GameForm $model) use ($tourForm) {
                            return $this->render('_scheduleGame', ['model' => $model]);
                        },
                        'format' => 'raw',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'options' => [
                            'class' => 'col-xs-7',
                        ],
                    ],

                    [
                        'value' => function (GameForm $model) use ($tourForm) {
                            return $tourForm->field($model, '['. $model-> id . ']date')->widget(DateTimePicker::class,
                                [
                                    'type' => DateTimePicker::TYPE_INPUT,
                                    'removeButton' => false,
                                    'options' => [
                                        'value' => isset($model->date) ? Yii::$app->formatter->asDatetime($model->date) : null,
                                    ],
                                    'pluginOptions' => [
                                        'format' => 'dd.mm.yyyy hh:ii',
                                        'todayHighlight' => true,
                                        'autoclose' => true,
                                    ]
                                ]
                            );
                        },
                        'hAlign' => 'center',
                        'vAlign' => 'middle',
                        'options' => [
                            'class' => 'col-xs-3',
                        ],
                        'format' => 'raw'
                    ],

                    [
                        'class' => '\kartik\grid\ActionColumn',
                        'deleteOptions' => [
                            'label' => '<i class="glyphicon glyphicon-remove"></i>',
                            'data-method' => 'post',
                        ],
                        'template' => '{delete}',
                        'header' => false,
                        'hAlign' => 'center',
                        'buttons' => [
                            'delete' => function ($url, $model) {
                                return Html::a('<i class="glyphicon glyphicon-remove"></i>', ['games/delete', 'id' => $model->id], [
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => 'Вы действительно хотите удалить данную запись?'
                                    ]
                                ]);
                            },
                        ],

                        'headerOptions' => [
                            'style' => 'text-align:center',
                        ],
                    ]
                ]
            ]);?>
        </div>

        <?php ActiveForm::end();?>

    <?php endforeach; ?>
</div>


