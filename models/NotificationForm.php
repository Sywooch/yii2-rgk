<?php
/**
 * Decorator class for saving and updating Notification from Notification CRUD
 */
namespace app\models;


class NotificationForm extends Notification{

    /**
     * @inheritdoc
     */
    public function rules(){
        return array_merge(parent::rules(),[
            [['notType'], 'default'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if($this->to_all_users){
            $this->to_user_id = null;
        }
        return parent::beforeSave($insert); 
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        /**
         * Saving all notification types 
         */
        if(!$this->hasErrors()){
            NotificationRefType::deleteAll(['notification_id' => $this->id]);
            foreach($this->getNotType() as $type_id){
                (new NotificationRefType([
                    'notification_id' => $this->id,
                    'notification_type_id' => $type_id,
                ]))->save();
            }
        }
    }
}