<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Maincity;

/**
 * CountrySearch represents the model behind the search form about `\common\models\Country`.
 */
class MaincitySearch extends Maincity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['main_city_id'], 'integer'],
            [['main_city_name'], 'safe'],
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
       $query =  Maincity::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'main_city_id' => $this->main_city_id,
        ]);

        $query->andFilterWhere(['like', 'main_city_name', $this->main_city_name]);
      

        return $dataProvider;
    }
}
