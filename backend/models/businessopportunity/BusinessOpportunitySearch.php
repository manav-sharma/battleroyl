<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace backend\models\businessopportunity;
use backend\models\businessopportunity\BusinessOpportunity;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
* BusinessOpportunity represents the model behind the search form about Bussiness.
*/
class BusinessOpportunitySearch extends Model
{
    public $id;
    public $property_type;
    public $title;
    public $price;
    public $documents;
    public $photos;
    public $description;
    public $status;
    public $datetime;
    public $user_id;

    /** @inheritdoc */
    public function rules() {
        return [
         [['id','property_type','user_id'], 'integer'],
          [['title','price','documents','documents','photos','description','status','datetime','user_id'], 'safe'],
        ];
    }

    /**
    * @param $params
    *
    * @return ActiveDataProvider
    */
    public function search($params) {
		$query = BusinessOpportunity::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
        
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if ($this->datetime != "") {
            $date = strtotime($this->datetime);
            $newdate = date('Y-m-d',$date);
            $query->andFilterWhere(['like', 'datetime', $newdate]);
        }

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'user_id', $this->user_id])
                ->andFilterWhere(['like', 'status', $this->status]);
        return $dataProvider;
    }
}
