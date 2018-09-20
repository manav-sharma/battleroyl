<?php
namespace backend\models\comments;
use backend\models\comments\Comments;
use yii\base\Model;
use Yii;

/**
 * AddComments
 */
class AddComments extends Model {

    public $name;
    public $image;
    public $description;
    public $datetime;
    public $status;
    
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name','description'], 'required'],
			['name', 'string', 'max' => 100],   
			['description', 'string', 'max' => 1000],   
        ];
    }

    /**
    * @inheritdoc
    */
    public function attributeLabels() {
        return [
            'name' 			=> 'Name',
            //'image' 		=> 'Image',
            'description' 	=> 'Description',
            'datetime' 		=> 'Date',
            'status' 		=> 'Status',
        ];
    }
    
    public function addcomments() {
        if (!$this->validate()) {
            return null;
        }
        $comments 				= new Comments();
        $comments->name 			= $this->name;
        $comments->description   = $this->description;
       // $comments->image 		= $this->image;
        $comments->status 		= $this->status;
        $comments->user_type 	= '1';
        //echo'<pre>'; print_r($service); exit();
        return $comments->save() ? $comments : null;
    }
}
