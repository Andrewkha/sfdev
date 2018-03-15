<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/15/2018
 * Time: 10:53 AM
 */

namespace core\entities\sf;

use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;
use Zelenin\yii\behaviors\Slug;

use yii\db\ActiveRecord;

/**
 * Class Team
 * @package core\entities\sf
 *
 * @property integer $id
 * @property integer $country_id
 * @property string $name
 * @property string $slug
 * @property string $logo
 *
 * @mixin Slug
 * @mixin ImageUploadBehavior
 */

class Team extends ActiveRecord
{

    public static function create($name, UploadedFile $logo): self
    {
        $team = new self();

        $team->name = $name;
        $team->logo = $logo;
    }

    public function behaviors()
    {
        return [
            [
                'class' => Slug::class,
                'slugAttribute' => 'slug',
                'attribute' => 'name',
                'ensureUnique' => true,
                'replacement' => '-',
                'lowercase' => true,
            ],

            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'logo',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/teams/logo/[[country_id]]/[[id]]_[[logo]]',
                'fileUrl' => '@static/origin/teams/logo/[[country_id]]/[[id]]_[[logo]]',
                'thumbPath' => '@staticRoot/cache/teams/logo/[[country_id]]/[[profile]]/[[id]]_[[logo]]',
                'thumbUrl' => '@static/cache/teams/logo/[[country_id]]/[[profile]]/[[id]]_[[logo]]',
                'thumbs' => [

                ]
            ]
        ];
    }

    public static function tableName()
    {
        return '{{%teams}}';
    }
}