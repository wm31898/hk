<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
	'defaultRoute' => 'pc/home',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'timeZone'=>'Asia/Shanghai',
    'modules' => require(__DIR__ . '/modules_config.php'),
    'components' => [
		'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://admin:password@192.168.1.235:27017/admin',//开发环境
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            //'hostname' => 'localhost',
            'hostname' => '192.168.1.235',//测试服务器
            'port' => 6379,
            'database' => 0,
        ],
        'session' => [
            //'class' => 'yii\redis\Session',
            // 'redis' => 'redis' // id of the connection application component
        ],
        
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'wufu',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            //'class' => 'yii\redis\Cache',
        ],
        'cacheRedis' => [
            'class' => 'yii\redis\Cache',
        ],
        'cacheMemcache' => [
            'class' => 'yii\caching\MemCache',
            'servers' => [
                [
                    'host' => '192.168.1.235',
                    'port' => 11211,
                    //'weight' => 100,
                ],
                /*[
                    'host' => '192.168.1.235',
                    'port' => 11211,
                    'weight' => 40,
                ],*/
            ],
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'except' => [
                        'yii\web\HttpException:404',
                    ],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require(__DIR__ . '/urlRules.php'),
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
