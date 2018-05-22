<?php
namespace backend\controllers;

use core\entities\sf\Tournament;
use core\entities\user\User;
use core\services\notifier\TourForecastReminder;
use core\services\parser\Parser;
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
        $tournament = Tournament::findOne(['id' => 24]);
        $notification = new TourForecastReminder($tournament, 8);
        $user = User::findOne(['id' => 29]);

        print_r($notification->getContent($user));
    }

}
