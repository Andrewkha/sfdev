<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 5/7/2018
 * Time: 4:08 PM
 */

namespace backend\controllers;

use core\services\sf\GameManageService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;

class GamesController extends Controller
{
    private $gamesService;

    public function __construct(string $id, $module, GameManageService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->gamesService = $service;
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ]
            ]
        ];
    }

    public function actionDelete($id)
    {
        try {
            $this->gamesService->remove($id);
            Yii::$app->session->setFlash('success', 'Игра успешно удалена');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(Yii::$app->request->referrer);
    }
}