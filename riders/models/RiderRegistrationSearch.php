<?php

namespace riders\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use riders\models\RiderRegistration;

/**
 * RiderRegistrationSearch represents the model behind the search form of `riders\models\RiderRegistration`.
 */
class RiderRegistrationSearch extends RiderRegistration
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'Vehicle', 'Status'], 'integer'],
            [['FirstName', 'LastName', 'VehicleRegistration', 'Email', 'PhoneNumber', 'IdentificationNumber'], 'safe'],
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
        $query = RiderRegistration::find()->orderBy(['ID'=>SORT_DESC]);

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
            'Vehicle' => $this->Vehicle,
            'Status' => $this->Status,
        ]);

        $query->andFilterWhere(['like', 'FirstName', $this->FirstName])
            ->andFilterWhere(['like', 'LastName', $this->LastName])
            ->andFilterWhere(['like', 'VehicleRegistration', $this->VehicleRegistration])
            ->andFilterWhere(['like', 'Email', $this->Email])
            ->andFilterWhere(['like', 'PhoneNumber', $this->PhoneNumber])
            ->andFilterWhere(['like', 'IdentificationNumber', $this->IdentificationNumber]);

        return $dataProvider;
    }
}
