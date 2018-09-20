<?php
namespace backend\models\categories;

use yii\base\Model;
use Yii;

/**
 * UpdateNews
 */
class UpdateCategories extends Categories
{
    public $name;
    public $image;
    public $description;
    public $datetime;
    public $status;

	/**
     * @inheritdoc
     */
    public function rules() {
        return [
			 [['name','description'], 'required'],
			 ['name', 'string', 'max' => 60],   
			 ['description', 'string', 'max' => 250], 					             
        ];
    }

    /**
    * @inheritdoc
    */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id]);
    }
    
    /**
    * update news.
    *
    * @return User|null the saved model or null if saving fails
    */
	public function updatedata($id) {
        if (!$this->validate()) {
            return null;
        }
        $data 				 = Categories::findOne(['id' => $id]);
        if($this->image != '' ) 
			$data->image 	 = $this->image;
                
        $data->name 		 = $this->name;
        $data->description   = $this->description;
        return $data->save() ? $data : null;
	}
}
