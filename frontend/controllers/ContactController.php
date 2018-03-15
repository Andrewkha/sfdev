<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 3/13/2018
 * Time: 12:59 PM
 */

namespace frontend\controllers;


use core\forms\ContactForm;
use core\services\ContactService;
use yii\web\Controller;

class ContactController extends Controller
{
    public $contactService;

    public function __construct(string $id, $module, ContactService $contactService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->contactService = $contactService;
    }

    public function actionIndex()
    {
        $form = new ContactForm();

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->contactService->send($form);
                \Yii::$app->session->setFlash('success', 'Спасибо за обращение, мы свяжемся с Вами в ближайшее время');
                return $this->goHome();
            } catch (\Exception $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->refresh();
            }

        } else {
            return $this->render('contact', [
                'model' => $form,
            ]);
        }
    }
}