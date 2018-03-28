<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/19/2018
 * Time: 4:41 PM
 */

namespace core\forms\sf;


use core\entities\sf\Country;
use core\validators\SlugValidator;
use yii\base\Model;

class CountryForm extends Model
{
    public $name;
    public $slug;

    private $country;

    public function __construct(Country $country = null, array $config = [])
    {
        if ($country) {
            $this->name = $country->name;
            $this->slug = $country->slug;
            $this->country = $country;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            ['slug', SlugValidator::class],
            [['name', 'slug'], 'unique', 'targetClass' => Country::class, 'filter' => $this->country ? ['<>', 'id', $this->country->id] : null],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'slug' => 'slug',
        ];
    }
}