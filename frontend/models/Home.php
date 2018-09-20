<?php
namespace frontend\models;
use yii\base\Model;
use Yii;
use yii\db\Query;

class Home extends Model
{
	
	public function homeVideos() {
		$query = new Query;
        $query->select('*')
            ->from('tbl_homepagevideo')
            ->where(['status'=>'1'])
            ->orderBy(['date_created'=>SORT_DESC])
            ->limit('6');
        $rows = $query->all();
        $command = $query->createCommand();
        $rows = $command->queryAll();
        return $rows; 
   
    } 
    
    public function homePosts(){
		$query = new Query;
        $query->select('*')
            ->from('tbl_posts')
            ->where(['status'=>'1'])
            ->orderBy(['datecreated'=>SORT_DESC])
            ->limit('5');
        $rows = $query->all();
        $command = $query->createCommand();
        $rows = $command->queryAll();
        return $rows; 
		
	}
	
	
	public function homeParentcity(){
		$query = new Query;
        $query->select('*')
            ->from('tbl_main_cities')
            ->orderBy(['date_created'=>SORT_ASC]);
        $rows = $query->all();
        $command = $query->createCommand();
        $rows = $command->queryAll();
        return $rows; 
		
	}
	
	public function getFaq(){
		$query = new Query;
        $query->select('*')
            ->from('tbl_faq')
            ->orderBy(['datetime'=>SORT_DESC]);
        $rows = $query->all();
        $command = $query->createCommand();
        $rows = $command->queryAll();
        return $rows; 
		
	}
	
	public function getAboutus(){
		$query = new Query;
        $query->select('*')
              ->from('page')
              ->where(['status'=>1,'id'=>8,'pageType'=>'module']);
        $rows = $query->one();
        $command = $query->createCommand(); 
        $rows = $command->queryOne();
        return $rows; 
	}
}
?>	
