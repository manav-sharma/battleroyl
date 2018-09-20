<?php
namespace backend\models\realestate;

use yii\base\Model;
use Yii;

/**
 * UpdateDocument
 */
class UpdateRealestate extends Realestate
{
    public $title;
    public $filename;
    public $description;
    public $datetime;
    public $status;
	
	/**
     * @inheritdoc
     */
    public function rules() {
        return [
			 [['title','cat_id','description'], 'required'],  
			 ['title', 'string', 'max' => 60],          
			 ['description', 'string', 'max' => 250],          
        ];
    }

    
      /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }
    
    /**
     * update banner.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function updatedata($id) {
        if (!$this->validate()) {
            return null;
        }
        $document 				= Realestate::findOne(['id' => $id]);
        if($this->filename != '' ) 
			$document->filename 	= $this->filename;

        $document->title 		= $this->title;
        $document->cat_id 		= $this->cat_id;
        $document->description  = $this->description;
        $document->document_type= $this->document_type;
        return $document->save() ? $document : null;
     }
}
