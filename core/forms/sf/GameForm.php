<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 4/16/2018
 * Time: 5:10 PM
 */

namespace core\forms\sf;


use core\entities\sf\Game;
use core\entities\sf\Tournament;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class GameForm extends Model
{
    public $date;
    public $homeTeam;
    public $guestTeam;
    public $homeTeamScore;
    public $guestTeamScore;
    public $id;
    public $tour;

    private $maxTour;

    public function __construct($maxTour, Game $game = null, array $config = [])
    {
        if ($game) {
            $this->id = $game->id;
            $this->date = $game->date;
            $this->homeTeam = $game->homeTeam->name;
            $this->guestTeam = $game->guestTeam->name;
            $this->homeTeamScore = $game->homeScore;
            $this->guestTeamScore = $game->guestScore;
            $this->tour = $game->tour;
        }

        $this->maxTour = $maxTour;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['tour', 'homeTeamScore', 'guestTeamScore'], 'integer'],
            ['tour', 'compare', 'compareValue' => $this->maxTour, 'operator' => '<=', 'type' => 'number'],
            ['date', 'datetime', 'format' => 'php:d.m.Y H:i', 'timestampAttribute' => 'date'],
            [['homeTeam', 'guestTeam'], 'safe'],
        ];
    }

    public function getParticipants(Tournament $tournament)
    {
        return ArrayHelper::map($tournament->getTeams()->orderBy('name')->all(),
            'id', 'name');
    }
}