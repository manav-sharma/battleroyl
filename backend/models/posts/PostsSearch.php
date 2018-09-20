<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace backend\models\posts;
use backend\models\posts\Posts;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * NewsSearch represents the model behind the search form about User.
 */
class PostsSearch extends Model
{
    /** @var string */
    public $id;
    public $name;
    public $image;
    public $description;
    public $youtubeVideoLink;
    public $datecreated;
    public $status;
    public $user;    

    /** @inheritdoc */
    public function rules() {
        return [
         [['id'], 'integer'],
          [['name','description','image','datecreated','status','user'], 'safe'],
        ];
    }

    /**
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
		$query = Posts::find();
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

        if ($this->datecreated != "") {
            $date = strtotime($this->datecreated);
            $newdate = date('Y-m-d',$date);
            $query->andFilterWhere(['like', 'datecreated', $newdate]);
        }
		if(strtolower($this->user) == 'admin') {
        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'tbl_posts.description', $this->description])
                ->andFilterWhere(['like', 'tbl_posts.image', $this->image])
                ->andFilterWhere(['like', 'tbl_posts.status', $this->status])
                ->andFilterWhere(['like', 'tbl_posts.user_type', '1']);
			} else {
        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'tbl_posts.description', $this->description])
                ->andFilterWhere(['like', 'tbl_posts.image', $this->image])
                ->andFilterWhere(['like', 'tbl_posts.status', $this->status])
				->andFilterWhere(['like', 'user.firstname', $this->user])
				->orFilterWhere(['like',  'user.lastname', $this->user]);	                			
			}
        return $dataProvider;
    }
}
