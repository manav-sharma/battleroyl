<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace backend\models\seasons;
use backend\models\seasons\Seasons;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * NewsSearch represents the model behind the search form about User.
 */
class SeasonsSearch extends Model
{
    /** @var string */
    public $season_name;
    public $season_year;
    public $season_venue;
    public $date_created;
    public $status;  

    /** @inheritdoc */
    public function rules() {
        return [
          [['season_name','season_year','season_venue','date_created','status'], 'safe'],
        ];
    }

    /**
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
		$query = Seasons::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['season_id' => SORT_DESC]]
        ]);
        
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        if ($this->date_created != "") {
            $date = strtotime($this->date_created);
            $newdate = date('Y-m-d',$date);
            $query->andFilterWhere(['like', 'date_created', $newdate]);
        }
        $query->andFilterWhere(['like', 'season_name', $this->season_name])
              ->andFilterWhere(['like', 'season_year', $this->season_year])
              ->andFilterWhere(['like', 'season_venue', $this->season_venue])
              ->andFilterWhere(['like', 'status', $this->status]);	                			
			
        return $dataProvider;
    }
}
