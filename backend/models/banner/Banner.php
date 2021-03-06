<?php
namespace backend\models\banner;

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
class banner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banner';
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
                [['description'], 'string'],
                [['title','description','bannerImage','banner_assign'], 'required'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'bannerImage' => 'Image',
            'banner_assign' => 'Assign Banner Image',
            'description' => 'Description',
            'status' => 'Status',
        ];

    }
    
    public function countBannerValues()
    {	
		$query =  Banner::find()->count();	
		return $query; 
    }
    
}
