<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "wallets".
 *
 * @property int $id
 * @property int $id_user
 * @property string $wallet_name
 * @property int $id_wallets_type
 * @property double $sum
 */
class Wallets extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%wallets}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'id_wallets_type'], 'required'],
            [['id_user', 'id_wallets_type'], 'default', 'value' => null],
            [['id_user', 'id_wallets_type'], 'integer'],
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
            'id_user' => 'User ID',
            'wallet_name' => 'Wallet Name',
            'id_wallets_type' => 'Currency',
            'sum' => 'Sum',
        ];
    }

    public static function createNewWallet($id_wallets_type, $name = '', $user = null) {
        $newWallet = new Wallets();

        if (!$user) {
            $user = Yii::$app->user->id;
        }
        $newWallet->id_wallets_type = $id_wallets_type;
        $newWallet->wallet_name = $name;
        $newWallet->id_user = $user;

        if ($newWallet->save() === false) {
            throw new \yii\base\Exception('Failed to create wallet');
        }
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    public function getWalletsType() {
        return $this->hasOne(WalletsType::className(), ['id' => 'id_wallets_type']);
    }

    public static function getAllWallets() {
        return static::find()
            ->joinWith('user u')
            ->asArray()
            ->all();
    }
}
