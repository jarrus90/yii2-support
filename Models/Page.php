<?php

namespace jarrus90\Support\Models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use jarrus90\Multilang\Models\Language;

class Page extends ActiveRecord {

    /**
     * @var Page 
     */
    public $item;

    /** @inheritdoc */
    public static function tableName() {
        return '{{%support_page}}';
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

    public function scenarios() {
        return [
            'create' => ['key', 'title', 'content', 'lang_code', 'category_key'],
            'update' => ['key', 'title', 'content', 'lang_code', 'category_key'],
            'search' => ['key', 'title', 'lang_code', 'category_key'],
        ];
    }
    
    public function attributeLabels(){
        return [
            'key' => Yii::t('support', 'Key'),
            'title' => Yii::t('support', 'Title'),
            'content' => Yii::t('support', 'Content'),
            'lang_code' => Yii::t('support', 'Language'),
        ];
    }

    /**
     * Validation rules
     * @return array
     */
    public function rules() {
        return [
            'required' => [['title', 'content', 'lang_code'], 'required', 'on' => ['create', 'update']],
            'langExists' => ['lang_code', 'exist', 'targetClass' => Language::className(), 'targetAttribute' => 'code'],
            'safeSearch' => [['key', 'title', 'lang_code'], 'safe', 'on' => ['search']],
            'categoryExists' => ['category_key', 'exist', 'targetClass' => Category::className(), 'targetAttribute' => 'key']
        ];
    }

    /** @inheritdoc */
    public function init() {
        parent::init();
        if ($this->item instanceof Page) {
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

}
