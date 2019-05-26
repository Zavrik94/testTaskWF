<?php

use yii\db\Migration;

/**
 * Class m190526_174404_newUsers
 */
class m190526_174404_newUsers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%user}}', ['username', 'auth_key', 'password_hash', 'email', 'status', 'created_at', 'updated_at'], [
            ['test', Yii::$app->security->generateRandomString(), Yii::$app->getSecurity()->generatePasswordHash('testtest'), 'test@test.com', '10', '1558893209', '1558893209'],
            ['user', Yii::$app->security->generateRandomString(), Yii::$app->getSecurity()->generatePasswordHash('useruser'), 'user@user.com', '10', '1558893219', '1558893219'],
            ['admin', Yii::$app->security->generateRandomString(), Yii::$app->getSecurity()->generatePasswordHash('asdasd'), 'admin@admin.com', '10', '1558893239', '1558893239'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%user}}', ['username' => ['test', 'user', 'admin']]);
    }
}
