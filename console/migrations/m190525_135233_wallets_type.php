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
            'short_name' => $this->string()->unique()->notNull(),
            'rates' => $this->float(),
            'update_timestamp' => $this->timestamp(),
            'is_update' => $this->boolean(),

        ]);

        $this->batchInsert('{{%wallets_type}}', ['id', 'short_name', 'type_name', 'rates'], [
            [1, 'USD', 'US Dollar', 1],
        ]);
        $this->batchInsert('{{%wallets_type}}', ['id', 'short_name', 'type_name', 'is_update'], [
            [2, 'BTC', 'Bitcoin', true],
            [3, 'ETH', 'Etherium', true],
            [4, 'DOGE', 'Dogecoin', true],
            [5, 'LTC', 'Litecoin', true],
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
