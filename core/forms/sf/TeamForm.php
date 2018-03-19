<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/16/2018
 * Time: 11:18 AM
 */

namespace core\forms\sf;


use core\entities\sf\Team;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class TeamForm
 * @package core\forms\sf
 * @property string $name
 * @property string $slug
 * @property UploadedFile $logo
 * @property Team $_team
 */

class TeamForm extends Model
{
    public $name;
    public $slug;
    public $logo;

    private $_team;

    public function __construct(Team $team = null, array $config = [])
    {
        parent::__construct($config);
        if ($team) {
            $this->name = $team->name;
            $this->slug = $team->slug;
            $this->logo = $team->logo;

            $this->_team = $team;
        }
    }

    public function rules()
    {
        return array_filter([
            [['name', 'slug'], 'string'],
            ['name', 'required'],
            (!$this->_team) ? ['logo', 'required'] : false,
            [['name', 'slug'], 'unique', 'targetClass' => Team::class, 'filter' => $this->_team ? ['<>', 'id', $this->_team->id] : null],
            [['logo'], 'image', 'maxSize' => 1024*1024, 'tooBig' => 'Максимальный размер файла 1Мб'],
        ]);
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'slug' => 'Slug',
            'logo' => 'Логотип',
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->logo = UploadedFile::getInstance($this, 'logo');
            return true;
        }

        return false;
    }
}