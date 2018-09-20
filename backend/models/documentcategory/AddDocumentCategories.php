<?php
namespace backend\models\documentcategory;
use backend\models\documentcategory\Documentcategory;
use yii\base\Model;
use Yii;

/**
 * AddNews
 */
class AddDocumentCategories extends Model {

    public $name;
    public $description;
    public $datetime;
    public $status;

    /**
    * @inheritdoc
    */
    public function rules() {
        return [
            [['name','description'], 'required'],
			 ['name', 'string', 'max' => 40],   
			 ['description', 'string', 'max' => 250], 		            
        ];
    }

    /**
    * @inheritdoc
    */
    public function attributeLabels() {
        return [
            'name' => 'Name',
            'description' => 'Description',
            'datetime' => 'Date',
            'status' => 'Status',
        ];
    }

    public function insertdata() {
        if (!$this->validate()) {
            return null;
        }

        $data 				= new Documentcategory();
        $data->name 		= $this->name;
        $data->description  = $this->description;
        $data->status 		= $this->status;
        $data->datetime 		= date("Y-m-d H:i:s");		
        return $data->save() ? $data : null;
    }
}
