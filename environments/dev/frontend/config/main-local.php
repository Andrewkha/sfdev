<?php

$config = [
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['modules']['debug']['allowedIPs'] = ['*'];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

$config['components']['reCaptcha'] = [
    'name' => 'reCaptcha',
    'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
    'siteKey' => '6LfyxkkUAAAAAEFkDslIk8VmPYWI2ZCItwCJz5P2',
    'secret' => '6LfyxkkUAAAAAG3ftWcYnIAX3_NcdnfS44v94ocJ'
];

return $config;
