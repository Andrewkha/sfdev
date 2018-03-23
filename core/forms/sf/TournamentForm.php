<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/22/2018
 * Time: 4:11 PM
 */

namespace core\forms\sf;


use core\entities\sf\Tournament;
use yii\base\Model;

class TournamentForm extends Model
{
    public $name;
    public $slug;
    public $type;
    public $country_id;
    public $tours;
    public $status;
    public $startDate;
    public $autoprocess;
    public $autoprocessUrl;
    public $winnersForecastDue;

    private $_tournament;

    public function __construct(Tournament $tournament = null, array $config = [])
    {
        if ($tournament) {
            $this->name = $tournament->name;
            $this->slug = $tournament->slug;
            $this->type = $tournament->type;
            $this->country_id = $tournament->country_id;
            $this->tours = $tournament->tours;
            $this->status = $tournament->status;
            $this->startDate = $tournament->startDate;
            $this->autoprocess = $tournament->autoprocess;
            $this->autoprocessUrl = $tournament->autoprocessUrl;
            $this->winnersForecastDue = $tournament->winnersForecastDue;

            $this->_tournament = $tournament;
        }
        parent::__construct($config);
    }

}