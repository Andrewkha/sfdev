<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/5/2018
 * Time: 4:57 PM
 */

namespace core\entities\sf\queries;


use yii\db\ActiveQuery;

class GameQuery extends ActiveQuery
{
    public function finished()
    {
        return $this->andWhere(['not', ['homeScore' => NULL]])
        ->andWhere(['not', ['guestScore' => NULL]]);
    }
}