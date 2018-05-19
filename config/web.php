<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$db1 = require __DIR__ . '/db1.php';


$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [

        'admin' => [

            'class' => 'app\modules\admin\Module',
            'layout' => 'admin',

        ],

    ],
    'components' => [
        'sms' => [
            'class' => 'lowbase\sms\Sms',
            'cascade' => true,
            'services' => [
                // http://iqsms.ru/api/api_rest/
                'iqsmsc_ru' => [
                    'class' => 'lowbase\sms\services\IqmscRuService',
                    'login' => '',
                    'password' => '',
                    'order' => 2,
                ],
//                // http://iqsms.ru/api/api_rest/
//                'iqsmsc_ru_2' => [
//                    'class' => 'lowbase\sms\services\IqmscRuService',
//                    'login' => '...',
//                    'password' => '...',
//                    'order' => 3,
//                ],
                // http://smsc.ru/api/
//                'smsc_ru' => [
//                    'class' => 'lowbase\sms\services\SmscRuService',
//                    'login' => '...',
//                    'password' => '...',
//                    'order' => 1
//                ],
            ]
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => md5('asdFw42Q'),
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
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
                ],
            ],
        ],
        'db' => $db,

        'db1' => $db1,
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
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
