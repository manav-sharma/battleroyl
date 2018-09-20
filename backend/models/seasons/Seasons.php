<?php
namespace backend\models\seasons;
use yii\db\Query;
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
class Seasons extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_seasons';
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
                [['season_name','season_description'], 'string'],
                [['season_name','season_description','season_venue'], 'required'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'season_id'		 		=> 'ID',
            'season_name' 			=> 'Season Name',
            'season_year'			=> 'year',
            'seasonCity_Id' 		=> 'Season City',
            'season_description' 	=> 'Description',
            'season_venue' 			=> 'Venue',
            'status'	   			=> 'Status',
            'datecreated' 			=> 'Date Created',
        ];
    }
    
    public function getSeasonName($season_id){
		return static::findOne(['season_id' => $season_id]);
	}




    
    /*public function getUser() {
        return $this->hasOne(\backend\models\users\Users::className(), ['id' => 'user_id']);
    }*/    
}
