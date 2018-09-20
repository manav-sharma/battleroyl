<?php
namespace backend\models\homebannervideo;
use yii\db\Expression;
use yii\db\Query;
use yii\base\Model;
use Yii;

/**
 * UpdateHomebannervideo
 */
class UpdateHomebannervideo extends Homebannervideo
{
    public $title;
    public $homebannervideoImage;
    public $description;
    public $dateCreated;
    public $homebannervideo_assign;
    public $status;
	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['video_banner_id'], 'integer'],
            [['youtubevideolink','video_name'], 'required'],   
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
    public static function findIdentity($id)
    {
        return static::findOne(['video_banner_id' => $id]);
    }
    
    /**
     * update homebannervideo.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function updateHomebannervideo($id)
    {
        if (!$this->validate()) {
            return null;
        }
        $homebannervideo = Homebannervideo::findOne(['video_banner_id' => $id]);
        $homebannervideo->video_name 			= $this->video_name;
        $homebannervideo->youtubevideolink  	= $this->youtubevideolink;
        $homebannervideo->dae_created = new Expression('NOW()');
        $homebannervideo->status 	    = '1';
        return $homebannervideo->save() ? $homebannervideo : null;
    }
      
     
}
