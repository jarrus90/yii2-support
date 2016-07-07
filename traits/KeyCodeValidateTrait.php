<?php

namespace jarrus90\Support\traits;

use yii\validators\ExistValidator;
use jarrus90\Support\Module;
use jarrus90\Multilang\Models\Language;

/**
 * Trait ModuleTrait
 * @property-read Module $module
 * @package jarrus90\Support\traits
 */
trait KeyCodeValidateTrait {

    public function validateKeyCodePair($attribute) {
        $existValidator = \Yii::createObject([
            'class' => ExistValidator::className(),
            'targetClass' => Language::className(),
            'targetAttribute' => 'code'
        ]);

        $errorLangExists = null;
        $existValidator->validate($this->lang_code, $errorLangExists);
        if (!empty($errorLangExists)) {
            $this->addError('lang_code', $errorLangExists);
        } else {
            if (($testItem = $this->findOne([
                        'key' => $this->key,
                        'lang_code' => $this->lang_code,
                    ])) && $testItem->id != $this->id) {
                $this->addError($attribute, \Yii::t('support', 'Key must be unique for selected language'));
            }
        }
    }

}
