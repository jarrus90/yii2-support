<?php

/**
 * @var $this yii\web\View
 */
use yii\bootstrap\Nav;
?>
<?=
Nav::widget([
    'options' => [
        'class' => 'nav-tabs'
    ],
    'items' => [
        [
            'label' => Yii::t('support', 'Pages'),
            'url' => ['/support/page/index'],
            'active' => (Yii::$app->controller instanceof jarrus90\Support\Controllers\PageController),
            'visible' => Yii::$app->user->can('support_publisher')
        ],
        [
            'label' => Yii::t('support', 'Categories'),
            'url' => ['/support/category/index'],
            'active' => (Yii::$app->controller instanceof jarrus90\Support\Controllers\CategoryController),
            'visible' => Yii::$app->user->can('support_publisher')
        ]
    ],
]);
?>