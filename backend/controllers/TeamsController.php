<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/15/2018
 * Time: 11:01 AM
 */

namespace backend\controllers;


use core\entities\sf\Country;
use core\forms\sf\TeamForm;
use core\services\sf\CountryManageService;
use yii\filters\VerbFilter;
use yii\web\Controller;

class TeamsController extends Controller
{
    public $service;

    public function __construct(string $id, $module, CountryManageService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
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

    public function actionCreate($slug)
    {
        $country = $this->findCountryBySlug($slug);
        $form = new TeamForm();

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addTeam($country->id, $form);
                \Yii::$app->session->setFlash('success', 'Команда успешно добавлена');
                return $this->redirect(['countries/view', 'slug' => $country->slug]);
            } catch (\DomainException $e)
            {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'country' => $country,
            'model' => $form
        ]);
    }

    public function actionUpdate($country_slug, $slug)
    {
        $country = $this->findCountryBySlug($country_slug);
        $team = $country->getTeam($slug);

        $form = new TeamForm($team);

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->editTeam($country->id, $team->id, $form);
                \Yii::$app->session->setFlash('success', 'Изменения сохранены');
                return $this->redirect(['countries/view', 'slug' => $country->slug]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'country' => $country,
            'team' => $team
        ]);
    }

    public function actionDelete($country_slug, $slug)
    {
        $country = $this->findCountryBySlug($country_slug);
        $team = $country->getTeam($slug);

        try {
            $this->service->removeTeam($country->id, $team->id);
            \Yii::$app->session->setFlash('success', 'Запись успешно удалена');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['countries/view', 'slug' => $country->slug]);
    }

    private function findCountryBySlug($slug): Country
    {
        return $this->service->getBySlug($slug);
    }
}