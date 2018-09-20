<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace backend\models\properties;
use backend\models\properties\Properties;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PropertiesSearch represents the model behind the search form about User.
 */
class PropertiesSearch extends Model {

    public $id;
    public $name;
    public $reference_number;
    public $property_type;
    public $property_for;
    public $country;
    public $region;
    public $city;
    public $build_year;
    public $area;
    public $rooms;
    public $floors;
    public $price;
    public $specification;
    public $description;
    public $property_right;
    public $added_by;
    public $user_id;
    public $expiry_date;
    public $created_at;
    public $status;
    public $usermembership;
    public $user;

    /** @inheritdoc */
    public function rules() {
        return [
         [['id'], 'integer'],
          [['name','reference_number','property_type','property_for','country','region','city','build_year','area','rooms','floors','price','specification','description','property_right','added_by','user_id','expiry_date','created_at','status','usermembership','user'], 'safe'],
        ];
    }

    /**
    * @param $params
    *
    * @return ActiveDataProvider
    */
    public function search($params) {
		$adminArr = Yii::$app->user->identity;
		if(isset($adminArr['admin_type']) && $adminArr['admin_type'] == '1') {
			$query = Properties::find();
		} else {
			$query = Properties::find()->where('price >= :price',[':price' => 4000]);
		}

		$query->joinWith(['usermembership','user']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $dataProvider->sort->attributes['usermembership'] = [
                'asc' => ['user_memberships.membership_id' => SORT_ASC],
                'desc' => ['user_memberships.membership_id' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['user'] = [
                'asc' => ['user.firstname' => SORT_ASC],
                'desc' => ['user.firstname' => SORT_DESC],
        ];        

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->created_at != "") {
            $date = strtotime($this->created_at);
            $newdate = date('Y-m-d',$date);
            $query->andFilterWhere(['like', 'properties.created_at', $newdate]);
        }

        if ($this->expiry_date != "") {
            $date = strtotime($this->expiry_date);
            $expiry_date = date('Y-m-d',$date);
            $query->andFilterWhere(['like', 'expiry_date', $expiry_date]);
        }
		if(strtolower($this->user) == 'admin' || strtolower($this->usermembership) == 'na') {
			$query->andFilterWhere(['like', 'name', $this->name])
					->andFilterWhere(['like', 'properties.status', $this->status])
					->andFilterWhere(['like', 'reference_number', $this->reference_number])
					->andFilterWhere(['like', 'added_by', '1']);
		} else {
			$query->andFilterWhere(['like', 'name', $this->name])
					->andFilterWhere(['like', 'properties.status', $this->status])
					->andFilterWhere(['like', 'reference_number', $this->reference_number])
					->andFilterWhere(['like', 'user_memberships.membership_id', $this->usermembership])
					->andFilterWhere(['like', 'user.firstname', $this->user])
					->orFilterWhere(['like',  'user.lastname', $this->user]);		
		}
		return $dataProvider;
    }
}
