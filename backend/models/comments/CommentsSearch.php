<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace backend\models\comments;
use backend\models\comments\Comments;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * NewsSearch represents the model behind the search form about User.
 */
class CommentsSearch extends Model
{
    /** @var string */
    public $comment_id;
    public $user_id;
    public $post_id;
    public $comment_description;
    public $date_created;
    public $status;
    public $user;
    public $post;

    /** @inheritdoc */
    public function rules() {
        return [
         [['comment_id'], 'integer'],
          [['comment_description','date_created','status','user','post'], 'safe'],
        ];
    }

    /**
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
		$query = Comments::find();
		$query->joinWith(['user','post']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['comment_id' => SORT_DESC]]
        ]);
        $dataProvider->sort->attributes['user'] = [
                'asc' => ['user.firstname' => SORT_ASC],
                'desc' => ['user.firstname' => SORT_DESC],
        ];   
        $dataProvider->sort->attributes['post'] = [
                'asc' => ['tbl_posts.name' => SORT_ASC],
                'desc' => ['tbl_posts.name' => SORT_DESC],
        ];          

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->date_created != "") {
            $date = strtotime($this->date_created);
            $newdate = date('Y-m-d',$date);
            $query->andFilterWhere(['like', 'tbl_comments.date_created', $newdate]);
        }
		
			$query->andFilterWhere(['like', 'tbl_comments.comment_description', $this->comment_description])
			->andFilterWhere(['like', 'tbl_comments.status', $this->status])
			->andFilterWhere(['like', 'tbl_posts.name', $this->post])
			->andFilterWhere(['like', 'user.firstname', $this->user])
			->orFilterWhere(['like',  'user.lastname', $this->user]);
			
			
        return $dataProvider;
    }
}
