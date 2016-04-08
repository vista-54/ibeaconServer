<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Beacons;

/**
 * BeaconsSearch represents the model behind the search form about `common\models\Beacons`.
 */
class BeaconsSearch extends Beacons
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'location', 'eventId'], 'integer'],
            [['uuid', 'major', 'minor', 'lat', 'lng', 'msgForEnter', 'msgForExit', 'data'], 'safe'],
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
        $query = Beacons::find();

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
            'location' => $this->location,
            'eventId' => $this->eventId,
        ]);

        $query->andFilterWhere(['like', 'uuid', $this->uuid])
            ->andFilterWhere(['like', 'major', $this->major])
            ->andFilterWhere(['like', 'minor', $this->minor])
            ->andFilterWhere(['like', 'lat', $this->lat])
            ->andFilterWhere(['like', 'lng', $this->lng])
            ->andFilterWhere(['like', 'msgForEnter', $this->msgForEnter])
            ->andFilterWhere(['like', 'msgForExit', $this->msgForExit])
            ->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }
}
