<?php

use yii\db\Migration;

/**
 * Class m190525_163523_wallets
 */
class m190525_163523_wallets extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('wallets', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'wallet_name' => $this->string()->notNull()->unique(),
            'currency' => $this->integer()->notNull(),
            'sum' => $this->float()->defaultValue(0),
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m190525_163523_wallets cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190525_163523_wallets cannot be reverted.\n";

        return false;
    }
    */
}
