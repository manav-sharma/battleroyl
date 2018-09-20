<?php
namespace backend\models\documentupload;
use backend\models\documentupload\Document;
use yii\base\Model;
use Yii;

/**
 * AddDocumentForm
 */
class AddDocumentForm extends Model {
	
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
    
    public function adddocument() {
        if (!$this->validate()) {
            return null;
        }
        $document 				= new Document();
        $document->title 		= $this->title;
        $document->cat_id 		= $this->cat_id;
        $document->description  = $this->description;
        $document->filename 	= $this->filename;
        $document->status 		= $this->status;
        $document->document_type= $this->document_type;
        //echo'<pre>'; print_r($document); exit();
        return $document->save() ? $document : null;
    }    
}
