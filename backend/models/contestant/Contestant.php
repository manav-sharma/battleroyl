<?php
namespace backend\models\contestant;
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
class Contestant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_contestant';
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
                [['contestant_name','contestant_description'], 'string'],
                [['contestant_name','contestant_description'], 'required'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'contestant_id'		 			=> 'Contestant ID',
            'contestant_name' 				=> 'Contestant Name',
            'contestant_description' 		=> 'Contestant Description',
            'status'	    				=> 'Status',
            'date_created' 					=> 'Datetime',
           
        ];
    }
    
    //~ public function getPost() {
        //~ return $this->hasOne(\backend\models\posts\Posts::className(), ['id' => 'post_id']);
    //~ }  

    public function getSeasons() {
        $values =  $this->hasOne(\backend\models\seasons\Seasons::className(), ['season_id' => 'season_id']);
        //echo '<pre>'; print_r( $values);
        return $values; 
    } 
    
    public function updateContestant($contestant_id,$contestant_votes,$season_id){
		$contestant = Contestant::findOne(['contestant_id' => $contestant_id,'season_id'=>$season_id]); 
		if(!empty($contestant)) {
			$contestant->contestant_votes   	 = $contestant_votes;
			$contestant->date_updated 		      =  new Expression('NOW()');
			if($contestant->save()) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
    
  
}
