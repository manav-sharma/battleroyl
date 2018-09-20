<?php
namespace backend\models\posts;

use yii\base\Model;
use yii\web\UploadedFile;
use yii;

############### Image Manipulation #################
use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;

class PostsPictureUpload extends Model
{
    /**
     * @var UploadedFile
     */
    public $image;

    public function rules()
    {        
        return [
       [['image'],'required', 'on'=>'update-profile'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxSize'=>5120000, 'on'=>'update-profile'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxSize'=>5120000]
        ];
    }
    
    public function upload()
    {
        //Set the path that the file will be uploaded to
        $uploadPath = Yii::getAlias('@common') .'/uploads/posts/';
        if ($this->validate()) {
            
            $fileNameWithoutExtension = $this->image->baseName . "_" . time();
            $fileNameWithExtension = $fileNameWithoutExtension . '.' . $this->image->extension;
            
            $this->image->saveAs($uploadPath . $fileNameWithExtension);
            
            $thumbnail260x260Name = $uploadPath . $fileNameWithoutExtension . "_260x260" . "." . $this->image->extension;
       
            return array( 'originalImage'=>$fileNameWithExtension );
        } else {
            return false;
        }
    } 
}
?>
