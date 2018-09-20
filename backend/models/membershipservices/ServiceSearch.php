<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace backend\models\membershipservices;
use backend\models\membershipservices\Service;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * NewsSearch represents the model behind the search form about User.
 */
class ServiceSearch extends Model
{
    public $id;
    public $name;
    public $allowed_service;
    public $service_type;
    public $number_of_access;
    public $package;
    public $description;
    public $datetime;
    public $status;

    /** @inheritdoc */
    public function rules() {
        return [
         [['id'], 'integer'],
          [['name','description','allowed_service','number_of_access','service_type','package','datetime','status'], 'safe'],
        ];
    }

    /**
    * @param $params
    *
    * @return ActiveDataProvider
    */
    public function search($params,$d=0) {
		if($d > 0) {
			$query = Service::find()->where(['membership_id' => $d]);
		} else {
			$query = Service::find();
		}
		$query->joinWith(['package']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $dataProvider->sort->attributes['package'] = [
                'asc' => ['package.name' => SORT_ASC],
                'desc' => ['package.name' => SORT_DESC],
        ];
        
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->datetime != "") {
            $date = strtotime($this->datetime);
            $newdate = date('Y-m-d',$date);
            $query->andFilterWhere(['like', 'membership_services.datetime', $newdate]);
        }

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'allowed_service', $this->allowed_service])
                ->andFilterWhere(['like', 'number_of_access', $this->number_of_access])
                ->andFilterWhere(['like', 'service_type', $this->service_type])
                ->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'membership_services.status', $this->status]);
        return $dataProvider;
    }
}
