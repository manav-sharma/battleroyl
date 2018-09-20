<?php
namespace common\models;
use yii\db\Query;
use Yii;

/**
 * User model
 *
 * @property integer $id
 * @property string $countries
  */
class Subcity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_sub_cities';
    }

    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sub_city_name','main_city_id'], 'required'],
            ['sub_city_name', 'string', 'max' => 60],
            
   
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'main_city_id' =>'Main City Name',
            'sub_city_id'=>'Sub City Id',
            'sub_city_name'=>'Sub City Name',
        ];
    }
    
    public function parentcityname($parent_id) {	
		$query    = new Query;   
        $query->select(['*'])  
        ->from('tbl_main_cities')
        ->where(['main_city_id' => $parent_id]); 
		$command = $query->createCommand();
		return $data = $command->queryOne();
    }
    
	public function createSubcity() {
        if (!$this->validate()) {
            return null;
        }
        $posts 					= new Subcity();
        $posts->sub_city_name 	= $this->sub_city_name;
        $posts->main_city_id 	= $this->main_city_id;
        return $posts->save() ? $posts : null;
    }
    
    public function getMainCity(){
        return $this->hasOne(Maincity::className(), ['main_city_id' => 'main_city_id']);
    }
    
    public function getparentname($id){	
		$query =  Maincity::find()->where(['main_city_id' => $id])->one();	
		return $query; 
    }
    
     public function getSubCityName($id){	
		$query =  Subcity::find()->where(['sub_city_id' => $id])->one();	
		return $query; 
    }
    
    public function getMaincities() {
       return $this->hasOne(Maincity::className(), ['main_city_id' => 'main_city_id']);
    }  
    
}
?>
