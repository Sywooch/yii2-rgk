<?php

use yii\db\Migration;

class m160411_125303_create_event extends Migration
{
    public function safeUp()
    {
        $this->createTable('event', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'label' => $this->string()->notNull(),
            'paste_options' => $this->string()
        ]);

        $this->createIndex('idx-event-name', 'event', 'name',true);

        $this->batchInsert('event',['name','label','paste_options'],[
            ['sign_up','Sign up','{username},{siteName},{loginPage}'],
            ['new_article','New article','{username},{siteName},{articleName},{shortText},{articleLink}']
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('event');
    }
}
