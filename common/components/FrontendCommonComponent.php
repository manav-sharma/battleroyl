<?php
namespace common\components;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\db\Query;

class FrontendCommonComponent extends Component {

	public function frontendbanner() {
        return \backend\models\banner\Banner::find()->where(['status' => '1'])->asArray()->all();
	}

	public function membershipPlans() {
		return \backend\models\memberships\Package::find()->where(['status' => '1'])->asArray()->all();
	}
	
	public function frontendbannerlanding() {
        return \backend\models\banner\Banner::find()->where(['status' => '1','banner_assign' => '1'])->asArray()->one();
	}
	
	public function frontendbannerhome() {
        return \backend\models\banner\Banner::find()->where(['status' => '1','banner_assign' => '2'])->asArray()->one();
	}
	
	public function countcomments($post_id) {
        $query = new Query;
        $query->select('COUNT(*) AS cnt')
              ->from('tbl_comments')
              ->where(['status'=>'1','post_id'=>$post_id])
              ->count();
        $rows = $query->one();
        $command = $query->createCommand(); 
        $rows = $command->queryOne();
        return $rows; 
	}
	
	public function parentCities() {
        $query = new Query;
        $query->select('*')
              ->from('tbl_main_cities');
        $rows = $query->all();
        $command = $query->createCommand();
        $rows = $command->queryAll();
        return $rows; 
	}
	
	
	public function subcities($parent_id) {
        $query = new Query;
        $query->select('*')
              ->from('tbl_sub_cities')
              ->where(['main_city_id'=>$parent_id]);
        $rows = $query->all();
        $command = $query->createCommand();
        //echo $query->createCommand()->RawSql; 
        $rows = $command->queryAll();
        //print_r($rows); 
        return $rows; 
	}
	
	public function commenteduser($user_id) {
        $query = new Query;
        $query->select('*')
              ->from('user')
              ->where(['id'=>$user_id]);
        $rows = $query->one();
        $command = $query->createCommand();
        //echo $query->createCommand()->RawSql; 
        $rows = $command->queryOne();
        //print_r($rows); 
        return $rows; 
	}
	
	
	public function frontendbannervideo() {
        $query = new Query;
        $query->select('youtubevideolink')
              ->from('tbl_homebannervideo')
              ->where(['status'=>1]);
        $rows = $query->one();
        $command = $query->createCommand(); 
        $rows = $command->queryOne();
        return $rows; 
	}
	
	public function contactinfo() {
        $query = new Query;
        $query->select('*')
              ->from('page')
              ->where(['status'=>1,'id'=>9,'pageType'=>'module']);
        $rows = $query->one();
        $command = $query->createCommand(); 
        $rows = $command->queryOne();
        return $rows; 
	}
	
	public function mapInfo() {
        $query = new Query;
        $query->select('*')
              ->from('page')
              ->where(['status'=>1,'id'=>13,'pageType'=>'module']);
        $rows = $query->one();
        $command = $query->createCommand(); 
        $rows = $command->queryOne();
        return $rows; 
	}
	
	public function footerContactInfo() {
        $query = new Query;
        $query->select('*')
              ->from('page')
              ->where(['status'=>1,'id'=>14,'pageType'=>'module']);
        $rows = $query->one();
        $command = $query->createCommand(); 
        $rows = $command->queryOne();
        return $rows; 
	}
	
	public function getSeasonName($season_id) {
        return \frontend\models\Seasons::find()->where(['season_id' => $season_id])->asArray()->one();
	}
	
	public function getLastClosedSeason(){
		$query = new Query;
        $query->select('*')
			  ->from('tbl_seasons')
			  ->where(['status'=>'2'])
			  ->orderBy(['season_year'=>SORT_DESC]);
	
        $rows = $query->one();
        $command = $query->createCommand();
        $rows = $command->queryOne();
        return $rows; 
	}
	
}
