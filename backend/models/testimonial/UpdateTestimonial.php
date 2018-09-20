<?php
namespace backend\models\testimonial;
use yii\base\Model;
use Yii;

/**
 * UpdateTestimonail
 */
class UpdateTestimonial extends Testimonial
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
    * update banner.
    *
    * @return User|null the saved model or null if saving fails
    */
	public function updatetestimonial($id) {
        if (!$this->validate()) {
            return null;
        }
        $testimonial 				= Testimonial::findOne(['id' => $id]);
        if($this->image != '' ) 
			$testimonial->image 	= $this->image;
			        
        $testimonial->name 			= $this->name;
        $testimonial->description   = $this->description;
        return $testimonial->save() ? $testimonial : null;
	}
}
