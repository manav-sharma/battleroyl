<?php
namespace backend\models\advertisements;

use yii\base\Model;
use Yii;

/**
 * UpdateService
 */
class UpdateAdvertisement extends Advertisement
{
    public $id;
    public $name;
    public $advertisement_image;
    public $description;
    public $start_date;
    public $end_date;
    public $user_id;
    public $approved;
    public $date_created;
    public $status;

	/**
    * @inheritdoc
    */
    public function rules() {
        return [
				[['user_id','membership_id'], 'integer'],
                [['name','advertisement_image','approved'], 'string'],
                [['name','approved'], 'required'],
                ['name', 'string', 'max' => 60],                
        ];
    }
    
    /**
    * @inheritdoc
    */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id]);
    }
    
    /**
    * update service.
    *
    * @return User|null the saved model or null if saving fails
    */
	public function updatedata($id) {
        if (!$this->validate()) {
            return null;
        }
        $data 				= Advertisement::findOne(['id' => $id]);
        if($this->advertisement_image != '')
			$data->advertisement_image 	= $this->advertisement_image;
			        
        $data->name 			= $this->name;
        $data->approved   		= $this->approved;
        return $data->save() ? $data : null;
	}
}
