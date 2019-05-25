<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wallets".
 *
 * @property int $id
 * @property int $user_id
 * @property string $wallet_name
 * @property int $currency
 * @property double $sum
 */
class Wallets extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wallets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'wallet_name', 'currency'], 'required'],
            [['user_id', 'currency'], 'default', 'value' => null],
            [['user_id', 'currency'], 'integer'],
            [['sum'], 'number'],
            [['wallet_name'], 'string', 'max' => 255],
            [['wallet_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'wallet_name' => 'Wallet Name',
            'currency' => 'Currency',
            'sum' => 'Sum',
        ];
    }
}
