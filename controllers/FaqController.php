<?php

namespace jarrus90\Support\controllers;

use Yii;
use jarrus90\Support\SupportFinder;
use jarrus90\Core\Web\Controllers\FrontController as Controller;

class FaqController extends Controller {

    /**
     * @var SupportFinder 
     */
    protected $finder;

    /**
     * @param string  $id
     * @param BaseModule $module
     * @param SupportFinder  $finder
     * @param array   $config
     */
    public function __construct($id, $module, SupportFinder $finder, $config = []) {
        $this->finder = $finder;
        parent::__construct($id, $module, $config);
    }

    public function actionPage($key) {
        $lang = Yii::$app->request->get('lang', Yii::$app->language);
        $page = $this->finder->findPage([
            'key' => $key,
            'lang_code' => $lang
        ])->one();
        return $this->render('page', [
            'page' => $page
        ]);
    }

}
