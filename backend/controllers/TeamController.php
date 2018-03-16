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
use yii\web\Controller;

class TeamController extends Controller
{
    public $service;

    public function __construct(string $id, $module, CountryManageService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionCreate($slug)
    {
        $country = $this->findCountryBySlug($slug);
        $form = new TeamForm();

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addTeam($country->id, $form);
                \Yii::$app->session->setFlash('success', 'Команда успешно добавлена');
                return $this->redirect(['country/view', 'slug' => $country->slug]);
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

    private function findCountryBySlug($slug): Country
    {
        return $this->service->getBySlug($slug);
    }
}