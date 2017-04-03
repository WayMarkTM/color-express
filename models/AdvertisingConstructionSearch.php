<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\entities\AdvertisingConstruction;

/**
 * AdvertisingConstructionSearch represents the model behind the search form about `app\models\entities\AdvertisingConstruction`.
 */
class AdvertisingConstructionSearch extends AdvertisingConstruction
{
    public $fromDate;
    public $toDate;
    public $showOnlyFreeConstructions;

    public $address;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'has_traffic_lights', 'size_id', 'type_id'], 'integer'],
            [['name', 'nearest_locations', 'address', 'traffic_info'], 'safe'],
            [['price'], 'number'],
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
     * @param Boolean $showOnlyPublished
     *
     * @return ActiveDataProvider
     */
    public function search($params, $showOnlyPublished)
    {
        $query = AdvertisingConstruction::find();

        if ($showOnlyPublished) {
            $query = $query->where(['=', 'is_published', '1']);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 7,
            ],
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
            'has_traffic_lights' => $this->has_traffic_lights,
            'size_id' => $this->size_id,
            'price' => $this->price,
            'type_id' => $this->type_id,
        ])->andFilterWhere(['like', 'address', $this->address]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'nearest_locations', $this->nearest_locations])
            ->andFilterWhere(['like', 'traffic_info', $this->traffic_info]);

        return $dataProvider;
    }
}
