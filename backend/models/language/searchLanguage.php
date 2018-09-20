<?php

namespace backend\models\language;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\language\languages;

/**
 * searchPage represents the model behind the search form about `backend\models\page`.
 */
class searchLanguage extends languages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'short_name', 'status', 'dateCreated'], 'safe'],
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
        $query = languages::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        
        if ($this->dateCreated != "") {
            $date = strtotime($this->dateCreated);
            $newdate = date('Y-m-d',$date);
            $query->andFilterWhere(['like', 'dateCreated', $newdate]);
        } 
		
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'short_name', $this->short_name])
            ->andFilterWhere(['like', 'status', $this->status]);
        
	return $dataProvider;
    }
    
}
