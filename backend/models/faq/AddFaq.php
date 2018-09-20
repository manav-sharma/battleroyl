<?php
namespace backend\models\faq;
use backend\models\faq\Faq;
use yii\base\Model;
use Yii;

/**
 * AddFaq
 */
class AddFaq extends Model {

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
			['name', 'string', 'max' => 100],   
			['description', 'string', 'max' => 1000],   
        ];
    }

    /**
    * @inheritdoc
    */
    public function attributeLabels() {
        return [
            'name' 			=> 'Name',
            //'image' 		=> 'Image',
            'description' 	=> 'Description',
            'datetime' 		=> 'Date',
            'status' 		=> 'Status',
        ];
    }
    
    public function addfaq() {
        if (!$this->validate()) {
            return null;
        }
        $faq 				= new Faq();
        $faq->name 			= $this->name;
        $faq->description   = $this->description;
       // $faq->image 		= $this->image;
        $faq->status 		= $this->status;
        $faq->user_type 	= '1';
        //echo'<pre>'; print_r($service); exit();
        return $faq->save() ? $faq : null;
    }
}
