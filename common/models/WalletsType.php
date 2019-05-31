<?php

namespace common\models;

use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\base\ErrorException;

/**
 * This is the model class for table "wallets_type".
 *
 * @property int $id
 * @property string $type_name
 * @property string $short_name
 *
 * @property Wallet[] $wallets
 */
class WalletsType extends \yii\db\ActiveRecord
{
    public static $types = [
        'USD' => 1,
        'BTC' => 2,
        'ETH' => 3,
        'DOGE' => 4,
        'LTC' => 5,
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%wallets_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rates'], 'number'],
            [['type_name', 'short_name'], 'string', 'max' => 255],
            [['short_name'], 'unique'],
            [['type_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_name' => 'Type Name',
            'short_name' => 'Short Name',
            'rates' => 'Rates',
            'update_timestamp' => 'Update Timestamp',
            'is_update' => 'Enable update'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWallets()
    {
        return $this->hasMany(Wallet::className(), ['id_wallets_type' => 'id']);
    }

    public static function getTypesArray() {
        return array_flip(static::$types);
    }

    public static function convertByTypes(int $idTypeFrom, int $idTypeTo, float $sum) {
        Yii::$app->runAction('/coinlayer');

        $curFrom = WalletsType::findOne(['id' => $idTypeFrom])->rates;
        $curTo = WalletsType::findOne(['id' => $idTypeTo])->rates;

        return $sum * $curFrom / $curTo;
    }

    public static function convertByWalletsIds(int $idWalletFrom, int $idWalletTo, float $sumFrom) {
        Yii::$app->runAction('/coinlayer');

        $curFrom = Wallets::findOne(['id' => $idWalletFrom])->getWalletsType()->one()->rates;
        $curTo = Wallets::findOne(['id' => $idWalletTo])->getWalletsType()->one()->rates;

        return $sumFrom * $curFrom / $curTo;
    }
}
