<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/22/2018
 * Time: 1:46 PM
 */

namespace frontend\controllers\auth;

use Yii;
use core\forms\auth\SignupForm;
use core\services\auth\SignupService;
use yii\web\Controller;
use yii\filters\AccessControl;

class SignupController extends Controller
{
    private $service;

    public function __construct(string $id, $module, SignupService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['request'],
                'rules' => [
                    [
                        'actions' => ['request'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    public function actionRequest()
    {
        $form = new SignupForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->signup($form);
                Yii::$app->session->setFlash('success', 'Вам отправлено сообщение на email, проудите по ссылке для подтверждения регистрации');
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', 'Произошла ошибка регистрации. Обратитесь к администрации');
            }
        }

        return $this->render('request', [
            'model' => $form,
        ]);
    }
}