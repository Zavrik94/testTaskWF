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
    public $emailFrom;
    public $emailTo;
    public $shortNameFrom;
    public $shortNameTo;
    public $nameFrom;
    public $nameTo;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_wallet_from', 'id_wallet_to'], 'integer'],
            [['emailFrom', 'emailTo'], 'string'],
            [['shortNameFrom', 'shortNameTo', 'nameFrom', 'nameTo'], 'string'],
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
            ->select('
                transaction.*,
                uf.email as emailFrom,
                ut.email as emailTo,
                wtt.short_name as shortNameTo,
                wtf.short_name as shortNameFrom,
                wf.wallet_name as nameFrom,
                wt.wallet_name as nameTo
            ')
            ->joinWith([
                'walletFrom wf' => function($q) {
                    $q->joinWith(['user uf', 'walletsType wtf']);
                },
                'walletTo wt' => function($q) {
                    $q->joinWith(['user ut', 'walletsType wtt']);
                },
            ])
            ->where(['or',
                ['wf.id_user' => Yii::$app->user->id],
                ['wt.id_user' => Yii::$app->user->id],
            ])
            ->asArray()
            ->limit($pageSize)
        ;

        //'$my_wallet_name $my_wallet_id($my_wallet_cur:$my_wallet_sum)'
        //'$send_email $send_wallet_id($send_wallet_cur)'

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => $pageSize],
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id' => [
                    'asc' => ['id' => SORT_ASC],
                    'desc' => ['id' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'emailFrom' => [
                    'asc' => ['emailFrom' => SORT_ASC],
                    'desc' => ['emailFrom' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'emailTo' => [
                    'asc' => ['emailTo' => SORT_ASC],
                    'desc' => ['emailTo' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'shortNameFrom' => [
                    'asc' => ['shortNameFrom' => SORT_ASC],
                    'desc' => ['shortNameFrom' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'shortNameTo' => [
                    'asc' => ['shortNameTo' => SORT_ASC],
                    'desc' => ['shortNameTo' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'sum_from' => [
                    'asc' => ['sum_from' => SORT_ASC],
                    'desc' => ['sum_from' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'sum_to' => [
                    'asc' => ['sum_to' => SORT_ASC],
                    'desc' => ['sum_to' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'nameFrom' => [
                    'asc' => ['nameFrom' => SORT_ASC],
                    'desc' => ['nameFrom' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'nameTo' => [
                    'asc' => ['nameTo' => SORT_ASC],
                    'desc' => ['nameTo' => SORT_DESC],
                    'default' => SORT_ASC
                ],
            ],
            'defaultOrder' => [
                'id' => SORT_DESC
            ]
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
            'sum_from' => $this->sum_from,
            'sum_to' => $this->sum_to,
        ]);

        $query->andFilterWhere(['ilike', 'ut.email', $this->emailTo])
            ->andFilterWhere(['ilike', 'uf.email', $this->emailFrom])
            ->andFilterWhere(['ilike', 'wtt.short_name', $this->shortNameTo])
            ->andFilterWhere(['ilike', 'wtf.short_name', $this->shortNameFrom])
            ->andFilterWhere(['ilike', 'wt.wallet_name', $this->nameTo])
            ->andFilterWhere(['ilike', 'wf.wallet_name', $this->nameFrom])
        ;

        return $dataProvider;
    }
}
