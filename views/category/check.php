<?php

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * @var View $this
 */
$this->beginContent('@jarrus90/Support/views/_adminFaqLayout.php');
$this->title = Yii::t('support', 'Check inexistent categories variants');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (count($list) == 0) { ?>
    <div class="callout callout-success">
        <h4><?= $this->title; ?></h4>
        <p><?= Yii::t('support', 'Everything is filled, good work'); ?></p>
    </div>
<?php } else {
    ?>
    <dl class="dl-horizontal">
        <?php foreach ($list AS $key => $item) { ?>
            <dt><?= $key; ?></dt>
            <dd>
                <ul>
                    <?php foreach ($item AS $klang => $lang) { ?>
                        <li><?= Html::a($lang, Url::toRoute(['create', 'lang_code' => $klang, 'key' => $key])); ?></li>
                    <?php } ?>
                </ul>
            </dd>
        <?php } ?>
    </dl>
<?php } ?>
<?php $this->endContent() ?>
