<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/19/2018
 * Time: 4:55 PM
 */

namespace core\entities\sf;


use yii\db\ActiveRecord;
use Zelenin\yii\behaviors\Slug;

/**
 * Class Tournament
 * @package core\entities\sf
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $country_id
 * @property integer $tours
 * @property integer $status
 * @property integer $startDate
 * @property boolean $autoprocess
 * @property string $autoprocessUrl
 * @property integer $winnersForecastDue
 */

class Tournament extends ActiveRecord
{

    public function behaviors()
    {
        return [

            'slug' => [
                'class' => Slug::class,
                'slugAttribute' => 'slug',
                'attribute' => 'name',
                'ensureUnique' => true,
                'replacement' => '-',
                'lowercase' => true,
            ],
        ];
    }

    public static function tableName()
    {
        return '{{%tournaments}}';
    }
}