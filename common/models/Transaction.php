<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property int $id_wallet_from
 * @property int $id_wallet_to
 * @property string $timestamp
 * @property string $sum_from
 * @property string $sum_to
 *
 * @property Wallets $walletFrom
 * @property Wallets $walletTo
 */
class Transaction extends \yii\db\ActiveRecord
{
    public $walletFrom;
    public $walletTo;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['walletFrom', 'walletTo', 'id_wallet_from', 'id_wallet_to', 'timestamp', 'sum_from', 'sum_to'], 'required'],
            [['id_wallet_from', 'id_wallet_to'], 'default', 'value' => null],
            [['id_wallet_from', 'id_wallet_to'], 'integer'],
            [['walletFrom', 'walletTo', 'timestamp'], 'safe'],
            [['sum_from', 'sum_to'], 'number'],
            [['id_wallet_from'], 'exist', 'skipOnError' => true, 'targetClass' => Wallets::className(), 'targetAttribute' => ['id_wallet_from' => 'id']],
            [['id_wallet_to'], 'exist', 'skipOnError' => true, 'targetClass' => Wallets::className(), 'targetAttribute' => ['id_wallet_to' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_wallet_from' => 'Id Wallet From',
            'id_wallet_to' => 'Id Wallet To',
            'timestamp' => 'Timestamp',
            'sum_from' => 'Sum From',
            'sum_to' => 'Sum To',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWalletFrom()
    {
        return $this->hasOne(Wallets::className(), ['id' => 'id_wallet_from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWalletTo()
    {
        return $this->hasOne(Wallets::className(), ['id' => 'id_wallet_to']);
    }
}
