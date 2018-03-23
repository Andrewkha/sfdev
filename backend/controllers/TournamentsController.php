<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 23.03.2018
 * Time: 13:23
 */

namespace backend\controllers;


use backend\forms\TournamentSearch;
use core\services\sf\TournamentManageService;
use yii\web\Controller;
use Yii;

class TournamentsController extends Controller
{

    public $tournamentService;

    public function __construct(string $id, $module, TournamentManageService $service, array $config = [])
    {
        $this->tournamentService = $service;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(): string
    {
        $searchModel = new TournamentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}