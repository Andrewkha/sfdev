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

class Tournament extends ActiveRecord implements AggregateRoot
{
    use EventTrait;

    const STATUS_NOT_STARTED = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_FINISHED = 2;

    public static function create($name, $slug, $country_id, $tours, $startDate, $autoprocess, $autoprocessUrl, $winnersForecastDue): self
    {
        $tournament = new self();

        $tournament->name = $name;
        if ($slug) {
            $tournament->detachBehavior('slug');
            $tournament->slug = $slug;
        }

        $tournament->country_id = $country_id;
        $tournament->tours = $tours;
        $tournament->status = self::STATUS_NOT_STARTED;
        $tournament->startDate = $startDate;
        $tournament->autoprocess = $autoprocess;
        $tournament->autoprocessUrl = $autoprocessUrl;
        $tournament->winnersForecastDue = $winnersForecastDue;

        return $tournament;
    }

    public function edit($name, $slug, $country_id, $tours, $startDate, $autoprocess, $autoprocessUrl, $winnersForecastDue): void
    {
        $this->name = $name;
        $this->slug = $slug;
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
    }

    public function finish(): void
    {
        if ($this->isFinished()) {
            throw new \DomainException('Турнир уже закончен');
        }

        $this->status = self::STATUS_FINISHED;
        $this->recordEvent(new TournamentFinished($this));
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