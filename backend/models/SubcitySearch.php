<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Subcity;
use yii\db\Query;
/**
 * SubcitySearch represents the model behind the search form about `\common\models\Subcity`.
 */
class SubcitySearch extends Subcity
{
	
	
	public $sub_city_id;
    public $sub_city_name;
    public $main_city_name;
  
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sub_city_id','sub_city_name','main_city_name'], 'safe'],
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
		
		$query =  Subcity::find();
		$query->joinWith(['maincities']);
		//echo $query->createCommand()->sql; 
		
		/*	$query = new Query;
			$sql = 'SELECT a.city_id AS "city_id",a.city_name AS "Sub City Name",b.city_id AS "parent_id",b.city_name AS "Parent City Name" FROM tbl_cities a, tbl_cities b WHERE a.parentCity_id = b.city_id';
			$model = Subcity::findBySql($sql)->asArray()->all();
			$model = Subcity::findBySql($sql)->all();
			echo '<pre>'; print_r($model);	die;
			echo $query->createCommand($sql); 
		*/
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['attributes' => ['sub_city_id','sub_city_name','main_city_name']]
        ]);
        
   
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }     
        $query->andFilterWhere(['like', 'sub_city_id', $this->sub_city_id]);
        $query->andFilterWhere(['like', 'tbl_main_cities.main_city_name', $this->main_city_name]);
        $query->andFilterWhere(['like', 'sub_city_name', $this->sub_city_name]);
	
        return $dataProvider;
    }
}
