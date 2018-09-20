<?php
namespace backend\models\partners;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
/**
 * Partners model
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $dateCreated
 * @property string $status
 */
class Partners extends \yii\db\ActiveRecord {
	
    /**
    * @inheritdoc
    */
    public static function tableName() {
        return 'partners';
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
				[['id','property_type','user_id'], 'integer'],
                [['title','documents','documents','photos','description','copy_of_deed','copy_of_licenses','copy_of_power_of_attorney','status','datetime'],'string'],
        ];
    }

    /**
    * @inheritdoc
    */
    public function attributeLabels() {
        return [
            'id'		 	=> 'ID',
            'property_type'	=> 'Property Type',
            'title' 		=> 'Title',
            'price' 		=> 'Price',
            'documents' 	=> 'Documents',
            'photos' 		=> 'Photos',
            'copy_of_deed' 		=> 'Copy Of Deed',
            'copy_of_licenses' 		=> 'Copy Of Licenses',
            'copy_of_power_of_attorney' 		=> 'Copy Of Power Of Attorney',
            'description' 	=> 'Description',
            'status'	    => 'Status',
            'datetime'	    => 'Datetime',
            'user_id'	    => 'User id',
        ];
    }

    public function getPropertytype() {
        return $this->hasOne(\common\models\PropertyTypes::className(), ['id' => 'property_type']);
    }
}
