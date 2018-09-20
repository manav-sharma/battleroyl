<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace backend\models\testimonial;
use backend\models\testimonial\Testimonial;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * NewsSearch represents the model behind the search form about User.
 */
class TestimonialSearch extends Model
{
    /** @var string */
    public $id;
    public $name;
    public $image;
    public $description;
    public $datetime;
    public $status;
    public $user;    

    /** @inheritdoc */
    public function rules() {
        return [
         [['id'], 'integer'],
          [['name','description','image','datetime','status','user'], 'safe'],
        ];
    }

    /**
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
		$query = Testimonial::find();
		$query->joinWith(['user']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
        $dataProvider->sort->attributes['user'] = [
                'asc' => ['user.firstname' => SORT_ASC],
                'desc' => ['user.firstname' => SORT_DESC],
        ];         

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->datetime != "") {
            $date = strtotime($this->datetime);
            $newdate = date('Y-m-d',$date);
            $query->andFilterWhere(['like', 'datetime', $newdate]);
        }
		if(strtolower($this->user) == 'admin') {
        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'tbl_testimonial.description', $this->description])
                ->andFilterWhere(['like', 'tbl_testimonial.status', $this->status])
                ->andFilterWhere(['like', 'tbl_testimonial.user_type', '1']);
			} else {
        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'tbl_testimonial.description', $this->description])
                ->andFilterWhere(['like', 'tbl_testimonial.status', $this->status])
					->andFilterWhere(['like', 'user.firstname', $this->user])
					->orFilterWhere(['like',  'user.lastname', $this->user]);	                			
			}
        return $dataProvider;
    }
}
