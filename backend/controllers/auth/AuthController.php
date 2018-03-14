<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/14/2018
 * Time: 11:46 AM
 */

namespace backend\controllers\auth;

use core\forms\auth\LoginForm;
use core\services\auth\AuthService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class AuthController extends Controller
{

    public $authService;

    public function __construct(string $id, $module, AuthService $authService, array $config = [])
    {
        $this->authService = $authService;
        parent::__construct($id, $module, $config);
    }

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

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $form = new LoginForm();

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->authService->login($form);
                \Yii::$app->session->setFlash('success', $user->username . ', с возвращением!');
                return $this->goBack();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('login', ['model' => $form]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}