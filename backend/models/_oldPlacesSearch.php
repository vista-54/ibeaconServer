<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Places;

/**
 * PlacesSearch represents the model behind the search form about `backend\models\Places`.
 */
class PlacesSearch extends Places
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'event_id'], 'integer'],
            [['name', 'crd_north', 'crd_south', 'crd_east', 'crd_west'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Places::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'event_id' => $this->event_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'crd_north', $this->crd_north])
            ->andFilterWhere(['like', 'crd_south', $this->crd_south])
            ->andFilterWhere(['like', 'crd_east', $this->crd_east])
            ->andFilterWhere(['like', 'crd_west', $this->crd_west]);

        return $dataProvider;
    }
}
