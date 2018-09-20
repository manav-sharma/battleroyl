<?php
namespace backend\models\news;

use yii\base\Model;
use Yii;

/**
 * UpdateNews
 */
class UpdateNews extends News
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
	public function updatenews($id) {
        if (!$this->validate()) {
            return null;
        }
        $service 				= News::findOne(['id' => $id]);
        if($this->image != '' ) 
			$service->image 	= $this->image;
                
        $service->name 			= $this->name;
        $service->description   = $this->description;
        return $service->save() ? $service : null;
	}
}
