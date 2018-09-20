<?php
namespace backend\models\contestant;

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


    public $contestant_image;
    
    public function rules() {
        return [
         
			[['contestant_image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif', 'maxSize'=>1024*1024*2, 'maxFiles' => 6],	
			['contestant_image','safe'], 
        ];
    }

    public function upload($nwArr=0) {
        ########## Set the path that the file will be uploaded to
        $uploadPath = Yii::getAlias('@common') .'/uploads/contestant/';
        if ($this->validate()) {
			$returnArr = array();
			$i=1;
			$n=0;		
            foreach ($this->contestant_image as $file) {
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
}
?>
