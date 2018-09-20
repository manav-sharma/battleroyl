<?php
namespace backend\models\businessopportunity;

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
class BusinessOpportunity extends \yii\db\ActiveRecord {
	
    /**
    * @inheritdoc
    */
    public static function tableName() {
        return 'business_opportunities';
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
                [['title','documents','documents','photos','description','status'],'string'],
               // [['title','price','description','user_id'], 'required'],
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
            'description' 	=> 'Description',
            'status'	    => 'Status',
            'datetime'	    => 'Datetime',
            'user_id'	    => 'user_id',
        ];
    }
}
