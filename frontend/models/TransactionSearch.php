<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Transaction;

/**
 * TransactionSearch represents the model behind the search form of `common\models\Transaction`.
 */
class TransactionSearch extends Transaction
{
    public $my_wallet_name;
    public $my_wallet_id;
    public $my_wallet_sum;
    public $my_wallet_cur;

    public $send_email;
    public $send_wallet_cur;
    public $send_wallet_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_wallet_from', 'id_wallet_to'], 'integer'],
            [['timestamp'], 'safe'],
            [['sum_from', 'sum_to'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Transaction::find()
            ->joinWith([
            'walletFrom wf' => function($q) {
                $q->joinWith('User uf', false);
            },
            'walletTo wt' => function($q) {
                $q->joinWith('User ut', false);
            }], false);

        //'$my_wallet_name $my_wallet_id($my_wallet_cur:$my_wallet_sum)'
        //'$send_email $send_wallet_id($send_wallet_cur)'

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_wallet_from' => $this->id_wallet_from,
            'id_wallet_to' => $this->id_wallet_to,
            'timestamp' => $this->timestamp,
            'sum_from' => $this->sum_from,
            'sum_to' => $this->sum_to,
        ]);

        return $dataProvider;
    }
}
