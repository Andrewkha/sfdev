<?php
return [
    'language' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'name' => 'Сайт Спортивных Прогнозов',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'formatter' => [
            'dateFormat'     => 'php:d.m.Y',
            'datetimeFormat' => 'php:d.m.Y H:i',
            'timeFormat'     => 'php:H:i',
            'nullDisplay' => '-'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache'
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'info'],
                    'categories' => ['Notification*'],
                ],
            ],
        ],
    ],
];
