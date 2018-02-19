<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/19/2018
 * Time: 4:04 PM
 */


namespace core\entities\sf;

use yii\db\ActiveRecord;

/**
 * Class Country
 * @package core\entities\sf
 * @property integer $id
 * @property string $name
 * @property string $slug
 */

class Country extends ActiveRecord
{
    public static function create($name, $slug): self
    {
        $country = new static();
        $country->name = $name;
        $country->slug = $slug;

        return $country;
    }

    public function edit($name, $slug)
    {
        $this->name = $name;
        $this->slug = $slug;
    }

    public static function tableName(): string
    {
        return '{{%countries}}';
    }
}