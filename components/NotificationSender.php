<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 13.04.2016
 * Time: 15:31
 */

namespace app\components;

use app\models\Notification;
use app\models\SentNotification;
use app\models\User;
use yii\base\Object;
use Yii;

class NotificationSender extends Object
{
    /**
     * @var $notifications Notification[]
     */
    public $notifications = [];
    public $from_user_id = null;
    public $to_user_id = null;
    public $paste_data = [];

    public function sendAll(){

        foreach($this->notifications as $notification){
            $notification = $this->prepareNotification($notification);
            $this->sendNotification($notification);
        }
    }

    /**
     * @param $notification Notification
     */
    public function prepareNotification($notification){
        if(empty($notification->from_user_id)) $notification->from_user_id = $this->from_user_id;
        if(empty($notification->to_user_id)) $notification->to_user_id = $this->to_user_id;

        $notification->subject = $this->prepareMessage($notification->subject, $this->paste_data);
        $notification->text = $this->prepareMessage($notification->text, $this->paste_data);
        return $notification;
    }

    /**
     * Replace placeholders like {name} by given values
     * @param string $message string to be changed
     * @param [] $paste_data array of pairs  "placeholder name" => "placeholder value"
     * @return string after replacing placeholder names by their values
     */
    public function prepareMessage($message, $paste_data){
        foreach ($paste_data as $key => $value){
            $message = str_replace("{".$key."}", $value, $message);
        }
        return $message;
    }

    /**
     * @param $notification Notification
     */
    public function sendNotification($notification){
        $send_email = $notification->hasType(Notification::TYPE_EMAIL);

        if($notification->to_all_users){
            $users_query = User::find()->where(["<>" , 'id', $notification->from_user_id ]);
        }else{
            $users_query = User::find()->where(['id' => $notification->to_user_id]);
        }

        /**
         * @var $users User[]
         */
        $users = $users_query->all();

        foreach ($users as $user){

            $subject = $this->prepareMessage($notification->subject,['username' => $user->username]);
            $text = $this->prepareMessage($notification->text,['username' => $user->username]);

            $sentNotification = new SentNotification([
                'notification_id' => $notification->id,
                'from_user_id' => $notification->from_user_id,
                'to_user_id' => $user->id,
                'subject' => $subject,
                'text' => $text,
            ]);
            $sentNotification->save();

            if($send_email){
                Yii::$app->mailer->compose()
                    ->setFrom($notification->fromUser->email)
                    ->setTo($user->email)
                    ->setSubject($subject)
                    ->setTextBody($text)
                    ->send();
            }

        }
    }
}