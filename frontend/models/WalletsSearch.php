<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Wallets;

/**
 * WalletsSearch represents the model behind the search form of `frontend\models\Wallets`.
 */
class WalletsSearch extends Wallets
{
    /** @property string $short_name */
    public $short_name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'id_wallets_type'], 'integer'],
            [['wallet_name'], 'safe'],
            [['sum'], 'number'],
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
        $query = Wallets::find()
            ->joinWith(['walletsType wt'], false);

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
            'id_user' => $this->id_user,
            'id_wallets_type' => $this->id_wallets_type,
            'sum' => $this->sum,
        ]);

        $query->andFilterWhere(['ilike', 'wallet_name', $this->wallet_name]);

        return $dataProvider;
    }
}
