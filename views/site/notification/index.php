<?php

/**
 * @var $this \yii\web\View
 * @var $dataProvider \yii\data\ActiveDataProvider
 */
use yii\widgets\ListView;

$this->registerCssFile('css/notificationList.css');
$this->registerJs('to_read_notice = \''.\yii\helpers\Url::to(['site/read-notification']).'\'');
$this->registerJsFile('js/notificationList.js',['depends' => 'app\assets\AppAsset']);
?>

<div class="row">
    <?= ListView::widget([
        'options' => [
            'tag' => 'div',
        ],
        'dataProvider' => $dataProvider,
        'emptyText' => '',
        'itemView' => '_item_list',
        'itemOptions' => [
            'tag' => false,
        ],
        'summary' => '',

        /* do not display {summary} */
        'layout' => '{items}{pager}',

        'pager' => [
            'firstPageLabel' => 'First',
            'lastPageLabel' => 'Last',
            'maxButtonCount' => 4,
            'options' => [
                'class' => 'pagination col-xs-12'
            ]
        ],

    ]);
    ?>
</div>