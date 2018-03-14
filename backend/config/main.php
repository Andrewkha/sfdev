<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'name' => 'Sportforecast admin panel',
    'aliases' => [
        '@staticRoot' => $params['staticPath'],
        '@static' => $params['staticHostInfo'],
    ],
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => [
        'log',
        'common\bootstrap\SetUp',
        'backend\bootstrap\SetUp',
    ],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'cookieValidationKey' => $params['cookieValidationKey'],
        ],
        'user' => [
            'identityClass' => 'core\entities\user\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity',
                'httpOnly' => true,
                'domain' => $params['cookieDomain'],
            ],
            'loginUrl' => ['auth/auth/login']
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => '_session',
            'cookieParams' => [
                'domain' => $params['cookieDomain'],
                'httpOnly' => true,
            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'frontendUrlManager' => require __DIR__.'/../../frontend/config/urlManager.php',
        'backendUrlManager' => require __DIR__.'/urlManager.php',
        'urlManager' => function() {
            return Yii::$app->get('backendUrlManager');
        },

    ],

    'as access' => [
        'class' => yii\filters\AccessControl::className(),
        'except' => ['auth/auth/login', 'site/error'],
        'rules' => [
            [
                'allow' => true,
                'roles' => ['admin'],
            ],
        ],
        'denyCallback' => function($rule, $action) {
            if (\Yii::$app->user->isGuest) {
                \Yii::$app->user->loginRequired();
                return null;
            }

            $urlManager = \Yii::$app->get('frontendUrlManager');
            return \Yii::$app->getResponse()->redirect($urlManager->createAbsoluteUrl(['/site/index']));
        }
    ],

    'params' => $params,
];
