<?php
namespace frontend\models\users;

use yii\base\Model;
use yii\web\UploadedFile;
use yii;

############### Image Manipulation #################
use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;

class ProfilePictureUpload extends Model
{
    /**
     * @var UploadedFile
     */
    public $profile_image;

    public function rules()
    {        
        return [
            [['profile_image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpeg, jpg', 'maxSize'=>1024*1024*5, "tooBig" => "The file \"{file}\" is too big. Its size cannot exceed  5 MB."],//size in bytes            
        ];
    }
	   /**
	 * @inheritdoc
	 */
	 public function attributeLabels() {
		return [
			 'profile_image'      => Yii::t('yii','Profile Picture'),
		 ];
	 }
	 
    public function upload()
    {
        ############= file upload path =############
        $uploadPath = Yii::getAlias('@common') .'/uploads/profile/';

        if ($this->validate()) {
            
            $fileNameWithoutExtension = $this->profile_image->baseName . "_" . time();
            $fileNameWithExtension = $fileNameWithoutExtension . '.' . $this->profile_image->extension;
            
            $this->profile_image->saveAs($uploadPath . $fileNameWithExtension);
            
            $thumbnail260x260Name = $uploadPath . $fileNameWithoutExtension . "_260x260" . "." . $this->profile_image->extension;
            
            return array( 'originalImage'=>$fileNameWithExtension );
        } else {
            return false;
        }
    }
}
?>
