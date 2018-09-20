<?php
namespace frontend\models;


use yii\base\Model;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Signup form
 */
class Comments extends \yii\db\ActiveRecord
{
   
    
    //~ 
	//~ public $comment_description;
	//~ public $user_id;
	//~ public $post_id;
    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_comments';
    }

    /**
     * @inheritdoc
     */

	public function rules() {
         return [
            [['comment_description'], 'required'],
			['comment_description', 'string', 'max' => 1000], 
			[['user_id','post_id' ],'safe'],   
        ];
    }
	
	
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
         return [
            'comment_description' 	=> 'Your Comment',

        ];
    }
  
    /**
     * signup user.
     *
     * @return User|null the saved model or null if saving fails
     */
      public function savedata() {
        if (!$this->validate()) {
            return null;
        }	
        $comments = new Comments();
        $comments->user_id 				= $this->user_id;
        $comments->post_id 				= $this->post_id;
        $comments->comment_description 	= $this->comment_description;
        $comments->status 				= '2';			
		$comments->date_created 		= new Expression('NOW()');		
        $comments->date_updated    		= new Expression('NOW()');
        
        //echo '<pre>'; print_r( $comments); die('c');
        
        return $comments->save() ? $comments : null;
    }
}
