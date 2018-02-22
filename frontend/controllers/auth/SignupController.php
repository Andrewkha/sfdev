<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/22/2018
 * Time: 1:46 PM
 */

namespace frontend\controllers\auth;


use yii\web\Controller;

class SignupController extends Controller
{
    public function __construct(string $id, $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
    }
}