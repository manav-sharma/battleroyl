<?php
namespace backend\models\advertisements;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
/**
 * Service model
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $dateCreated
 * @property string $status
 */
class Advertisement extends \yii\db\ActiveRecord
{
    /**
    * @inheritdoc
    */
    public static function tableName() {
        return 'advertisements';
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
    public function rules() {
        return [
				[['user_id','membership_id'], 'integer'],
                [['name','description','start_date','end_date'], 'string'],
                [['name','description','advertisement_image','start_date','end_date','user_id'], 'required'],
        ];
    }

    /**
    * @inheritdoc
    */
    public function attributeLabels() {
        return [
            'id'		 	=> 'ID',
            'name' 			=> 'Name',
            'description' 	=> 'Description',
            'start_date' 	=> 'Start date',
            'end_date' 		=> 'End date',
            'user_id' 		=> 'User Id',
            'status'	    => 'Status',
        ];
    }
 
    public function getUser() {
        return $this->hasOne(\backend\models\users\Users::className(), ['id' => 'user_id']);
    }
    public function getEmail() {
        return $this->hasOne(\backend\models\users\Users::className(), ['id' => 'user_id']);
    }
    public function getPhone() {
        return $this->hasOne(\backend\models\users\Users::className(), ['id' => 'user_id']);
    }    
    public function getPackage() {
        return $this->hasOne(\backend\models\memberships\Package::className(), ['id' => 'membership_id']);
    }    
    
}
