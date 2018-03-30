<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/22/2018
 * Time: 12:33 PM
 */

namespace core\repositories\sf;

use core\entities\sf\Tournament;
use yii\web\NotFoundHttpException;
use core\dispatchers\EventDispatcher;

class TournamentRepository
{
    private $eventDispatcher;

    public function __construct(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param $id
     * @return Tournament
     * @throws NotFoundHttpException
     */

    public function get($id): Tournament
    {
        if (!$tournament = Tournament::findOne($id)) {
            throw new NotFoundHttpException('Турнир не найден' );
        }

        return $tournament;
    }

    public function getBySlug($slug): Tournament
    {
        /* @var $tournament Tournament  */
        if (!$tournament = Tournament::find()->andWhere(['slug' => $slug])->one()) {
            throw new NotFoundHttpException('Турнир не найден' );
        }

        return $tournament;
    }

    /**
     * @param Tournament $tournament
     * @throws \RuntimeException
     */
    public function save(Tournament $tournament): void
    {
        if (!$tournament->save()) {
            throw new \RuntimeException('Ошибка сохранения');
        }

        $this->eventDispatcher->dispatchAll($tournament->releaseEvents());
    }

    /**
     * @param Tournament $tournament
     * @throws \RuntimeException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Tournament $tournament): void
    {
        if (!$tournament->delete()) {
            throw new \RuntimeException('Ошибка удаления');
        }

        $this->eventDispatcher->dispatchAll($tournament->releaseEvents());
    }

    public function existsByCountry($id): bool
    {
        return Tournament::find()->andWhere(['country_id' => $id])->exists();
    }
}