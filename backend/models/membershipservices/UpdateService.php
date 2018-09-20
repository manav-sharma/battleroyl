<?php
namespace backend\models\membershipservices;

use yii\base\Model;
use Yii;

/**
 * UpdateNews
 */
class UpdateService extends Service
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
			  [['name','description','allowed_service','number_of_access','service_type','membership_id'], 'required'],
			 ['name', 'string', 'max' => 60],   
			 [['number_of_access'],'number','max' => 22],    
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

        $data 					= Service::findOne(['id' => $id]);
        $data->name 			= $this->name;
        $data->description   	= $this->description;
        $data->allowed_service 	= $this->allowed_service;
        $data->number_of_access = $this->number_of_access;
        $data->service_type 	= $this->service_type;
        $data->membership_id 	= $this->membership_id;
        return $data->save() ? $data : null;
	}
}
