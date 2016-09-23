<?php

return [
    'basePath' => dirname(__DIR__),
    'language' => 'en-US',
    'aliases' => [
        '@jarrus90/Multilang' => VENDOR_DIR . '/jarrus90/yii2-multilang',
        '@jarrus90/User' => VENDOR_DIR . '/jarrus90/yii2-user',
        '@jarrus90/Support' => dirname(dirname(dirname(__DIR__))),
        '@tests' => dirname(dirname(__DIR__)),
        '@vendor' => VENDOR_DIR,
    ],
    'bootstrap' => [
        'jarrus90\Support\Bootstrap',
    ],
    'modules' => [
        'user' => [
            'class' => 'jarrus90\User\Module'
        ],
        'multilang' => [
            'class' => 'jarrus90\Multilang\Module'
        ],
        'support' => [
            'class' => 'jarrus90\Support\Module'
        ],
    ],
    'params' => [],
];