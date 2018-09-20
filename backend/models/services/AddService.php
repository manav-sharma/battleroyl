<?php
namespace backend\models\services;
use backend\models\services\Service;
use yii\base\Model;
use Yii;

/**
 * AddDocumentForm
 */
class AddService extends Model {
	
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
    public function attributeLabels() {
        return [
            'name' => 'Name',
            'image' => 'Image',
            'description' => 'Description',
            'datetime' => 'Date',
            'status' => 'Status',
        ];
    }
    
    public function addservice() {
        if (!$this->validate()) {
            return null;
        }

        $service 				= new Service();
        $service->name 			= $this->name;
        $service->description   = $this->description;
        $service->image 		= $this->image;
        $service->status 		= $this->status;
        //echo'<pre>'; print_r($service); exit();
        return $service->save() ? $service : null;
    }    
}
