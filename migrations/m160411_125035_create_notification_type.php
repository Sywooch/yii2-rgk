<?php

use yii\db\Migration;

class m160411_125035_create_notification_type extends Migration
{
    public function safeUp()
    {
        $this->createTable('notification_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()
        ]);

        $this->batchInsert('notification_type',['name'],[
            ['Email'],
            ['Browser']
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('notification_type');
    }
}
