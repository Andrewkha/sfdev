<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/22/2018
 * Time: 4:11 PM
 */

namespace core\forms\sf;


use core\entities\sf\Tournament;
use core\validators\SlugValidator;
use yii\base\Model;

class TournamentForm extends Model
{
    public $name;
    public $slug;
    public $type;
    public $country_id;
    public $tours;
    public $startDate;
    public $autoprocess;
    public $autoprocessUrl;
    public $winnersForecastDue;

    private $_tournament;

    public function __construct($country_id = null, Tournament $tournament = null, array $config = [])
    {
        if ($country_id) {
            $this->country_id = $country_id;
        }
        if ($tournament) {
            $this->name = $tournament->name;
            $this->slug = $tournament->slug;
            $this->type = $tournament->type;
            $this->country_id = $tournament->country_id;
            $this->tours = $tournament->tours;
            $this->startDate = $tournament->startDate;
            $this->autoprocess = $tournament->autoprocess;
            $this->autoprocessUrl = $tournament->autoprocessUrl;
            $this->winnersForecastDue = $tournament->winnersForecastDue;

            $this->_tournament = $tournament;
        } else {
            $this->type = Tournament::TYPE_REGULAR;
        }

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'type', 'country_id', 'tours', 'startDate', 'autoprocess'], 'required'],
            [['name', 'slug'], 'string'],
            ['slug', SlugValidator::class],
            [['name', 'slug'], 'unique', 'targetClass' => Tournament::class, 'filter' => $this->_tournament ? ['<>', 'id', $this->_tournament->id] : null],
            ['autoprocess', 'boolean'],
            [['tours', 'country_id', 'type'], 'integer'],
            ['autoprocessUrl', 'url'],
            ['autoprocessUrl', 'required', 'when' => function ($model) {
                    return $model->autoprocess == true;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#country').val() == '1';
                }"
            ],
            ['startDate', 'date', 'format' => 'php:d.m.Y', 'timestampAttribute' => 'startDate'],
            ['winnersForecastDue', 'date', 'format' => 'php:d.m.Y', 'timestampAttribute' => 'winnersForecastDue']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'slug' => 'Slug',
            'country_id' => 'Страна',
            'tours' => 'Количество туров',
            'startDate' => 'Дата начала',
            'type' => 'Тип турнира',
            'autoprocess' => 'Автозагрузка данных',
            'autoprocessUrl' => 'Источник данных',
            'winnersForecastDue' => 'Прием прогнозов на победителей до'
        ];
    }
}