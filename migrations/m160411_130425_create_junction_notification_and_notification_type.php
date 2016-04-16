<?php

use yii\db\Migration;

class m160411_130425_create_junction_notification_and_notification_type extends Migration
{
    public function safeUp()
    {
        $this->createTable('notification_ref_type', [
            'notification_id' => $this->integer()->notNull(),
            'notification_type_id' => $this->integer()->notNull(),
            'PRIMARY KEY(notification_id, notification_type_id)'
        ]);

        $this->createIndex('idx-notification_ref_type-notification_id', 'notification_ref_type', 'notification_id');
        $this->createIndex('idx-notification_ref_type-notification_type_id', 'notification_ref_type', 'notification_type_id');

        $this->addForeignKey('fk-notification_ref_type-notification_id', 'notification_ref_type', 'notification_id', 'notification', 'id', 'CASCADE');
        $this->addForeignKey('fk-notification_ref_type-notification_type_id', 'notification_ref_type', 'notification_type_id', 'notification_type', 'id', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('notification_ref_type');
    }
}
