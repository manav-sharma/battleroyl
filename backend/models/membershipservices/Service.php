<?php
namespace backend\models\membershipservices;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * News model
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $dateCreated
 * @property string $status
 */
class Service extends \yii\db\ActiveRecord
{
    /**
    * @inheritdoc
    */
    public static function tableName() {
        return 'membership_services';
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
                [['name','description','allowed_service','service_type'], 'string'],
                [['name'], 'required'],
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
            'membership_id' 	=> 'membership_id',
            'datetime' 		=> 'Datetime',
            'status'	    => 'Status',
        ];
    }
    public function getPackage() {
        return $this->hasOne(\backend\models\memberships\Package::className(), ['id' => 'membership_id']);
    }        
}
