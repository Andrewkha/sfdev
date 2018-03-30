<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/19/2018
 * Time: 4:28 PM
 */

namespace backend\controllers;

use core\entities\sf\Country;
use core\entities\sf\Team;
use core\forms\sf\CountryForm;
use core\services\sf\CountryManageService;
use Yii;
use backend\forms\CountrySearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;

class CountriesController extends Controller
{
    private $countries;

    public function __construct(string $id, $module, CountryManageService $countries, array $config = [])
    {
        $this->countries = $countries;
        parent::__construct($id, $module, $config);
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

    public function actionIndex()
    {
        $searchModel = new CountrySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($slug)
    {
        $country = $this->findModel($slug);

        $teams = new ActiveDataProvider([
            'query' => $country->getTeams(),
            'key' => function (Team $team) use ($country) {
                return [
                    'country_slug' => $country->slug,
                    'slug' => $team->slug
                ];
            },
            'pagination' => false
        ]);

        $tournaments = new ActiveDataProvider([
            'query' => $country->getTournaments(),
        ]);

        return $this->render('view', [
            'country' => $country,
            'teams' => $teams,
            'tournaments' => $tournaments,
        ]);
    }

    public function actionCreate()
    {
        $form = new CountryForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $country = $this->countries->create($form);
                Yii::$app->session->setFlash('success', 'Запись успешно создана');
                return $this->redirect(['view', 'slug' => $country->slug]);
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
        $country = $this->findModel($slug);

        $form = new CountryForm($country);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $country = $this->countries->edit($country->slug, $form);
                Yii::$app->session->setFlash('success', 'Запись успешно изменена');
                return $this->redirect(['view', 'slug' => $country->slug]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', ['model' => $form, 'country' => $country]);
    }

    public function actionDelete($slug)
    {
        try {
            $this->countries->remove($slug);
            Yii::$app->session->setFlash('success', 'Запись успешно удалена');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    private function findModel($slug): Country
    {
        return $this->countries->getBySlug($slug);
    }
}