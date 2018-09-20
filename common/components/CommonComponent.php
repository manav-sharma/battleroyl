<?php
namespace common\components;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\db\Query;

class CommonComponent extends Component {
	public function updateStates($parentID=0) {
       $subcities = \common\models\Maincity::find()->where(['parentCity_id' => $parentID])->asArray()->all();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $subcities;
	}
	
	
	public function updateMaincities($parentID=0) {
       $subcities = \common\models\Subcity::find()->where(['main_city_id' => $parentID])->asArray()->all();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $subcities;
	}
	
	
	public function updateCities($stateID=0) {
        $cities = \common\models\City::find()->where(['state_id' => $stateID])->asArray()->all();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $cities;
	}
	public function membershipservices($s_type=0) {
		if($s_type > 0) {
			switch ($s_type) {
				case 1:
					return "Photos";
					break;
				case 2:
					return "Videos";
					break;
				case 3:
					return "360 degree view";
					break;
				case 4:
					return "Map Locations";
					break;
				case 5:
					return "Advanced Search";
					break;
				case 6:
					return "Properties View";
					break;
				case 7:
					return "User Pages";
					break;		
				case 8:
					return "Premium Section";
					break;		
				case 9:
					return "Agencies & Special Organizations";
					break;		
				case 10:
					return "Uploads";
					break;
				default:
					echo "--";
			}
		} else {
			return array("1" => "Photos", "2" => "Videos", "3" => "360 degree view" ,"4" => "Map Locations", "5" => "Advanced Search", "6" => "Properties View", "7" => "User Pages", "8" => "Premium Section", "9" => "Agencies & Special Organizations", "10" => "Uploads");
		}
	}
	public function membershipservicesaccess() {
		return array("NO" => "No", "ALL" => "All", "LIMITED" => "Limited");
	}
	public function propertyDocumentTypes() {
		return array("1"=>"Document","2"=>"Image","3"=>"Video","4"=>"360 Video","5"=>"3D Video");
	}
	public function propertyFor($p_for=0) {
		if($p_for > 0) {
			switch ($p_for) {
				case 1:
					return "Sale";
					break;
				case 2:
					return "Rent";
					break;
				case 3:
					return "Investment";
					break;
				case 4:
					return "Exchange";
					break;
				case 5:
					return "New Project";
					break;
				case 6:
					return "Agent Offer";
					break;
				case 7:
					return "Ejar Offers";
					break;																				
				default:
					echo "--";
			}
		} else {
			return array("1"=>"Sale","2"=>"Rent","3"=>"Investment","4"=>"Exchange","5"=>"New Project","6"=>"Agent Offer","7"=>"Ejar Offers");
		}
	}
	public function userTypes() {
		return ArrayHelper::map(\common\models\Usertype::find()->all(), 'id', 'name');
	}
	public function countries($c_id=0) {
		if($c_id > 0) {
			return \common\models\Country::find()->select(["name"])->where(['id' => $c_id])->one();
		} else {
			return ArrayHelper::map(\common\models\Country::find()->all(), 'id', 'name');
		}
	}
	public function regions($r_id=0) {
		if($r_id > 0) {
			return \common\models\State::find()->select(["name"])->where(['id' => $r_id])->one();
		} else {
			return ArrayHelper::map(\common\models\State::find()->all(), 'id', 'name');
		}
	}
	public function cities($c_id=0) {
		if($c_id > 0) {
			return \common\models\City::find()->select(["name"])->where(['id' => $c_id])->one();
		} else {
			return ArrayHelper::map(\common\models\City::find()->all(), 'id', 'name');
		}
	}
	public function status($v=0,$n=0) {
		if($n == 1) {
			if($v=='1') { echo 'Active'; } else { echo 'Inactive'; }
		} else {
			if($v=='1') { echo 'Active'; } else { echo 'Inactive'; }			
		}
	}
	public function propertyTypes($p_type=0) {
		if($p_type > 0) {
			return \common\models\PropertyTypes::find()->select(["name"])->where(['id' => $p_type])->one();
		} else {
			return ArrayHelper::map(\common\models\PropertyTypes::find()->all(), 'id', 'name');
		}
	}
	public function propertyBuildYear() {
		$c_year = date("Y");
		$arr=array();
		for($i = $c_year; $i > 1960; $i--) {
			$arr[$i]=$i;
		}
		return $arr;
	}
	public function propertyRooms() {
		$arr=array();
		for($i = 1; $i <= 15; $i++) {
			$arr[$i]=$i;
		}
		return $arr;
	}
	public function propertyFloors() {
		$arr=array();
		for($i = 1; $i <= 4; $i++) {
			$arr[$i]=$i;
		}
		return $arr;
	}
	public function propertyAddedBy($addedBy=0) {
		switch ($addedBy) {
			case 1:
				return "Admin";
				break;
			case 2:
				return "User";
				break;															
			default:
				echo "--";
		}
	}
	public function propertyPrices() {
		return array("2000.00"=>"2000","3000.00"=>"3000","4000.00"=>"4000"); 
	}
	public function propertyRights($p_right=0) {
		if($p_right > 0) {
			switch ($p_right) {
				case 1:
					return "Public";
					break;
				case 2:
					return "Private";
					break;
				case 3:
					return "Ministry of Housing";
					break;																		
				default:
					echo "--";
			}			
		} else {
			return array("1"=>"Public","2"=>"Private","3"=>"Ministry of Housing");
		}
	}
	public function propertyDocuments($id=0) {
		return \backend\models\properties\Documents::find()->where(['property_id' => $id,'type'=>'1'])->all();
	}
	public function propertyVideo($id=0) {
		return \backend\models\properties\Documents::find()->where(['property_id' => $id,'type'=>'3'])->one();
	}
	public function propertyViewvideo($id=0) {
		return \backend\models\properties\Documents::find()->where(['property_id' => $id,'type'=>'4'])->one();
	}
	public function propertyImages($id=0) {
		return \backend\models\properties\Documents::find()->where(['property_id' => $id,'type'=>'2'])->all();
	}
	
	public function contestantImages($id=0) {
		return \backend\models\contestant\Documents::find()->where(['contestant_id' => $id])->all();
	}
	
	public function seasonImages($id=0) {
		return \backend\models\seasons\GroupImages::find()->where(['season_id' => $id])->all();
	}
	
	
	public function propertyDviewvideo($id=0) {
		return \backend\models\properties\Documents::find()->where(['property_id' => $id,'type'=>'5'])->one();
	}
	public function getUsers($userIds) {
		return \backend\models\users\Users::find()->select(["CONCAT(`firstname`, ' ', `lastname`) as firstname,email,phone,address"])->where("id IN(" . $userIds . ")")->all(); 
	}
	public function getEmailContent($alias='') {
        $query = new Query;
        $query->select('message')->from('newsletter_template')->where("code ='" . $alias . "' AND status ='Y'");
        return  $query->createCommand()->queryOne();		
	}
	public function getUsername($userids='') {
		$result = \backend\models\users\Users::find()->select(["GROUP_CONCAT(`firstname`, ' ', `lastname`) as firstname"])->where("id IN(" . $userids . ")")->one();
        if(isset($result['firstname']) && !empty($result['firstname'])) {
			return $result['firstname'];
		}
	}
	public function getAdminEmailID() {
		$modelLink = new \common\models\Admin();
		$AdminEmail  = $modelLink->getAdminEmail();
		if(isset($AdminEmail['1']) && !empty($AdminEmail['1'])) {
			$fromEmail = $AdminEmail['1'];
		} else {
			$fromEmail = Yii::$app->params['adminEmail'];
		}
		return $fromEmail;
	}
}
