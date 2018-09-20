<?php
namespace backend\models\realestate;

use yii\base\Model;
use yii\web\UploadedFile;
use yii;

############### Image Manipulation #################
use yii\imagine\Document;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;

class RealestateUpload extends Model
{
    /**
     * @var UploadedFile
     */
    public $title;
    public $filename;
    
    public function rules() {        
        return [
            [['filename'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc,docx,ppt,pdf', 'maxSize'=>5120000, 'on'=>'update-profile'],
        ];
    }

    public function upload() {
        ########## Set the path that the file will be uploaded to
        $uploadPath = Yii::getAlias('@common') .'/uploads/documents/';
        if ($this->validate()) {
            $fileNameWithoutExtension = "document_" . time();
            $fileNameWithExtension = $fileNameWithoutExtension . '.' . $this->filename->extension;
            $this->filename->saveAs($uploadPath . $fileNameWithExtension);
            $thumbnail260x260Name = $uploadPath . $fileNameWithoutExtension . "_260x260" . "." . $this->filename->extension;
            return array('originalImage' => $fileNameWithExtension, 'file_extention' => $this->filename->extension);
        } else {
            return false;
        }
    }
}
?>
