<?php
namespace backend\models\homepagevideo;
use yii\base\Model;
use yii\db\Expression;
use Yii;


class UpdateHomepagevideo extends Homepagevideo
{
    public $video_name;
    public $youtubevideolink;
    public $date_updated;
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
    public static function findIdentity($id) {
        return static::findOne(['home_video_id' => $id]);
    }
    
    /**
    * update banner.
    *
    * @return User|null the saved model or null if saving fails
    */
	public function updatehomepagevideo($id) {
        if (!$this->validate()) {
            return null;
        }
        
        $homepagevideo 					    = Homepagevideo::findOne(['home_video_id' => $id]);
        $homepagevideo->video_name 			= $this->video_name;
        $homepagevideo->youtubevideolink  	= $this->youtubevideolink;
        $homepagevideo->status 				= $this->status;
        $homepagevideo->date_updated 		= new Expression('NOW()');
        return $homepagevideo->save() ? $homepagevideo : null;
	}
}
