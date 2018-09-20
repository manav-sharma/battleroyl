<?php
namespace frontend\models;
use yii\db\Query;
use Yii;

/**
 * Inerests model
 *
 * @property integer $id
 * @property string $Inerests
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
    public function rules()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [];
    }
    
    public function getseason($parenCity,$subcity){
		$query = new Query;
		$year = date('Y');
        $query->select('*')
            ->from('tbl_seasons')
            ->where(['seasonMainCity_Id'=>$parenCity,'seasonSubCity_Id'=>$subcity,'status'=>'1','season_year'=>$year]);
        $rows = $query->one();
        $command = $query->createCommand();
        //echo $query->createCommand()->RawSql;
        $rows = $command->queryOne();
        return $rows; 
	}
	
	public function getContestantDetails($contestant_id){
		$query = new Query;
        $query->select('*')
			  ->from('tbl_contestant')
			  //->join('LEFT JOIN', 'tbl_contestant_detail',
           // 'tbl_contestant_detail.contestant_id = tbl_contestant.contestant_id')		
              ->where(['contestant_id'=>$contestant_id,'status'=>'1']);
        $rows = $query->one();
        $command = $query->createCommand();
        $rows = $command->queryOne();
        return $rows; 
	}
	
	public function getContestantImages($contestant_id){
		$query = new Query;
        $query->select('*')
			  ->from('tbl_contestant_detail')
			  //->join('LEFT JOIN', 'tbl_contestant_detail',
           // 'tbl_contestant_detail.contestant_id = tbl_contestant.contestant_id')		
              ->where(['contestant_id'=>$contestant_id]);
        $rows = $query->All();
        $command = $query->createCommand();
        $rows = $command->queryAll();
        return $rows; 
	}
	
	public function contestantWithHighestVotes($season_id){
		$query = new Query;
        $query->select('*')
			  ->from('tbl_contestant')	
			  ->join('LEFT JOIN', 'tbl_contestant_detail',
					'tbl_contestant_detail.contestant_id = tbl_contestant.contestant_id')	
              ->where(['tbl_contestant.season_id'=>$season_id])
              ->orderBy(['tbl_contestant.contestant_votes'=>SORT_DESC])
              ->limit(1);
        $rows = $query->one();
        $command = $query->createCommand();
         //echo $query->createCommand()->RawSql; die;
        $rows = $command->queryOne();
        return $rows; 
	}
	
	
	public function getSeasonDeatils($parenCity,$subCity,$year){
		$query = new Query;
        $query->select('*')
			  ->from('tbl_seasons')	
              ->where(['season_year'=>$year,'seasonMainCity_Id'=>$parenCity,'seasonSubCity_Id'=>$subCity,'status'=>'2']);
        $rows = $query->one();
        $command = $query->createCommand();
       
        $rows = $command->queryOne();
        return $rows; 
	}


	public function getActiveSeasonDeatils($parenCity,$subCity,$year){
		$query = new Query;
        $query->select('*')
			  ->from('tbl_seasons')	
              ->where(['season_year'=>$year,'seasonMainCity_Id'=>$parenCity,'seasonSubCity_Id'=>$subCity,'status'=>'1']);
        $rows = $query->one();
        $command = $query->createCommand();
        //echo $query->createCommand()->RawSql; die;
        $rows = $command->queryOne();
        return $rows; 
	}
	
	
	
	public function getLastClosedSeason(){
		$query = new Query;
        $query->select('*')
			  ->from('tbl_seasons')
			  ->where(['status'=>'2'])
			  ->orderBy(['season_year'=>SORT_DESC]);
	
        $rows = $query->one();
        $command = $query->createCommand();
       // echo $query->createCommand()->RawSql; die;
        $rows = $command->queryOne();
        return $rows; 
	}
	
	
	
	public function getyearDeatils($parenCity,$subCity){
		$query = new Query;
		$currentyear = date("Y");
        $query->select('season_year')
			  ->from('tbl_seasons')
			  ->where(['status'=>'2','seasonMainCity_Id'=>$parenCity,'seasonSubCity_Id'=>$subCity])
			  ->orderBy(['season_year'=>SORT_DESC]);
			  //->where(['not in','YEAR( `date_created` )',[$currentyear]]);
        $rows = $query->all();
        $command = $query->createCommand();
       
        $rows = $command->queryAll();
        return $rows; 
	}
	
	
	public function getgroupImages($season_id){
		$query = new Query;
        $query->select('*')
			  ->from('tbl_group_images')	
              ->where(['season_id'=>$season_id]);
        $rows = $query->all();
        $command = $query->createCommand();
        $rows = $command->queryAll();
        return $rows; 
	}
	
	
	public function getcontestantWinnerDeatils($season_id){
		$query = new Query;
        $query->select('*')
			  ->from('tbl_contestant')	
			  ->join('LEFT JOIN', 'tbl_contestant_detail',
					'tbl_contestant_detail.contestant_id = tbl_contestant.contestant_id')	
              ->where(['tbl_contestant.season_id'=>$season_id,'tbl_contestant.result'=>'1']);
        $rows = $query->one();
        $command = $query->createCommand();
        //echo $query->createCommand()->RawSql; die;
        $rows = $command->queryOne();
        return $rows; 
	}
	
	public function getcontestantRunnerUpDeatils($season_id){
		$query = new Query;
        $query->select('*')
			  ->from('tbl_contestant')	
			  ->join('LEFT JOIN', 'tbl_contestant_detail',
					'tbl_contestant_detail.contestant_id = tbl_contestant.contestant_id')	
              ->where(['tbl_contestant.season_id'=>$season_id,'tbl_contestant.result'=>['2','3']]);
        $rows = $query->all();
        $command = $query->createCommand();
        //echo $query->createCommand()->RawSql; die;
        $rows = $command->queryAll();
        return $rows; 
	}
	
	
	public function getcontestantDeatils($season_id){
		$query = new Query;
        $query->select('*')
			  ->from('tbl_contestant')	
			  ->join('LEFT JOIN', 'tbl_contestant_detail',
					'tbl_contestant_detail.contestant_id = tbl_contestant.contestant_id')	
              ->where(['tbl_contestant.season_id'=>$season_id,'tbl_contestant.result'=>'0'])
              ->orderBy(['tbl_contestant.contestant_name'=>SORT_ASC]);
        $rows = $query->all();
        $command = $query->createCommand();
        $rows = $command->queryAll();
        return $rows; 
	}
}
?>
