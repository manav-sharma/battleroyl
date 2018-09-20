<?php
namespace backend\models\banner;
use yii\db\Query;
use backend\models\banner\Banner;
use yii\base\Model;
use Yii;

/**
 * AddBannerForm
 */
class AddBannerForm extends Model {

    public $title;
    public $description;
    public $dateCreated;
    public $banner_assign;
    public $status;
    public $bannerImage;
    

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title', 'description','banner_assign'], 'required'],
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
            'bannerImage' => 'Image',
            'description' => 'Description',
            'dateCreated' => 'Date',
            'banner_assign' => 'Assign Banner Image',
            'status' => 'Status',
        ];
    }

    /**
     * signup user.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup() {
        if (!$this->validate()) {
            return null;
        }

        ################## Add New Banner ##################
        $banner = new Banner();
        $banner->title = $this->title;
        $banner->description = $this->description;
        $banner->bannerImage = $this->bannerImage;
        $banner->banner_assign = $this->banner_assign;
        return $banner->save() ? $banner : null;
        ##################################################
    }
    
    
    public function checkBanner($postvalue) {
		$query    = new Query;  	
		$pageAssigned = $postvalue['banner_assign'];
        $query->select('*')->from('banner')->where(['banner_assign' => $pageAssigned]);
        return $query->createCommand()->queryAll(); 
		
	}	
    

}
