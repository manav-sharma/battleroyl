<?php
namespace common\models;

use Yii;

/**
 * User model
 *
 * @property integer $id
 * @property string $countries
  */
class Maincity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_main_cities';
    }

    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['main_city_name'], 'required'],
            ['main_city_name', 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'main_city_name' => 'Main City Name',
        ];
    }
    
    public function countParentValues()
    {	
		$query =  Maincity::find()->count();	
		return $query; 
    }

    
    //~ public function getState()
    //~ {
        //~ return $this->hasMany(State::className(), ['city_id' => 'city_id']);
    //~ }
}
?>
