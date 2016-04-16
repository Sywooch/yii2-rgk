<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Event;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchNotification */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notifications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Notification', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'contentOptions' => ['style'=>'width: 50px;']
            ],
            [
                'attribute' => 'event_id',
                'content'=>function($data){
                    return $data->event->label;
                },
                'filter' => ArrayHelper::map(Event::find()->all(),'id','label'),
            ],
            [
                'attribute' => 'from_user_id',
                'content'=>function($data){
                    $user = $data->fromUser;
                    return $user ? $user->username : '';
                },
                'filter' => ArrayHelper::map(User::find()->all(),'id','username'),
            ],
            [
                'attribute' => 'to_user_id',
                'content'=>function($data){
                    $user = $data->toUser;
                    return $user ? $user->username : '';
                },
                'filter' => ArrayHelper::map(User::find()->all(),'id','username'),
            ],
            'to_all_users',
             'subject',
             'text:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
