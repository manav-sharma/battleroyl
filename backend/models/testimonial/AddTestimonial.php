<?php
namespace backend\models\testimonial;
use backend\models\testimonial\Testimonial;
use yii\base\Model;
use Yii;

/**
 * AddTestimonial
 */
class AddTestimonial extends Model {

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
            'name' 			=> 'Name',
            'image' 		=> 'Image',
            'description' 	=> 'Description',
            'datetime' 		=> 'Date',
            'status' 		=> 'Status',
        ];
    }
    
    public function addtestimonial() {
        if (!$this->validate()) {
            return null;
        }
        $testimonial 				= new Testimonial();
        $testimonial->name 			= $this->name;
        $testimonial->description   = $this->description;
        $testimonial->image 		= $this->image;
        $testimonial->status 		= $this->status;
        $testimonial->user_type 	= '1';
        //echo'<pre>'; print_r($service); exit();
        return $testimonial->save() ? $testimonial : null;
    }
}
