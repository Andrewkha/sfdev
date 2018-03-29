<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 23.03.2018
 * Time: 13:23
 */

namespace backend\controllers;


use backend\forms\TournamentSearch;
use core\entities\sf\Tournament;
use core\forms\sf\TournamentForm;
use core\services\sf\TournamentManageService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;

class TournamentsController extends Controller
{

    public $tournamentService;

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

    public function actionView($slug)
    {
        $tournament = $this->findModel($slug);

        return $this->render('view', [
            'tournament' => $tournament,
        ]);
    }

    public function actionCreate($country_id = null)
    {
        $form = new TournamentForm($country_id);

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $tournament = $this->tournamentService->create($form);
                Yii::$app->session->setFlash('success', 'Запись успешно создана');
                return $this->redirect(['view', 'slug' => $tournament->slug]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionUpdate($slug)
    {
        $tournament = $this->findModel($slug);

        $form = new TournamentForm(null, $tournament);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $tournament = $this->tournamentService->edit($tournament->slug, $form);
                Yii::$app->session->setFlash('success', 'Запись успешно изменена');
                return $this->redirect(['view', 'slug' => $tournament->slug]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', ['model' => $form, 'tournament' => $tournament]);
    }

    public function actionDelete($slug)
    {
        try {
            $this->tournamentService->remove($slug);
            Yii::$app->session->setFlash('success', 'Запись успешно удалена');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    private function findModel($slug): Tournament
    {
        return $this->tournamentService->getBySlug($slug);
    }
}