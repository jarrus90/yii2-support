<?php

return [
    'id' => 'yii2-support-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'jarrus90\Multilang\Bootstrap',
        'jarrus90\User\Bootstrap',
        'jarrus90\Support\Bootstrap',
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => 'jarrus90\Core\Console\MigrateController',
            'migrationPath' => '@baseApp/migrations'
        ],
    ],
    'aliases' => [
        '@baseApp' => dirname(dirname(__FILE__)),
        '@jarrus90/Multilang' => VENDOR_DIR . '/jarrus90/yii2-multilang',
        '@jarrus90/User' => VENDOR_DIR . '/jarrus90/yii2-user',
        '@jarrus90/Support' => dirname(dirname(dirname(__DIR__))),
        '@tests' => dirname(dirname(__DIR__)),
    ],
    'components' => [
        'log'   => null,
        'cache' => null,
        'db'    => require __DIR__ . '/db.php',
    ],
];
