<?php
namespace backend\models\categories;
use backend\models\categories\Categories;
use yii\base\Model;
use Yii;

/**
 * AddNews
 */
class AddCategories extends Model {

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

    public function insertdata() {
        if (!$this->validate()) {
            return null;
        }

        $data 				= new Categories();
        $data->name 		= $this->name;
        $data->description  = $this->description;
        $data->image 		= $this->image;
        $data->status 		= $this->status;
        return $data->save() ? $data : null;
    }
}
