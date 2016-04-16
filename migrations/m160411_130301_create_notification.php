<?php

use yii\db\Migration;

class m160411_130301_create_notification extends Migration
{
    public function safeUp()
    {
        $this->createTable('notification', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer()->notNull(),
            'from_user_id' => $this->integer(),
            'to_user_id' => $this->integer(),
            'to_all_users' => $this->smallInteger()->defaultValue(0)->notNull(),
            'subject' => $this->string()->notNull(),
            'text' => $this->text()->notNull()
        ]);

        //create foreign key for column event_id
        $this->createIndex(
            'idx-notification-event_id',
            'notification',
            'event_id'
        );

        $this->addForeignKey(
            'fk-notification-event_id',
            'notification',
            'event_id',
            'event',
            'id',
            'CASCADE'
        );


        //create foreign key for column from_user_id
        $this->createIndex(
            'idx-notification-from_user_id',
            'notification',
            'from_user_id'
        );

        $this->addForeignKey(
            'fk-notification-from_user_id',
            'notification',
            'from_user_id',
            'user',
            'id',
            'CASCADE'
        );

        //create foreign key for column to_user_id
        $this->createIndex(
            'idx-notification-to_user_id',
            'notification',
            'to_user_id'
        );

        $this->addForeignKey(
            'fk-notification-to_user_id',
            'notification',
            'to_user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->batchInsert('notification',['event_id','from_user_id','to_user_id','to_all_users','subject','text'],[
            [1,1,null,0,'Добро пожаловать на {siteName}','Добро пожаловать на {siteName}, {username}.'],
            [2,1,null,1,'Новая статья','Уважаемый {username}. На сайте {siteName} добавлена новая статья "{articleName}”.

{shortText}... {articleLink}'],
        ]);

    }

    public function safeDown()
    {
        $this->dropTable('notification');
    }
}
