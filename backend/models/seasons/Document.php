<?php
namespace backend\models\seasons;

use yii\base\Model;
use yii\web\UploadedFile;
use yii;


class Document extends Model
{
    /**
     * @var UploadedFile[]
     */


    public $importfile;
    
    public function rules() {
        return [
         
			[['importfile'], 'file', 'skipOnEmpty' => true, 'maxSize'=>1024*1024*2],	
			['importfile','required'], 
        ];
    }
    
    public function upload() {
        if ($this->validate()) {
			$uploadPath = Yii::getAlias('@common') .'/uploads/importfiles/';
			$fileNameWithoutExtension = "importFiles".time();
			$fileNameWithExtension = $fileNameWithoutExtension . '.' . $this->importfile->extension;
			if($this->importfile->saveAs($uploadPath . $fileNameWithExtension)) {
				$returnArr = $fileNameWithExtension;
			}
            return $returnArr;
        } else {
            return false;
        }
    }
    

    //~ public function upload($nwArr=0) {
		//~ echo '<pre>'; print_r($nwArr); die('d');
		//~ 
        //~ ########## Set the path that the file will be uploaded to
        //~ $uploadPath = Yii::getAlias('@common') .'/uploads/groupimages/';
        //~ if ($this->validate()) {
			//~ $returnArr = array();
			//~ $i=1;
			//~ $n=0;		
            //~ foreach ($this->group_image as $file) {
				//~ if(!in_array($file->name, $nwArr)) {
					//~ $fileNameWithoutExtension = "seasonGroup_".$i.time();
					//~ $fileNameWithExtension = $fileNameWithoutExtension . '.' . $file->extension;
					//~ if($file->saveAs($uploadPath . $fileNameWithExtension)) {
						//~ $returnArr[] = $fileNameWithExtension;
					//~ }
					//~ $i++;
				//~ }
				//~ $n++;				
            //~ }
			//~ return array('originalImage' => $returnArr);
        //~ } else {
            //~ return false;
        //~ }
    //~ }
}
?>
