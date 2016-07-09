<?php

namespace jarrus90\Support\Controllers;

use Yii;
use jarrus90\Support\SupportFinder;
use jarrus90\Core\Web\Controllers\FrontController as Controller;
use jarrus90\Support\Models\Reply;

class RepliesController extends Controller {

    public function actionIndex() {
        $filterModel = Yii::createObject([
                    'class' => Reply::className(),
                    'scenario' => 'search'
        ]);
        $request = Yii::$app->request->get();
        $request[$filterModel->formName()]['parent_id'] = NULL;
        $dataProvider = $filterModel->search($request);
        
        return $this->render('index', [
                    'filterModel' => $filterModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSend() {
        $filterModel = Yii::createObject([
                    'class' => Reply::className(),
                    'scenario' => 'create'
        ]);
    }

}
