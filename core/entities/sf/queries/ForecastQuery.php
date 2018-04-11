<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/6/2018
 * Time: 5:34 PM
 */

namespace core\entities\sf\queries;


use yii\db\ActiveQuery;

class ForecastQuery extends ActiveQuery
{
    public function forUser($user_id)
    {
        return $this->andWhere(['user_id' => $user_id]);
    }

    public function forGames($alias = null, array $games): ActiveQuery
    {
        return $this->andWhere([($alias ? $alias . '.' : '') . 'game_id' => $games]);
    }
}