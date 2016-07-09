<?php

namespace jarrus90\Support\Controllers;

use Yii;
use yii\base\Module as BaseModule;
use jarrus90\Support\SupportFinder;
use jarrus90\Core\Web\Controllers\AdminCrudAbstract;
use yii\filters\AccessControl;

class RepliesAdminController extends AdminCrudAbstract {

    protected $modelClass = 'jarrus90\Support\Models\Reply';
    protected $formClass = 'jarrus90\Support\Models\Reply';
    protected $searchClass = 'jarrus90\Support\Models\Reply';

    protected function getItem($id) {
        
    }

}
