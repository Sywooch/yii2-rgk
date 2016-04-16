<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "sent_notification".
 *
 * @property integer $id
 * @property integer $notification_id
 * @property integer $from_user_id
 * @property integer $to_user_id
 * @property string $subject
 * @property string $text
 * @property integer $is_read
 * @property string $sent_at
 *
 * @property User $toUser
 * @property User $fromUser
 * @property Notification $notification
 */
class SentNotification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sent_notification';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notification_id', 'from_user_id', 'to_user_id', 'subject', 'text'], 'required'],
            [['notification_id', 'from_user_id', 'to_user_id', 'is_read'], 'integer'],
            [['text'], 'string'],
            [['sent_at'], 'safe'],
            [['subject'], 'string', 'max' => 255],
            [['to_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['to_user_id' => 'id']],
            [['from_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['from_user_id' => 'id']],
            [['notification_id'], 'exist', 'skipOnError' => true, 'targetClass' => Notification::className(), 'targetAttribute' => ['notification_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'notification_id' => 'Notification ID',
            'from_user_id' => 'From User ID',
            'to_user_id' => 'To User ID',
            'subject' => 'Subject',
            'text' => 'Text',
            'is_read' => 'Is Read',
            'sent_at' => 'Sent At',
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
    public function getFromUser()
    {
        return $this->hasOne(User::className(), ['id' => 'from_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotification()
    {
        return $this->hasOne(Notification::className(), ['id' => 'notification_id']);
    }
}
