<?php
namespace backend\models\homepagevideo;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Document model
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $dateCreated
 * @property string $status
 */
class Homepagevideo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_homepagevideo';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'datetime',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['video_name','youtubevideolink'], 'string'],
                [['video_name','youtubevideolink','status'], 'required'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'home_video_id'		 	=> 'ID',
            'video_name' 			=> 'Video Name',
            'youtubevideolink' 		=> 'Youtube Video Link',
            'date_created' 			=> 'Date Created',
            'status'	   			=> 'Status',
        ];
    }
    public function getUser() {
        return $this->hasOne(\backend\models\users\Users::className(), ['id' => 'user_id']);
    }    
}
