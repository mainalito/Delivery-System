<?php

namespace riders\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use riders\models\OrderAddress;

/**
 * OrderAddressSearch represents the model behind the search form of `riders\models\OrderAddress`.
 */
class OrderAddressSearch extends OrderAddress
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'order_id'], 'integer'],
            [['address', 'County', 'Subcounty', 'PhoneNumber'], 'safe'],
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
        $query = OrderAddress::find();

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
            'ID' => $this->ID,
            'order_id' => $this->order_id,
        ]);

        $query->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'County', $this->County])
            ->andFilterWhere(['like', 'Subcounty', $this->Subcounty])
            ->andFilterWhere(['like', 'PhoneNumber', $this->PhoneNumber]);

        return $dataProvider;
    }
}
