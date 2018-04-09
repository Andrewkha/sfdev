<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/19/2018
 * Time: 4:55 PM
 */

namespace core\entities\sf;

use core\entities\AggregateRoot;
use core\entities\EventTrait;
use core\entities\sf\events\TournamentFinished;
use core\entities\sf\events\TournamentStarted;
use core\entities\sf\queries\GameQuery;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use Zelenin\yii\behaviors\Slug;
use core\entities\user\User;

/**
 * Class Tournament
 * @package core\entities\sf
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $type
 * @property integer $country_id
 * @property integer $tours
 * @property integer $status
 * @property integer $startDate
 * @property boolean $autoprocess
 * @property string $autoprocessUrl
 * @property integer $winnersForecastDue
 *
 * @property Country $country
 * @property Team[] $teams
 * @property TeamTournaments[] $teamAssignments
 * @property Game[] $games
 * @property User[] $users;
 * @property UserTournaments $userAssignments
 */

class Tournament extends ActiveRecord implements AggregateRoot
{
    use EventTrait;

    const STATUS_NOT_STARTED = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_FINISHED = 2;

    const TYPE_REGULAR = 1;
    const TYPE_PLAY_OFF = 10;

    public static function create($name, $slug, $type, $country_id, $tours, $startDate, $autoprocess, $autoprocessUrl, $winnersForecastDue): self
    {
        $tournament = new self();

        $tournament->name = $name;

        if ($slug) {
            $tournament->detachBehavior('slug');
            $tournament->slug = $slug;
        }

        $tournament->type = $type;
        $tournament->country_id = $country_id;
        $tournament->tours = $tours;
        $tournament->status = self::STATUS_NOT_STARTED;
        $tournament->startDate = $startDate;
        $tournament->autoprocess = $autoprocess;
        $tournament->autoprocessUrl = $autoprocessUrl;
        $tournament->winnersForecastDue = $winnersForecastDue;

        return $tournament;
    }

    public function edit($name, $slug, $type, $country_id, $tours, $startDate, $autoprocess, $autoprocessUrl, $winnersForecastDue): void
    {
        $this->name = $name;
        if ($slug != '') {
            $this->detachBehavior('slug');
        }
        $this->slug = $slug;
        $this->type = $type;
        $this->country_id = $country_id;
        $this->tours = $tours;
        $this->startDate = $startDate;
        $this->autoprocess = $autoprocess;
        $this->autoprocessUrl = $autoprocessUrl;
        $this->winnersForecastDue = $winnersForecastDue;
    }

    public function start(): void
    {
        if ($this->isInProgress()) {
            throw new \DomainException('Турнир уже проходит');
        }
        $this->status = self::STATUS_IN_PROGRESS;
        $this->recordEvent(new TournamentStarted($this));
    }

    public function finish(): void
    {
        if ($this->isFinished()) {
            throw new \DomainException('Турнир уже закончен');
        }

        $this->status = self::STATUS_FINISHED;
        $this->recordEvent(new TournamentFinished($this));
    }

    public function assignParticipants(array $ids): void
    {
        $participants = $this->teamAssignments;
        $participantIds = ArrayHelper::getColumn($participants, 'team_id');

        foreach ($ids as $id) {
            if (in_array($id, $participantIds)) {
                continue;
            }

            $participants[] = TeamTournaments::create($id);
        }
        $this->teamAssignments = $participants;
    }

    public function removeParticipants(array $ids): void
    {
        $participants = $this->teamAssignments;

        foreach ($participants as $i => $participant) {
            if (in_array($participant->team_id, $ids)) {
                unset($participants[$i]);
                continue;
            }
        }
        $this->teamAssignments = $participants;

    }

    public function assignAliases(array $entities): void
    {
        $assignments = $this->teamAssignments;

        foreach ($assignments as $i => $assignment) {
            if (array_key_exists($assignment->team_id, $entities)) {
                $assignments[$i]->editAlias($entities[$assignment->team_id]);
            }
        }
        $this->teamAssignments = $assignments;
    }

    public function isFinished(): bool
    {
        return $this->status === self::STATUS_FINISHED;
    }

    public function isNotStarted(): bool
    {
        return $this->status === self::STATUS_NOT_STARTED;
    }

    public function isInProgress(): bool
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    public function isWinnersForecastOpen(): bool
    {
        return $this->winnersForecastDue >= time();
    }

    public function isAutoprocess(): bool
    {
        return $this->autoprocess;
    }

    public function isRegular(): bool
    {
        return $this->type === self::TYPE_REGULAR;
    }

    public function isPlayOff(): bool
    {
        return $this->type === self::TYPE_PLAY_OFF;
    }

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
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['teamAssignments'],
            ]
        ];
    }

    public function getCountry(): ActiveQuery
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }

    public function getTeamAssignments(): ActiveQuery
    {
        return $this->hasMany(TeamTournaments::class, ['tournament_id' => 'id']);
    }

    public function getTeams(): ActiveQuery
    {
        return $this->hasMany(Team::class, ['id' => 'team_id'])->via('teamAssignments');
    }

    public function getUserAssignments(): ActiveQuery
    {
        return $this->hasMany(UserTournaments::class, ['tournament_id' => 'id']);
    }

    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->via('userAssignments');
    }

    public function getGames(): GameQuery
    {
        /** @var GameQuery $query */
        $query = $this->hasMany(Game::class, ['tournament_id' => 'id']);
        return $query;
    }

    public static function tableName()
    {
        return '{{%tournaments}}';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'slug' => 'slug',
            'tours' => 'Количество туров',
            'type' => 'Тип',
            'autoprocess' => 'Автозагрузка результатов',
            'autoprocessUrl' => 'Источник данных',
            'status' => 'Статус',
            'country_id' => 'Страна',
            'startDate' => 'Дата начала',
            'winnersForecastDue' => 'Прогнозы на победителя до'
        ];
    }

}