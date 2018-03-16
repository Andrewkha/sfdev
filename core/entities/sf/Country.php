<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/19/2018
 * Time: 4:04 PM
 */


namespace core\entities\sf;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Class Country
 * @package core\entities\sf
 * @property integer $id
 * @property string $name
 * @property string $slug
 *
 * @property Team[] $teams
 *
 * @mixin SaveRelationsBehavior
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

    public function addTeam($name, $slug, UploadedFile $logo)
    {
        $teams = $this->teams;
        $teams[] = Team::create($name, $slug, $logo);
        $this->teams = $teams;
    }

    public function getTeams(): ActiveQuery
    {
        return $this->hasMany(Team::class, ['country_id' => 'id'])->orderBy('name');
    }

    public static function tableName(): string
    {
        return '{{%countries}}';
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'slug' => 'Slug'
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['teams'],
            ]
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL
        ];
    }
}