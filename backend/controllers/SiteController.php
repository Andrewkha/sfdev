<?php
namespace backend\controllers;

use core\entities\sf\Tournament;
use core\entities\user\User;
use core\services\UsersStandings\ForecastStandings;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTest()
    {
        $tournament = Tournament::findOne(26);
        $standings = new ForecastStandings($tournament, true);
        $user = User::findOne(37);
        $vlad = USer::findOne(40);

        var_dump($standings->getPosition($user));

        exit;
    }

}
