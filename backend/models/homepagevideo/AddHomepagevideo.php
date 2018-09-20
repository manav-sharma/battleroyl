<?php
namespace backend\models\homepagevideo;
use backend\models\homepagevideo\Homepagevideo;
use yii\base\Model;
use yii\db\Expression;
use Yii;

/**
 * AddHomepagevideo
 */
class AddHomepagevideo extends Model {

    public $video_name;
    public $youtubevideolink;
    public $date_created;
    public $status;
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['video_name','youtubevideolink','status'], 'required'],
			['video_name', 'string', 'max' => 100],   
			['youtubevideolink', 'string', 'max' => 1000],   
        ];
    }

    /**
    * @inheritdoc
    */
    public function attributeLabels() {
        return [
            'video_name' 			=> 'Video Name',
            'youtubevideolink' 		=> 'Youtube Video Link',
            'date_created' 			=> 'Date',
            'status' 		    	=> 'Video Status',
        ];
    }
    
    public function addhomepagevideo() {
        if (!$this->validate()) {
            return null;
        }
        $homepagevideo 						= new Homepagevideo();
        $homepagevideo->video_name 			= $this->video_name;
        $homepagevideo->youtubevideolink    = $this->youtubevideolink;
        $homepagevideo->status 				= $this->status;
        $homepagevideo->date_created 		= new Expression('NOW()');
        $homepagevideo->date_updated 		= new Expression('NOW()');
        return $homepagevideo->save() ? $homepagevideo : null;
    }
}
