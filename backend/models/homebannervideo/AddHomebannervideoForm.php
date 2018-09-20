<?php
namespace backend\models\homebannervideo;
use yii\db\Query;
use backend\models\homebannervideo\Homebannervideo;
use yii\base\Model;
use yii\db\Expression;
use Yii;

/**
 * AddHomebannervideoForm
 */
class AddHomebannervideoForm extends Model {

    public $video_banner_id;
    public $video_name;
    public $youtubevideolink;
    public $status;
    public $date_created;

    /**
     * @inheritdoc
     */
    public function rules() {
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
    public function attributeLabels() {
        return [
            'video_banner_id' => 'Video_id',
            'video_name' => 'Video Name',
            'youtubevideolink' => 'Video YoutubeLink',
            'status' => 'Status',
            'date_created' => 'Date',
        ];
    }

    /**
     * signup user.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup() {
        if (!$this->validate()) {
            return null;
        }

        ################## Add New Homebannervideo ##################
        $homebannervideo 						= new Homebannervideo();
        $homebannervideo->video_name 			= $this->video_name;
        $homebannervideo->youtubevideolink  	= $this->youtubevideolink;
        $homebannervideo->status                = '1';
        $homebannervideo->date_created			= new Expression('NOW()');
        return $homebannervideo->save() ? $homebannervideo : null;
        ##################################################
    }
    

    

}
