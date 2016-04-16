<?php

use yii\db\Migration;

class m160411_140059_create_article extends Migration
{
    public function safeUp()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'text' => $this->text()->notNull()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('article');
    }
}
