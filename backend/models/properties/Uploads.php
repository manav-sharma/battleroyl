<?php
namespace backend\models\properties;

use yii\base\Model;
use yii\web\UploadedFile;
use yii;

############### Image Manipulation #################
use yii\imagine\Document;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;

class Uploads extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $upload_documents;
    public $upload_video;
    public $upload_viewvideo;
    public $upload_images;
    public $upload_dview_video;
    
    public function rules() {
        return [
             [['upload_documents'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc, docx, ppt, pdf, txt', 'maxSize'=>1024*1024*2, 'on'=>'upa', 'maxFiles' => 4],
             #[['upload_video'], 'file', 'skipOnEmpty' => true, 'extensions' => 'mp3, mp4, avi, mov', 'maxSize'=>1024*1024*2, 'on'=>'upb'],
             #[['upload_video'], 'file', 'skipOnEmpty' => true, 'extensions' => '', 'maxSize'=>1024*1024*2, 'on'=>'upb'],
			  [['upload_video'], 'file', 'skipOnEmpty' => true, 'extensions' => 'mp4', 'maxSize'=>1024*1024*150, 'maxFiles' => 6, "tooBig" => "The file \"{file}\" is too big. Its size cannot exceed  150 MB.", 'on' => 'upb'],		             
			 #[['upload_viewvideo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'mp4', 'maxSize'=>1024*1024*5, 'on'=>'upc'],
			 [['upload_viewvideo'], 'file', 'skipOnEmpty' => true, 'extensions' => '', 'maxSize'=>1024*1024*5, 'on'=>'upc'],
			 [['upload_images'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif', 'maxSize'=>1024*1024*2, 'on'=>'upd','maxFiles' => 4],
			 #[['upload_dview_video'], 'file', 'skipOnEmpty' => true, 'extensions' => 'mp4', 'maxSize'=>1024*1024*20, 'on'=>'upe'],			 
			 [['upload_dview_video'], 'file', 'skipOnEmpty' => true, 'extensions' => '', 'maxSize'=>1024*1024*20, 'on'=>'upe'],			 
        ];
    }

    public function upload($nwArr=0) {
        ########## Set the path that the file will be uploaded to
        $uploadPath = Yii::getAlias('@common') .'/uploads/properties/';
        if ($this->validate()) {
			$returnArr = array();
			$i=1;
			$n=0;			
            foreach ($this->upload_documents as $file) {
				if(!in_array($file->name, $nwArr)) {
					$fileNameWithoutExtension = "agarid_".$i.time();
					$fileNameWithExtension = $fileNameWithoutExtension . '.' . $file->extension;
					if($file->saveAs($uploadPath . $fileNameWithExtension)) {
						$returnArr[] = $fileNameWithExtension;
					}
					$i++;
				}
				$n++;				
            }
			return array('originalImage' => $returnArr);
        } else {
            return false;
        }
    }

	public function uploadB() {
		########## Set the path that the file will be uploaded to
		$uploadPath = Yii::getAlias('@common') .'/uploads/properties/';
		if ($this->validate()) {
			$fileNameWithoutExtension = "agariv_" . time();
			$fileNameWithExtension = $fileNameWithoutExtension . '.' . $this->upload_video->extension;
			$this->upload_video->saveAs($uploadPath . $fileNameWithoutExtension . '.' . $this->upload_video->extension);
			return array('originalImage' => $fileNameWithExtension, 'file_extention' => $this->upload_video->extension);
		} else {
			return false;
		}
	}
 
    public function uploadC() {
        ########## Set the path that the file will be uploaded to
        $uploadPath = Yii::getAlias('@common') .'/uploads/properties/';
        if ($this->validate()) {
            $fileNameWithoutExtension = "agarivv_" . time();
            $fileNameWithExtension = $fileNameWithoutExtension . '.' . $this->upload_viewvideo->extension;
            $this->upload_viewvideo->saveAs($uploadPath . $fileNameWithExtension);
            return array('originalImage' => $fileNameWithExtension, 'file_extention' => $this->upload_viewvideo->extension);
        } else {
            return false;
        }
    }

    public function uploadD($nwArr=0) {
        ########## Set the path that the file will be uploaded to
        $uploadPath = Yii::getAlias('@common') .'/uploads/properties/';
        if ($this->validate()) {
			$returnArr = array();
			$i=1;
			$n=0;
            foreach ($this->upload_images as $file) {
				if(!in_array($file->name, $nwArr)) {
					$fileNameWithoutExtension = "agarip_".$i.time();
					$fileNameWithExtension = $fileNameWithoutExtension . '.' . $file->extension;
					if($file->saveAs($uploadPath . $fileNameWithExtension)) {
						$returnArr[] = $fileNameWithExtension;
					}
					$i++;
				}
				$n++;
            }
			return array('originalImage' => $returnArr);
        } else {
            return false;
        }
    }

    public function uploadE() {
        ########## Set the path that the file will be uploaded to
        $uploadPath = Yii::getAlias('@common') .'/uploads/properties/';
        if ($this->validate()) {
            $fileNameWithoutExtension = "agaridv_" . time();
            $fileNameWithExtension = $fileNameWithoutExtension . '.' . $this->upload_dview_video->extension;
            $this->upload_dview_video->saveAs($uploadPath . $fileNameWithExtension);
            return array('originalImage' => $fileNameWithExtension, 'file_extention' => $this->upload_dview_video->extension);
        } else {
            return false;
        }
    }
}
?>
