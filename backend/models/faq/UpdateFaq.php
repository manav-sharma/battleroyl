<?php
namespace backend\models\faq;
use yii\base\Model;
use Yii;

/**
 * UpdateTestimonail
 */
class UpdateFaq extends Faq
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
			 ['name', 'string', 'max' => 100],   
			 ['description', 'string', 'max' => 1000], 			         
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
	public function updatefaq($id) {
        if (!$this->validate()) {
            return null;
        }
        $faq 				= Faq::findOne(['id' => $id]);
        if($this->image != '' ) 
			$faq->image 	= $this->image;
			        
        $faq->name 			= $this->name;
        $faq->description   = $this->description;
        return $faq->save() ? $faq : null;
	}
}
