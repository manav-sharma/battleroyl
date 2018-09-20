<?php
namespace backend\models\membershipservices;
use backend\models\membershipservices\Service;
use yii\base\Model;
use Yii;

/**
 * AddNews
 */
class AddService extends Model {

    public $name;
    public $image;
    public $description;
    public $allowed_service;
    public $number_of_access;
    public $service_type;
    public $membership_id;
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
    public function attributeLabels() {
        return [
            'name' 				=> 'Name',
            'image' 			=> 'Image',
            'description' 		=> 'Description',
            'amount' 			=> 'amount',
            'membership_id'	=> 'membership_id',
            'datetime' 			=> 'Date',
            'status' 			=> 'Status',
        ];
    }

    public function insertdata() {
        if (!$this->validate()) {
            return null;
        }

        $data 					= new Service();     
        $data->name 			= $this->name;
        $data->description   	= $this->description;
        $data->allowed_service 	= $this->allowed_service;
        $data->number_of_access = $this->number_of_access;
        $data->service_type 	= $this->service_type;
        $data->membership_id 	= $this->membership_id;
        $data->status 			= ACTIVE;
        return $data->save() ? $data : null;
    }
}
