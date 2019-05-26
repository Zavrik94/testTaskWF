<?php

use yii\db\Migration;

/**
 * Class m190525_135233_wallets_type
 */
class m190525_135233_wallets_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%wallets_type}}', [
           'id' => $this->primaryKey(),
           'type_name' => $this->string()->unique(),
           'short_name' => $this->string()->unique()->notNull()
        ]);

        $this->batchInsert('{{%wallets_type}}', ['id', 'short_name', 'type_name'], [
            [1, 'USD', 'US Dollar'],
            [2, 'BTC', 'Bitcoin'],
            [3, 'ETH', 'Etherium'],
            [4, 'DOGE', 'Dogecoin'],
            [5, 'LTC', 'Litecoin'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%wallets_type}}');
    }
}
