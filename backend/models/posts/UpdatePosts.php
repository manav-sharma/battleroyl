<?php
namespace backend\models\posts;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\base\Model;
use Yii;

/**
 * UpdateTestimonail
 */
class UpdatePosts extends Posts
{
    public $name;
    public $image;
    public $description;
    public $youtubeVideoLink;
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
    public static function findIdentity($id) {
        return static::findOne(['id' => $id]);
    }
    
    /**
    * update banner.
    *
    * @return User|null the saved model or null if saving fails
    */
	public function updateposts($id) {
        if (!$this->validate()) {
            return null;
        }
        $posts 				= Posts::findOne(['id' => $id]);
        if($this->image != '' ) 
		$posts->image 			   = $this->image;	        
        $posts->name 			   = $this->name;
        $posts->description   	   = $this->description;
        $posts->youtubevideolink   = $this->youtubevideolink;
        $posts->dateupdated 		= new Expression('NOW()');
        return $posts->save() ? $posts : null;
	}
}
