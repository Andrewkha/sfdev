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
use core\forms\sf\TournamentAliasesForm;
use core\forms\sf\TournamentForm;
use core\helpers\TournamentHelper;
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
                    'finish' => ['POST'],
                    'start' => ['POST'],
                    'assign-participants' => ['POST'],
                    'remove-participants' => ['POST'],
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

    public function actionStart($slug)
    {
        try {
            $this->tournamentService->start($slug);
            Yii::$app->session->setFlash('success', 'Турнир переведен в статус ' . TournamentHelper::statusName(Tournament::STATUS_IN_PROGRESS));
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionFinish($slug)
    {
        try {
            $this->tournamentService->finish($slug);
            Yii::$app->session->setFlash('success', 'Турнир переведен в статус ' . TournamentHelper::statusName(Tournament::STATUS_FINISHED));
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionAssignParticipants($slug)
    {
        $tournament = $this->findModel($slug);

        if ($candidates = Yii::$app->request->post('candidates')) {
            try {
                $this->tournamentService->assignParticipants($tournament->slug, $candidates);
                Yii::$app->session->setFlash('success', 'Участники успешно добавлены');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRemoveParticipants($slug)
    {
        $tournament = $this->findModel($slug);
        $remove = Yii::$app->request->post('participants');

        try {
            $this->tournamentService->removeParticipants($tournament->slug, $remove);
            Yii::$app->session->setFlash('success', 'Участники успешно удалены');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionAliases($slug)
    {
        $tournament = $this->findModel($slug);
        $form = new TournamentAliasesForm($tournament);

        if ($form->load(Yii::$app->request->post()) && $form->validate())
        try {
            $this->tournamentService->assignAliases($slug, $form);
            Yii::$app->session->setFlash('success', 'Операция выполнена успешно');
            $this->redirect(['view', 'slug' => $tournament->slug]);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->render('aliases', ['tournament' => $tournament, 'forms' => $form]);
    }

    private function findModel($slug): Tournament
    {
        return $this->tournamentService->getBySlug($slug);
    }
}