<?php

// Подключение общих настроек приложения
require dirname(dirname(__DIR__)) . "/common/config/main.php";

$frontend_params = require(__DIR__ . '/params.php');
$common_params = require dirname(dirname(__DIR__)) . "/common/config/params.php";

// Параметры приложения
$params = array_merge($frontend_params, $common_params);

// Параметры подключения к БД
$db = require(dirname(dirname(__DIR__)) . "/common/config/db.php");

$config = [
    'id' => 'yii2-gallery-frontend',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'controllerNamespace' => 'frontend\controllers',
    'bootstrap' => ['debug'],
    'modules' => [],
    'components' => [

        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'DbyXaDHQy1h7DQDdHj1KZvbRXNBIOGF7',
            'csrfParam' => '_csrf-frontend',
//            'baseUrl' => ''
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
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
        'db' => $db,

//        'urlManager' => [
//            'enablePrettyUrl' => true,
//            'showScriptName' => false,
//            'rules' => [
//                //...
//            ],
//        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
