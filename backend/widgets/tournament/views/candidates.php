<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/2/2018
 * Time: 10:29 AM
 */

use core\entities\sf\Tournament;
use kartik\checkbox\CheckboxX;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\web\View;
use yii\helpers\Html;

/**
 * @var $this View
 * @var $candidates array
 * @var $participants array
 * @var $tournament Tournament
 */
?>

<div class="row">
    <div class="col-sm-5 col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading "><strong>Управление участниками</strong></div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'action' => ['delete-participant', 'slug' => $tournament->slug],
                    'method' => 'post',
                ]);?>
                    <table class="table table-striped table condensed">
                        <tr>
                            <th>Команда</th>
                            <th>Удалить</th>
                        </tr>
                        <?php foreach ($participants as $k => $one) : ?>
                            <tr>
                                <td><?= $one;?></td>
                                <td><?= CheckboxX::widget([
                                    'name' => $k,
                                    'options' => ['id' => $k],
                                    'pluginOptions' => ['threeState' => false]
                                ]) ?></td>
                            </tr>
                        <?php endforeach;?>
                    </table>
                <div class="form-group">
                    <?= Html::submitButton('Удалить', ['class' => 'btn btn-danger']) ?>
                </div>

                <?php ActiveForm::end();?>

                <?php $form = ActiveForm::begin([
                    'action' => ['add-participants', 'slug' => $tournament->slug],
                    'method' => 'post'
                ]); ?>
                <p>
                    <?= Select2::widget([
                        'size' => Select2::MEDIUM,
                        'theme' => Select2::THEME_KRAJEE,
                        'data' => $candidates,
                        'name' => 'candidates',
                        'options' => ['placeholder' => 'Добавьте участников...', 'multiple' => true],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ]
                    ]) ;?>
                </p>

                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
