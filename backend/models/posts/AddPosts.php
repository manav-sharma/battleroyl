<?php
namespace backend\models\posts;
use backend\models\posts\Posts;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\base\Model;
use Yii;

/**
 * AddPosts
 */
class AddPosts extends Posts {

    public $name;
    public $image;
    public $description;
    public $youtubevideolink;
    public $datecreated;
    public $dateupdated;
    public $status;
    
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name','description'], 'required'],
			['name', 'string', 'max' => 100],   
			['description', 'string', 'max' => 1000],  
			['youtubevideolink','custom_function_validation'], 
			
        ];
        
    }
    
	public function custom_function_validation($attribute){
		if ((preg_match('@^(http://(?:www\\.)?youtube.com/)(watch\\?v=|v/)([a-zA-Z0-9_]*)@', $this->$attribute, $match)) || (preg_match('@^(https://(?:www\\.)?youtube.com/)(watch\\?v=|v/)([a-zA-Z0-9_]*)@', $this->$attribute, $match))) {
				return true;
			}  else {
				$this->addError($attribute, 'Please enter valid youtube link.');
				return false;
			}
	}
    /**
    * @inheritdoc
    */
    public function attributeLabels() {
        return [
            'name' 				=> 'Name',
            'image' 			=> 'Image',
            'description' 		=> 'Description',
            'youtubevideolink' 	=> 'Yotube Video Link',
            'datecreated' 		=> 'Date Created',
            'dateupdated' 		=> 'Date Updated',
            'status' 			=> 'Status',
        ];
    }
    
    public function addposts() {
        if (!$this->validate()) {
            return null;
        }
        $posts 						= new Posts();
        $posts->name 				= $this->name;
        $posts->description  		= $this->description;
        $posts->youtubevideolink    = $this->youtubevideolink;
        $posts->image 				= $this->image;
        $posts->status 				= $this->status;
        $posts->user_type 			= '1';
        $posts->datecreated 		= new Expression('NOW()');
        $posts->dateupdated 		= new Expression('NOW()');
        return $posts->save() ? $posts : null;
    }
}
