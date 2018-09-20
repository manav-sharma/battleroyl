<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace backend\models\contestant;
use backend\models\contestant\Contestant;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;
/**
 * NewsSearch represents the model behind the search form about User.
 */
class ContestantSearch extends Model
{
    /** @var string */
    public $contestant_id;
    public $contestant_name;
    public $contestant_description;
    public $contestant_votes;
    public $date_created;
    public $date_updated;
    public $status;
    public $season_name;
    

    /** @inheritdoc */
    public function rules() {
        return [
         [['contestant_id'], 'integer'],
          [['contestant_name','contestant_description','date_created','status','contestant_votes','season_name'], 'safe'],
        ];
    }

    /**
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
		$query = Contestant::find();
		$query->joinWith(['seasons']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['contestant_id' => SORT_DESC]]
        ]);
        $dataProvider->sort->attributes['season_name'] = [
                'asc' => ['tbl_seasons.season_name' => SORT_ASC],
                'desc' => ['tbl_seasons.season_name' => SORT_DESC],
        ];         

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->date_created != "") {
            $date = strtotime($this->date_created);
            $newdate = date('Y-m-d',$date);
            $query->andFilterWhere(['like', 'tbl_contestant.date_created', $newdate]);
        }
		
        $query->andFilterWhere(['like', 'contestant_name', $this->contestant_name])
              ->andFilterWhere(['like', 'contestant_description', $this->contestant_description])
              ->andFilterWhere(['like', 'contestant_votes', $this->contestant_votes])
              ->andFilterWhere(['like', 'tbl_seasons.season_name', $this->season_name])
              ->andFilterWhere(['like', 'status', $this->status]);	                			
		echo  $query->createCommand()->RawSql; 		
        return $dataProvider;
    }
}
