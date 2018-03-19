<?php
/**
 * Created by PhpStorm.
 * User: achernys
 * Date: 2/16/2018
 * Time: 5:22 PM
 */


return [
    'class' => 'yii\web\UrlManager',
    'hostInfo' => $params['backendHostInfo'],
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '' => 'site/index',

        '<_a:login|logout>' => 'auth/auth/<_a>',

        '<_c:countries>' => '<_c>/index',
        '<_c:countries>/<slug:[\w\-]+>' => '<_c>/view',
        '<_c:countries>/<_a:create>' => '<_c>/<_a>',
        '<_c:countries>/<slug:[\w\-]+>/<_a:update|delete>' => '<_c>/<_a>',
        '<country_slug:[\w\-]+>/<slug:[\w\-]+>' => 'teams/update',
        '<country_slug:[\w\-]+>/<slug:[\w\-]+>/delete' => 'teams/delete',
        '<_c:teams>/<slug:[\w\-]+>/<_a:create>' => '<_c>/<_a>',

/*

        '<_c:[\w\-]+>/<_a:create>/<slug:[\w\-]+>' => '<_c>/<_a>',
        '<_c:[\w\-]+>/<_a:create>' => '<_c>/<_a>',





*/

        '<_c:[\w\-]+>' => '<_c>/index',
        '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
        '<_c:[\w\-]+>/<_a:[\w-]+>' => '<_c>/<_a>',
        '<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_c>/<_a>',
    ],
];