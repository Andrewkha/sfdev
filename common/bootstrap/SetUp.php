<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/16/2018
 * Time: 5:51 PM
 */

namespace common\bootstrap;


use yii\base\BootstrapInterface;

class SetUp implements BootstrapInterface

{
    public function bootstrap($app)
    {
        $container = \Yii::$container;

    }
}