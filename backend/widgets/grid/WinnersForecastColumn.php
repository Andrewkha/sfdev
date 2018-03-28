<?php

namespace backend\widgets\grid;

use core\entities\sf\Tournament;
use kartik\grid\DataColumn;
use yii\helpers\Html;

class WinnersForecastColumn extends DataColumn
{

    protected function renderDataCellContent($model, $key, $index): string
    {
        /**@var $model Tournament*/
        return $model->winnersForecastDue === null ? $this->grid->emptyCell : $this->columnLabel($model);
    }

    private function columnLabel(Tournament $model)
    {
        $class = $model->isWinnersForecastOpen() ? 'success' : 'danger';
        return Html::tag('span', \Yii::$app->formatter->asDate($model->winnersForecastDue), ['class' => 'label label-' . $class]);
    }

}