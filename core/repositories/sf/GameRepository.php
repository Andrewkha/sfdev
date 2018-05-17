<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 5/7/2018
 * Time: 4:10 PM
 */

namespace core\repositories\sf;

use core\entities\sf\Game;
use yii\web\NotFoundHttpException;

class GameRepository
{
    /**
     * @param $id
     * @return Game
     * @throws NotFoundHttpException
     */
    public function get($id): Game
    {
        if (!$game = Game::findOne($id)) {
            throw new NotFoundHttpException('Игра не найдена' );
        }

        return $game;
    }

    /**
     * @param Game $game
     * @throws \RuntimeException
     */
    public function save(Game $game): void
    {
        if (!$game->save()) {
            throw new \RuntimeException('Ошибка сохранения');
        }
    }

    /**
     * @param Game $game
     * @throws \RuntimeException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Game $game): void
    {
        if (!$game->delete()) {
            throw new \RuntimeException('Ошибка удаления');
        }
    }
}