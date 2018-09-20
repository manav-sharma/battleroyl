<?php
namespace backend\models\faq;

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
class Faq extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_faq';
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
                [['name','description'], 'string'],
                [['name','description'], 'required'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id'		 	=> 'ID',
            'name' 			=> 'Title',
            'description' 	=> 'Description',
            'datetime' 		=> 'Datetime',
            'status'	    => 'Status',
        ];
    }
    public function getUser() {
        return $this->hasOne(\backend\models\users\Users::className(), ['id' => 'user_id']);
    }    
}
