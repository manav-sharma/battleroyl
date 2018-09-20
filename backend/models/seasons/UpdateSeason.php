<?php
namespace backend\models\seasons;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\base\Model;
use yii\db\Query;
use Yii;

/**
 * UpdateTestimonail
 */
class UpdateSeason extends Seasons
{
	public $season_id;	
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
            [['season_name','season_year','season_description','seasonMainCity_Id','season_venue','status'], 'required'],
			['season_name', 'string', 'max' => 100],   
			['season_description', 'string', 'max' => 1000],
			[['seasonSubCity_Id'], 'required',  'when' => function($model) {
            return $model->cityHiddenValue == 2;
            }, 'whenClient' => "function (attribute, value) {
                return $('#addseasons-cityhiddenvalue').val() == '2';
            }"],  
			[['season_id'],'safe'],  
        ];
    }
   
    
    /**
    * @inheritdoc
    */
    public static function findIdentity($id) {
        return static::findOne(['season_id' => $id]);
    }
    
    /**
    * update banner.
    *
    * @return User|null the saved model or null if saving fails
    */
	public function updateseasons($id) {
        if (!$this->validate()) {
            return null;
        }
        if(!empty($this->seasonSubCity_Id)) {
			$subcityId = $this->seasonSubCity_Id;
		} else {
			$subcityId = '0';
		}
        $seasons 						= Seasons::findOne(['season_id' => $id]);
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
	
	
	public function checkSeason($values,$id){
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
        $query->select('*')->from('tbl_seasons')->where(['seasonMainCity_Id' => $maincityId,'seasonSubCity_Id' => $subcityId,'season_year'=>$year,'status'=>'1'])->andWhere(['!=', 'season_id',$id ]);
        //echo $query->createCommand()->getRawSql();
       // die('111');
        
        
        return $query->createCommand()->queryAll(); 
	}
	
	
	//~ public static function findValues($id) {
		//~ $query    = new Query;   
        //~ $query->select(['*'])  
        //~ ->from('tbl_seasons')
        //~ ->join(	'inner join', 
            //~ 'tbl_cities',
            //~ 'tbl_cities.city_id =tbl_seasons.seasonCity_Id'
        //~ )->where(['season_id' => $id]); 
		//~ $command = $query->createCommand();
		//~ $data = $command->queryOne();
		//~ return $object = (object) $data;
        //~ //return static::findOne(['season_id' => $id]);
    //~ }
	
}
