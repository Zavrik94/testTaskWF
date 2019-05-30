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
    public function safeUp()
    {
        $this->createTable('{{%wallets}}', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull(),
            'wallet_name' => $this->string(),
            'id_wallets_type' => $this->integer()->notNull(),
            'sum' => $this->float()->defaultValue(0),
        ]);

        $this->addForeignKey('fk_wallets_used_id','{{%wallets}}', 'id_user', '{{%user}}', 'id');
        $this->addForeignKey('fk_wallet_wtype_id','{{%wallets}}', 'id_wallets_type', '{{%wallets_type}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%wallets}}');
    }
}
