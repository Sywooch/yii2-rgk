<?php

namespace app\models;

use app\components\NotificationBehavior;
use app\components\NotificationEvent;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 */
class Article extends \yii\db\ActiveRecord
{
    const EVENT_NEW_ARTICLE = "new_article";
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            NotificationBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'text'], 'required'],
            [['text'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'text' => 'Text',
        ];
    }

    /**
     * @return string first 50 symbols of article text
     */
    public function getShortText(){
        return substr($this->text,0,50);
    }

    /**
     * Get URL to view this article
     * @return string
     */
    public function getUserViewUrl(){
        return Url::to(['article/user-view', 'id' => $this->id],true);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        
        if($insert){
            $this->trigger(self::EVENT_NEW_ARTICLE, new NotificationEvent());
        }
    }
}
