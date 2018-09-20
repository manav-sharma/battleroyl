<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace backend\models\advertisements;
use backend\models\advertisements\Advertisement;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
* AdvertisementsSearch represents the model behind the search form about User.
*/
class AdvertisementSearch extends Model
{
    public $id;
    public $name;
    public $description;
    public $start_date;
    public $end_date;
    public $user_id;
    public $user;
    public $email;
    public $phone;
    public $date_created;
    public $status; 

    /** @inheritdoc */
    public function rules() {
        return [
         [['id','user_id'], 'integer'],
          [['name','description','start_date','end_date','user_id','user','email','phone','status','date_created'], 'safe'],
        ];
    }

    /**
    * @param $params
    *
    * @return ActiveDataProvider
    */
    public function search($params) {
		$query = Advertisement::find();
		$query->joinWith(['user','email','phone']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $dataProvider->sort->attributes['user'] = [
                'asc' => ['user.firstname' => SORT_ASC],
                'desc' => ['user.firstname' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['email'] = [
                'asc' => ['user.email' => SORT_ASC],
                'desc' => ['user.email' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['phone'] = [
                'asc' => ['user.phone' => SORT_ASC],
                'desc' => ['user.phone' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->date_created != "") {
            $date = strtotime($this->date_created);
            $newdate = date('Y-m-d',$date);
            $query->andFilterWhere(['like', 'advertisements.date_created', $newdate]);
        }

        if ($this->end_date != "") {
            $date = strtotime($this->end_date);
            $end_date = date('Y-m-d',$date);
            $query->andFilterWhere(['like', 'end_date', $end_date]);
        }

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'advertisements.status', $this->status])
				->andFilterWhere(['like', 'user.email', $this->email])
				->andFilterWhere(['like', 'user.phone', $this->phone])
                ->andFilterWhere(['like', 'user.firstname', $this->user])
				->orFilterWhere(['like',  'user.lastname', $this->user]);				
        return $dataProvider;
    }
}
