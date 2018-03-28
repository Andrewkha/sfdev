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
            'datetimeFormat' => 'php:d.m.Y в H:i:s',
            'timeFormat'     => 'php:H:i:s',
            'nullDisplay' => '-'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache'
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
];
