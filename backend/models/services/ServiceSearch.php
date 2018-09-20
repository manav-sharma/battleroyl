<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace backend\models\services;
use backend\models\services\Service;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
* ServiceSearch represents the model behind the search form about User.
*/
class ServiceSearch extends Model
{
    public $id;
    public $name;
    public $image;
    public $description;
    public $datetime;
    public $status;

    /** @inheritdoc */
    public function rules() {
        return [
         [['id'], 'integer'],
          [['name','description','image','datetime','status'], 'safe'],
        ];
    }

    /**
    * @param $params
    *
    * @return ActiveDataProvider
    */
    public function search($params) {
		$query = Service::find();
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
                ->andFilterWhere(['like', 'status', $this->status]);
        return $dataProvider;
    }
}
