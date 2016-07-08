<?php

namespace jarrus90\Support\Controllers;

use Yii;
use yii\base\Module as BaseModule;
use jarrus90\Support\SupportFinder;
use jarrus90\Core\Web\Controllers\AdminCrudAbstract;
use yii\filters\AccessControl;

class CategoryController extends AdminCrudAbstract {

    /**
     * @var SupportFinder 
     */
    protected $finder;
    protected $modelClass = 'jarrus90\Support\Models\Category';
    protected $formClass = 'jarrus90\Support\Models\Category';
    protected $searchClass = 'jarrus90\Support\Models\Category';

    /** @inheritdoc */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['support_publisher'],
                    ],
                ],
            ],
        ];
    }

    /**
     * List of available upload actions
     * 
     * @return array
     */
    public function actions() {
        return [
            'check' => [
                'class' => '\jarrus90\Support\Controllers\CheckAction',
                'query' => $this->finder->getCategoryQuery()
            ],
        ];
    }

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
    
    public function beforeAction($action) {
        if(parent::beforeAction($action)) {
            Yii::$app->view->params['breadcrumbs'][] = Yii::t('support', 'Support');
            Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t('support', 'FAQ'), 'url' => ['index']];
            Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t('support', 'Categories'), 'url' => ['index']];
            return true;
        }
        return false;
    }

    public function actionCreate() {
        Yii::$app->view->title = Yii::t('support', 'Create category');
        return parent::actionCreate();
    }

    public function actionUpdate($id) {
        $item = $this->getItem($id);
        Yii::$app->view->title = Yii::t('support', 'Edit category {title}', ['title' => $item->title]);
        return parent::actionUpdate($id);
    }

    protected function getItem($id) {
        $item = $this->finder->findCategory(['id' => $id])->one();
        if ($item) {
            return $item;
        } else {
            throw new \yii\web\NotFoundHttpException(Yii::t('support', 'The requested category does not exist'));
        }
    }

    protected function createModelParams() {
        $params = parent::createModelParams();
        $params['key'] = Yii::$app->request->get('key', NULL);
        $params['lang_code'] = Yii::$app->request->get('lang_code', NULL);
        return $params;
    }
    
    public function actionList(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $items = $this->finder->findCategory(['lang_code' => Yii::$app->request->get('lang')])->asArray()->all();
        $result = [];
        foreach($items AS $item){
            $result[] = [
                'id' => $item['key'],
                'text' => $item['title'],
            ];
        }
        return ['results' => $result];
    }

}
