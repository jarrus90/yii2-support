<?php

namespace jarrus90\Support;

use Yii;
use yii\base\Module as BaseModule;
use yii\helpers\ArrayHelper;

class Module extends BaseModule {

    /**
     * @var string The prefix for user module URL.
     *
     * @See [[GroupUrlRule::prefix]]
     */
    public $urlPrefix = 'support';

    /** @var array The rules to be used in URL management. */
    public $urlRules = [
        '<key:[A-Za-z0-9_-]+>' => 'front/page'
    ];
    public $filesUploadUrl = '@web/uploads/support';
    public $filesUploadDir = '@webroot/uploads/support';
    public $redactorConfig = [];
    public $useCommonStorage = false;

    public function init() {
        parent::init();
        $this->modules = [
            'redactor' => ArrayHelper::merge([
                'class' => 'jarrus90\Redactor\Module',
                'imageUploadRoute' => '/support/upload/image',
                'fileUploadRoute' => '/support/upload/file',
                'imageManagerJsonRoute' => '/support/upload/image-json',
                'fileManagerJsonRoute' => '/support/upload/file-json',
                'uploadUrl' => '@web/uploads/support'
                    ], $this->redactorConfig, [
                'uploadUrl' => $this->filesUploadUrl,
                'uploadDir' => $this->filesUploadDir,
            ]),
        ];
        if (!$this->get('storage', false)) {
            if ($this->useCommonStorage && ($storage = Yii::$app->get('storage', false))) {
                $this->set('storage', $storage);
            } else {
                $this->set('storage', [
                    'class' => 'creocoder\flysystem\LocalFilesystem',
                    'path' => $this->filesUploadDir
                ]);
            }
        }
    }

    public function getAdminMenu() {
        return [
            'support' => [
                'icon' => 'fa fa-fw fa-support',
                'label' => Yii::t('support', 'Support'),
                'position' => 30,
                'visible' => (Yii::$app->user->can('support_admin') || Yii::$app->user->can('support_publisher')),
                'items' => [
                    [
                        'label' => Yii::t('support', 'FAQ'),
                        'url' => ['/support/page/index'],
                        'visible' => Yii::$app->user->can('support_publisher')
                    ],
                ]
            ]
        ];
    }

}
