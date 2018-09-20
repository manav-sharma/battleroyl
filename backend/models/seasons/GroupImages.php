<?php
namespace backend\models\seasons;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Document model
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $dateCreated
 * @property string $status
 */
class GroupImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_group_images';
    }
    
    /**
     * @inheritdoc
     */
    
    /**
     * @inheritdoc
     */
    
    public function updategroupimages($season_id,$mediaArr='') {
		
        if (!$this->validate()) {
            return null;
        }
		if(isset($mediaArr['group_image']) && !empty($mediaArr['group_image'])) {
			foreach($mediaArr['group_image'] as $img) {
				$groupimages 					= new GroupImages();
				$groupimages->season_id  	    = $season_id;
				$groupimages->group_image 		= $img;
				$groupimages->date_created 		= new Expression('NOW()');
				$groupimages->save();
			}
			return true;
		} else {
			return false;
		}
		
		
	}
}
