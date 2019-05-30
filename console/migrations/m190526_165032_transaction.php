<?php

use yii\db\Migration;

/**
 * Class m190526_165032_transaction
 */
class m190526_165032_transaction extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transaction}}', [
            'id' => $this->primaryKey(),
            'id_wallet_from' => $this->integer()->notNull(),
            'id_wallet_to' => $this->integer()->notNull(),
            'timestamp' => $this->timestamp()->notNull(),
            'sum_from' => $this->float()->notNull(),
            'sum_to' => $this->float()->notNull(),
        ]);

        $this->addForeignKey('fk_id_wallet_from', '{{%transaction}}', 'id_wallet_from', '{{%wallets}}', 'id');
        $this->addForeignKey('fk_id_wallet_to', '{{%transaction}}', 'id_wallet_to', '{{%wallets}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%transaction}}');
    }
}
