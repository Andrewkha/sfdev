<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/7/2018
 * Time: 2:24 PM
 */

namespace frontend\controllers\auth;


use core\exceptions\auth\EmptyPasswordResetTokenException;
use core\exceptions\auth\PasswordResetTokenExpiredException;
use core\exceptions\user\InactiveUserException;
use core\forms\auth\PasswordResetForm;
use core\forms\auth\PasswordResetRequestForm;
use core\services\auth\ResetService;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

class ResetController extends Controller
{
    public $service;

    public function __construct(string $id, $module, ResetService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['request', 'confirm'],
                'rules' => [
                    [
                        'actions' => ['request' , 'confirm'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    public function actionRequest()
    {
        $form = new PasswordResetRequestForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->request($form);
                Yii::$app->session->setFlash('success', 'Ссылка на восстановление пароля отправлена вам на email');
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            catch (\RuntimeException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('request', ['model' => $form]);
    }

    public function actionConfirm($token)
    {
        try {
            $this->service->validateToken($token);
        } catch (EmptyPasswordResetTokenException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect('/auth/reset/request');
        } catch (PasswordResetTokenExpiredException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect('/auth/reset/request');
        } catch (InactiveUserException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect('contact/index');
        }

        $form = new PasswordResetForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->reset($token, $form);
                Yii::$app->session->setFlash('success', 'Пароль успешно восстановлен, можете войти в систему');
                return $this->redirect('/auth/auth/login');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('reset', ['model' => $form]);
    }
}