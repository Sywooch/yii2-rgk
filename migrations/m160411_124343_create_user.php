<?php

use app\models\User;
use yii\db\Migration;

class m160411_124343_create_user extends Migration
{
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'auth_key' => $this->string(),
            'access_token' => $this->string(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
        ]);

        $this->batchInsert('user', ['username','email','password','auth_key','access_token'], [
                ['admin','admin@example.com',User::crypt('admin'),'!@#$%^&*(','ZXCVBNM<'],
                ['demo','demo@example.com',User::crypt('demo'),'*&^%$#@!','MNBVCXZ'],
            ]);
    }

    public function safeDown()
    {
        $this->dropTable('user');
    }
}
