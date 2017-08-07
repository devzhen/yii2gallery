<?php

// Подключение общих настроек приложения
require dirname(dirname(__DIR__)) . "/common/config/main.php";

$console_params = require(__DIR__ . '/params.php');
$common_params = require dirname(dirname(__DIR__)) . "/common/config/params.php";

// Параметры приложения
$params = array_merge($console_params, $common_params);

// Параметры подключения к БД
$db = require(dirname(dirname(__DIR__)) . "/common/config/db.php");

$config = [
    'id' => 'yii2-gallery-console',
    'basePath' => dirname(__DIR__),
    'runtimePath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => dirname(__DIR__) . '/migrations'
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;