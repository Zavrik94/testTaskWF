<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Transaction;

/**
 * TransactionSearch represents the model behind the search form of `common\models\Transaction`.
 */
class TransactionSearch extends Transaction
{
    public $email_from;
    public $email_to;
    public $cur_from;
    public $cur_to;
    public $sender_cname;
    public $recipient_cname;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_wallet_from', 'id_wallet_to'], 'integer'],
            [[
                'timestamp',
                'email_from',
                'email_to',
                'cur_from',
                'cur_to',
                'sender_cname',
                'recipient_cname'],
            'safe'],
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
        $pageSize = 50;

        $query = Transaction::find()
            ->joinWith([
                'walletFrom wf' => function($q) {
                    $q->joinWith(['user uf', 'walletsType wtf']);
                },
                'walletTo wt' => function($q) {
                    $q->joinWith(['user ut', 'walletsType wtt']);
                },
            ])
            ->where(['uf.email' => Yii::$app->user->identity->email])
            ->orderBy(['id' => SORT_DESC])
            ->limit($pageSize)
        ;

        //'$my_wallet_name $my_wallet_id($my_wallet_cur:$my_wallet_sum)'
        //'$send_email $send_wallet_id($send_wallet_cur)'

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => $pageSize],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'transaction.id' => $this->id,
            'id_wallet_from' => $this->id_wallet_from,
            'id_wallet_to' => $this->id_wallet_to,
            'timestamp' => $this->timestamp,
            'sum_from' => $this->sum_from,
            'sum_to' => $this->sum_to,
        ]);
//        $query->andFilterWhere('ilike', 'uf.email', $this->email_from);

        return $dataProvider;
    }
}
