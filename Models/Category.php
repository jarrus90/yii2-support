<?php

namespace jarrus90\Support\Models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use jarrus90\Multilang\Models\Language;

class Category extends ActiveRecord {

    use \jarrus90\Support\traits\KeyCodeValidateTrait;
    /**
     * @var Category 
     */
    protected $item;
    
    public function setItem($item){
        $this->item = $item;
    }

    public function behaviors() {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => ['lang_code', 'title'],
                'slugAttribute' => 'key',
                'ensureUnique' => true
            ],
        ];
    }

    /** @inheritdoc */
    public static function tableName() {
        return '{{%support_category}}';
    }

    public function scenarios() {
        return [
            'create' => ['key', 'title', 'description', 'lang_code'],
            'update' => ['key', 'title', 'description', 'lang_code'],
            'search' => ['key', 'title', 'lang_code'],
        ];
    }
    
    public function attributeLabels(){
        return [
            'key' => Yii::t('support', 'Key'),
            'title' => Yii::t('support', 'Title'),
            'description' => Yii::t('support', 'Description'),
            'lang_code' => Yii::t('support', 'Language'),
        ];
    }

    /**
     * Validation rules
     * @return array
     */
    public function rules() {
        return [
            'required' => [['title', 'description', 'lang_code'], 'required', 'on' => ['create', 'update']],
            'langExists' => ['lang_code', 'exist', 'targetClass' => Language::className(), 'targetAttribute' => 'code'],
            'safeSearch' => [['key', 'title', 'lang_code'], 'safe', 'on' => ['search']],
        ];
    }

    /** @inheritdoc */
    public function init() {
        parent::init();
        if ($this->item instanceof Category) {
            $this->id = $this->item->id;
            $this->setAttributes($this->item->getAttributes());
            $this->setIsNewRecord($this->item->getIsNewRecord());
        }
    }

    /**
     * Search categories list
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params) {
        $query = self::find();
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
        if ($this->load($params) && $this->validate()) {
            $query->andFilterWhere(['like', 'key', $this->key]);
            $query->andFilterWhere(['like', 'title', $this->title]);
            $query->andFilterWhere(['lang_code' => $this->lang_code]);
        }
        return $dataProvider;
    }
    
    public function delete() {
        if(parent::delete()){
            Page::updateAll(['category_key' => null], [
                'category_key' => $this->key,
                'lang_code' => $this->lang_code
            ]);
            return true;
        }
        return false;
    }

}
