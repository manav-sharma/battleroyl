<?php
namespace backend\models\realestate;
use backend\models\realestate\Realestate;
use yii\base\Model;
use Yii;

/**
 * AddDocumentForm
 */
class AddRealestateForm extends Model {
	
    public $cat_id;
    public $title;
    public $filename;
    public $description;
    public $document_type;
    public $datetime;
    public $status;
    
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['cat_id','title', 'description'], 'required'],
            ['title', 'string', 'max' => 60],
            ['description', 'string', 'max' => 250],   
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Title',
            'contentImage' => 'Image',
            'description' => 'Description',
            'dateCreated' => 'Date',
            'status' => 'Status',
        ];
    }
    
    public function insertdata() {
        if (!$this->validate()) {
            return null;
        }
        $document 				= new Realestate();
        $document->title 		= $this->title;
        $document->cat_id 		= $this->cat_id;
        $document->description  = $this->description;
        $document->filename 	= $this->filename;
        $document->status 		= $this->status;
        $document->document_type= $this->document_type;
        return $document->save() ? $document : null;
    }    
}
