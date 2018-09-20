<?php
namespace backend\models\posts;

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
class Posts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_posts';
    }
    
    /**
     * @inheritdoc
     */
   /* public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'datecreated',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
        ];
    }
*/
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['name','description','youtubevideolink'], 'string'],
                [['name','description'], 'required'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id'		 		=> 'ID',
            'name' 				=> 'Title',
            'image'				=> 'Image',
            'description' 		=> 'Description',
            'youtubevideolink' 	=> 'Yotube Video Link',
            'datecreated' 		=> 'Date Created',
            'dateupdated' 		=> 'Date Updated',
            'status'	   		=> 'Status',
        ];
    }
    public function getUser() {
        return $this->hasOne(\backend\models\users\Users::className(), ['id' => 'user_id']);
    }    
}
