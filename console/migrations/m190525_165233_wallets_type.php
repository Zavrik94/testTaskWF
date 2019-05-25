<?php

use yii\db\Migration;

/**
 * Class m190525_165233_wallets_type
 */
class m190525_165233_wallets_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('wallets_type', [
           'id' => $this->primaryKey(),
           'type_name' => $this->string()->notNull(),
           'short_name' => $this->string(3)->unique()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m190525_165233_wallets_type cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190525_165233_wallets_type cannot be reverted.\n";

        return false;
    }
    */
}
