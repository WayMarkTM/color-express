<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\entities\SectionDetail;

/**
 * SectionDetailSearch represents the model behind the search form about `app\models\entities\SectionDetail`.
 */
class SectionDetailSearch extends SectionDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'section_id', 'order'], 'integer'],
            [['formatted_text', 'image_path', 'link_to', 'link_text', 'link_icon'], 'safe'],
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
        $query = SectionDetail::find();

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
            'section_id' => $this->section_id,
            'order' => $this->order,
        ]);

        $query->andFilterWhere(['like', 'formatted_text', $this->formatted_text])
            ->andFilterWhere(['like', 'image_path', $this->image_path])
            ->andFilterWhere(['like', 'link_to', $this->link_to])
            ->andFilterWhere(['like', 'link_text', $this->link_text])
            ->andFilterWhere(['like', 'link_icon', $this->link_icon]);

        return $dataProvider;
    }
}
