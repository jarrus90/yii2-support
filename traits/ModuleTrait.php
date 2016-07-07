<?php

namespace jarrus90\Support\traits;

use jarrus90\Support\Module;

/**
 * Trait ModuleTrait
 * @property-read Module $module
 * @package jarrus90\Support\traits
 */
trait ModuleTrait {

    /**
     * @return Module
     */
    public function getModule() {
        return \Yii::$app->getModule('support');
    }

}
