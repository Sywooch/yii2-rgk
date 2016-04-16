<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notification_ref_type".
 *
 * @property integer $notification_id
 * @property integer $notification_type_id
 *
 * @property NotificationType $notificationType
 * @property Notification $notification
 */
class NotificationRefType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification_ref_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notification_id', 'notification_type_id'], 'required'],
            [['notification_id', 'notification_type_id'], 'integer'],
            [['notification_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => NotificationType::className(), 'targetAttribute' => ['notification_type_id' => 'id']],
            [['notification_id'], 'exist', 'skipOnError' => true, 'targetClass' => Notification::className(), 'targetAttribute' => ['notification_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'notification_id' => 'Notification ID',
            'notification_type_id' => 'Notification Type ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotificationType()
    {
        return $this->hasOne(NotificationType::className(), ['id' => 'notification_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotification()
    {
        return $this->hasOne(Notification::className(), ['id' => 'notification_id']);
    }
}
