<?php
/**
 * Behavior for notification. 
 */

namespace app\components;


use app\models\Article;
use app\models\Event;
use app\models\Notification;
use app\models\User;
use yii\base\Behavior;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class NotificationBehavior extends Behavior
{
    public function events(){
        return [
            User::EVENT_SIGN_UP        => 'onSignUp',
            Article::EVENT_NEW_ARTICLE => 'onNewArticle',
        ];
    }

    /**
     * This function handles Article::EVENT_NEW_ARTICLE. Select all event notices and send via NotificationSender
     * @param $event NotificationEvent
     */
    public function onNewArticle($event){
        
        (new NotificationSender([
            'notifications' => $this->getEventNotifications(Article::EVENT_NEW_ARTICLE),
            'paste_data' => [
                'siteName'      => Yii::$app->id,
                'articleName'   => $event->sender->name,
                'shortText'     => $event->sender->getShortText(),
                'articleLink'   => Html::a('читать далее',$event->sender->getUserViewUrl()),
            ],
        ]))->sendAll();
    }

    /**
     * This function handles User::EVENT_SIGN_UP. Select all event notices and send via NotificationSender
     * @param $event NotificationEvent
     */
    public function onSignUp($event){
        Yii::trace("onSignUp triggered"," Notification behavior");

        (new NotificationSender([
            'notifications' => $this->getEventNotifications(User::EVENT_SIGN_UP),
            'to_user_id' => $event->to_user_id,
            'paste_data' => [
                'siteName'  => Yii::$app->id,
                'loginPage' => Url::to(['site/login'],true),
            ],
        ]))->sendAll();
    }

    /**
     * Get notification models for given event
     * @param string $event_name ,for example Article::EVENT_NEW_ARTICLE
     * @return Notification[]
     */
    private function getEventNotifications($event_name){
        return Notification::find()->where([
            'event_id' => Event::find()->select('id')->where(['name' => $event_name])
        ])->all();
    }
}