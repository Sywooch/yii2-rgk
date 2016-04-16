<?php

use yii\db\Migration;

class m160411_130934_create_sent_notification extends Migration
{
    public function safeUp()
    {
        $this->createTable('sent_notification', [
            'id' => $this->primaryKey(),
            'notification_id' => $this->integer()->notNull(),
            'from_user_id' => $this->integer()->notNull(),
            'to_user_id' => $this->integer()->notNull(),
            'subject' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
            'is_read' => $this->smallInteger()->defaultValue(0),
            'sent_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);



        //create foreign key for column notification_id
        $this->createIndex(
            'idx-sent_notification-notification_id',
            'sent_notification',
            'notification_id'
        );

        $this->addForeignKey(
            'fk-sent_notification-notification_id',
            'sent_notification',
            'notification_id',
            'notification',
            'id',
            'CASCADE'
        );


        //create foreign key for column from_user_id
        $this->createIndex(
            'idx-sent_notification-from_user_id',
            'sent_notification',
            'from_user_id'
        );

        $this->addForeignKey(
            'fk-sent_notification-from_user_id',
            'sent_notification',
            'from_user_id',
            'user',
            'id',
            'CASCADE'
        );

        //create foreign key for column from_user_id
        $this->createIndex(
            'idx-sent_notification-to_user_id',
            'sent_notification',
            'to_user_id'
        );

        $this->addForeignKey(
            'fk-sent_notification-to_user_id',
            'sent_notification',
            'to_user_id',
            'user',
            'id',
            'CASCADE'
        );
        
    }

    public function safeDown()
    {
        $this->dropTable('sent_notification');
    }
}
