<?php
namespace backend\models\comments;

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
class Comments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_comments';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date_created',
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
                [['comment_description'], 'string'],
                [['comment_description'], 'required'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'comment_id'   				=> 'ID',
            'user_id' 					=> 'User ID',
            'post_id' 					=> 'Post ID',
            'comment_description' 		=> 'Comment Description',
            'status'	   				=> 'Status',
            'date_created'				=> 'Date Added',
            'date_updated'				=> 'Date Updated'
        ];
    }
    public function getUser() {
        return $this->hasOne(\backend\models\users\Users::className(), ['id' => 'user_id']);
    }    
    
    public function getPost() {
        return $this->hasOne(\backend\models\posts\Posts::className(), ['id' => 'post_id']);
    }  
}
