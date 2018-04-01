<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/19/2018
 * Time: 4:14 PM
 */

namespace core\repositories\sf;


use core\entities\sf\Team;
use yii\web\NotFoundHttpException;

class TeamRepository
{
    /**
     * @param $id
     * @return Team
     * @throws NotFoundHttpException
     */
    public function get($id): Team
    {
        if (!$team = Team::findOne($id)) {
            throw new NotFoundHttpException('Команда не найдена' );
        }

        return $team;
    }

    public function getBySlug($slug): Team
    {
        /* @var $team Team  */
        if (!$team = Team::find()->andWhere(['slug' => $slug])->one()) {
            throw new NotFoundHttpException('Команда не найдена' );
        }

        return $team;
    }

    public function getByCountry($id): array
    {
        return Team::find()->andWhere(['country_id' => $id])->indexBy('id')->all();
    }

    /**
     * @param Team $team
     * @throws \RuntimeException
     */
    public function save(Team $team): void
    {
        if (!$team->save()) {
            throw new \RuntimeException('Ошибка сохранения');
        }
    }

    /**
     * @param Team $team
     * @throws \RuntimeException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Team $team): void
    {
        if (!$team->delete()) {
            throw new \RuntimeException('Ошибка удаления');
        }
    }

    public function existsByCountry($id): bool
    {
        return Team::find()->andWhere(['country_id' => $id])->exists();
    }
}