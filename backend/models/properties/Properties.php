<?php
namespace backend\models\properties;

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
class Properties extends \yii\db\ActiveRecord
{
    /**
    * @inheritdoc
    */
    public static function tableName() {
        return 'properties';
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
                [['name','specification','description','status'], 'string'],
                [['name','reference_number','property_for','build_year','specification','property_right'], 'required'],
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

    public function getUsermembership() {
        return $this->hasOne(\common\models\Usermemberships::className(), ['user_id' => 'user_id']);
    }
    public function getUser() {
        return $this->hasOne(\backend\models\users\Users::className(), ['id' => 'user_id']);
    }
    public function getCountryname() {
        return $this->hasOne(\common\models\Country::className(), ['id' => 'country']);
    }
    public function getRegionname() {
        return $this->hasOne(\common\models\State::className(), ['id' => 'region']);
    }
    public function getCityname() {
        return $this->hasOne(\common\models\City::className(), ['id' => 'city']);
    }    
}
