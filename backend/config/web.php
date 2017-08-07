<?php

// Подключение общих настроек приложения
require dirname(dirname(__DIR__)) . "/common/config/main.php";

$common_params = require dirname(dirname(__DIR__)) . "/common/config/params.php";
$backend_params = require(__DIR__ . '/params.php');

// Параметры приложения
$params = array_merge($common_params, $backend_params);

// Параметры подключения к БД
$db = require(dirname(dirname(__DIR__)) . "/common/config/db.php");

$config = [
    'id' => 'yii2-gallery-backend',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['debug'],
    'modules' => [],
    'components' => [

        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'DbyXaDHQy1h7DQDdHj1KZvbRXNBIOGF7',
            'csrfParam' => '_csrf-backend',
//            'baseUrl' => ''
        ],
        'user' => [
            'identityClass' => 'backend\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
//            'loginUrl' => ['site/login', 'ref' => 1]
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
//        'mailer' => [
//            'class' => 'yii\swiftmailer\Mailer',
//            'useFileTransport' => true,
//        ],
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
