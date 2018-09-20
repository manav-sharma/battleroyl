<?php
namespace backend\models\homebannervideo;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Banner model
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $dateCreated
 * @property string $status
 */
class homebannervideo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_homebannervideo';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'dateCreated',
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
                [['video_banner_id'], 'integer'],
				[['youtubevideolink'], 'required'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'video_banner_id' => 'Video_id',
            'youtubevideolink' => 'Video YoutubeLink',
            'status' => 'Status',
        ];

    }
    
    public function countHomebannervideoValues()
    {	
		$query =  Homebannervideo::find()->count();	
		return $query; 
    }
    
}
