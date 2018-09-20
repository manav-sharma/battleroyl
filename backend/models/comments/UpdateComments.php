<?php
namespace backend\models\comments;
use backend\models\posts\Posts;
use backend\models\users\Users;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\Query;
use yii\base\Model;
use Yii;


class UpdateComments extends Comments
{
    public $user;
    public $post;
    public $comment_description;
   

	/**
    * @inheritdoc
    */
    public function rules() {
        return [
			 [['comment_description'], 'required'],
			 [['user','post'],'safe']		         
        ];
    }

    
    /**
    * @inheritdoc
    */
    public static function findIdentity($id) {
		//~ $query = Comments::find()
				//~ //->select('tbl_comments.*','user.firstname','tbl_posts.name')
				//~ -> leftJoin('user', 'user.id=tbl_comments.user_id')
				//~ ->leftJoin('tbl_posts', 'tbl_posts.id=tbl_comments.post_id')
				//~ ->where(['tbl_comments.comment_id' => $id])
				//~ ->one();
		return static::findOne(['comment_id' => $id]);		
		//$query =  Comments::findOne(['comment_id' => $id]);		
		//return $query;
    }
    
    
    public function postName($post_id) {	
		$query =  Posts::find()->where(['id' => $post_id])->one();	
		return $query; 
    }
    
    public function userName($user_id){	
		$query =  Users::find()->where(['id' => $user_id])->one();	
		return $query; 
    }

    
    /**
    * update banner.
    *
    * @return User|null the saved model or null if saving fails
    */
	public function updatecomments($id) {
        if (!$this->validate()) {
            return null;
        }
        $comments 	= Comments::findOne(['comment_id' => $id]);
        $comments->comment_description   = $this->comment_description;
        $comments->date_updated   =  new Expression('NOW()');
        return $comments->save() ? $comments : null;
	}
}
