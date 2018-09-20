<?php
namespace backend\models\seasons;
use backend\models\seasons\Seasons;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\base\Model;
use yii\db\Query;
use Yii;

/**
 * AddSeasons
 */
class AddSeasons extends Seasons {

    public $season_name;
    public $season_year;
    public $season_description;
    public $season_venue;
    public $datecreated;
    public $status;
    public $seasonMainCity_Id;
    public $seasonSubCity_Id;
    public $cityHiddenValue;
    
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['season_name','season_year','season_description','seasonMainCity_Id','status'], 'required'],
			['season_name', 'string', 'max' => 100],   
			['season_description', 'string', 'max' => 1000],
			[['seasonSubCity_Id'], 'required',  'when' => function($model) {
            return $model->cityHiddenValue == 2;
            }, 'whenClient' => "function (attribute, value) {
                return $('#addseasons-cityhiddenvalue').val() == '2';
            }"],  
            ['season_venue','custom_function_validation'],          
			//[['season_venue','status'],'safe'],  
        ];
        
    }
    
     public function custom_function_validation($attribute){
		//echo '<pre>'; print_r($this->$attribute); die('f');
		if (empty($this->$attribute)) {
			$this->addError($attribute, 'Season Venue can not be blank.');
				return false;
			}  else {
				
				return true;
			}
	}
    
    /**
    * @inheritdoc
    */
    public function attributeLabels() {
        return [
            'season_id'		 		=> 'ID',
            'season_name' 			=> 'Season Name',
            'season_year'			=> 'Season Year',
            'seasonMainCity_Id' 	=> 'Season Main City',
            'seasonSubCity_Id' 		=> 'Season Sub City',
            'season_description' 	=> 'Season Description',
            'season_venue' 			=> 'Season Venue',
            'status'	   			=> 'Status',
            'datecreated' 			=> 'Date Created',
        ];
    }
    
    public function addseasons() {
        if (!$this->validate()) {
            return null;
        }
        $postVal = Yii::$app->request->post('AddSeasons');
        
        if(!empty($this->seasonSubCity_Id)) {
			$subcityId = $this->seasonSubCity_Id;
		} else {
			$subcityId = '0';
		}
        
        $seasons 						= new Seasons();
        $seasons->season_name 			= $this->season_name;
        $seasons->season_year  			= $this->season_year;
        $seasons->seasonMainCity_Id    	= $this->seasonMainCity_Id;
        $seasons->seasonSubCity_Id    	= $subcityId;
        $seasons->season_description 	= $this->season_description;
        $seasons->season_venue 			= $this->season_venue;
        $seasons->status 				= $this->status;
        $seasons->date_created 			= new Expression('NOW()');
        return $seasons->save() ? $seasons : null;
    }
    
    
    
    public function checkSeason($values){
		$query    = new Query;  
	
		if(!empty($values['seasonSubCity_Id'])) {
			$subcityId = $values['seasonSubCity_Id'];
		} else {
			$subcityId = '0';
		}
		if(!empty($values['seasonMainCity_Id'])) {
			$maincityId = $values['seasonMainCity_Id'];
		}
		$year = $values['season_year'];
        $query->select('*')->from('tbl_seasons')->where(['seasonMainCity_Id' => $maincityId,'seasonSubCity_Id' => $subcityId,'season_year'=>$year]);
        //echo $query->createCommand()->RawSql; die;
        return $query->createCommand()->queryAll(); 
	}
	
	
    
    
}
