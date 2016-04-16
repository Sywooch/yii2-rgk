<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "notification".
 *
 * @property integer $id
 * @property integer $event_id
 * @property integer $from_user_id
 * @property integer $to_user_id
 * @property integer $to_all_users
 * @property string $subject
 * @property string $text
 *
 * @property User $toUser
 * @property Event $event
 * @property User $fromUser
 * @property NotificationRefType[] $notificationRefTypes
 * @property NotificationType[] $notificationTypes
 * @property SentNotification[] $sentNotifications
 */
class Notification extends \yii\db\ActiveRecord
{
    const TYPE_EMAIL = "1";
    const TYPE_BROWSER = "2";

    /**
     * @var $notType[] notification types ids attached to this notification
     */
    private $notType = false;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }
    

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'subject', 'text'], 'required'],
            [['event_id', 'from_user_id', 'to_user_id', 'to_all_users'], 'integer'],
            [['text'], 'string'],
            [['subject'], 'string', 'max' => 255],
            [['to_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['to_user_id' => 'id']],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::className(), 'targetAttribute' => ['event_id' => 'id']],
            [['from_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['from_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Event',
            'from_user_id' => 'From User',
            'to_user_id' => 'To User',
            'to_all_users' => 'To All Users',
            'subject' => 'Subject',
            'text' => 'Text',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToUser()
    {
        return $this->hasOne(User::className(), ['id' => 'to_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['id' => 'event_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromUser()
    {
        return $this->hasOne(User::className(), ['id' => 'from_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotificationRefTypes()
    {
        return $this->hasMany(NotificationRefType::className(), ['notification_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotificationTypes()
    {
        return $this->hasMany(NotificationType::className(), ['id' => 'notification_type_id'])->viaTable('notification_ref_type', ['notification_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSentNotifications()
    {
        return $this->hasMany(SentNotification::className(), ['notification_id' => 'id']);
    }

    /**
     * @param $value[] array of notification type ids
     */
    public function setNotType($value){
        $this->notType = $value;
    }

    /**
     * Get array of notification type ids
     * @return array
     */
    public function getNotType(){
        if($this->notType === false){
            $this->notType = ArrayHelper::getColumn($this->getNotificationTypes()->all(),'id');
        }

        return $this->notType;
    }

    /**
     * Check is notification has certain type (e.g. "Email", "Browser")
     * @param integer $type_id NotificationType ID
     * @return bool true if notification has type and
     * false otherwise.
     */
    public function hasType($type_id){
        return in_array($type_id,$this->getNotType());
    }


}
