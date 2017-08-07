<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(dirname(dirname(__DIR__)) . '/vendor/autoload.php');
require(dirname(dirname(__DIR__)) . '/vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

$app = new yii\web\Application($config);

$app->run();
