<?php
namespace backend\models\banner;
use yii\db\Query;
use yii\base\Model;
use Yii;

/**
 * UpdateBanner
 */
class UpdateBanner extends Banner
{
    public $title;
    public $bannerImage;
    public $description;
    public $dateCreated;
    public $banner_assign;
    public $status;
	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			 [['title', 'description','banner_assign'], 'required'],
			 ['title', 'string', 'max' => 60],   
			 ['description', 'string', 'max' => 250],			 
        ];
        
    }

    
      /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }
    
    /**
     * update banner.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function updateBanner($id)
    {
        if (!$this->validate()) {
            return null;
        }

        $banner = Banner::findOne(['id' => $id]);
        $banner->title = $this->title;
        $banner->description  = $this->description;
        $banner->banner_assign = $this->banner_assign;
        $banner->status 	    = '1';
        if($this->bannerImage != '' ) 
        $banner->bannerImage 	= $this->bannerImage;
        return $banner->save() ? $banner : null;
    }
     
    
     public function checkBanner($postvalue,$id) {
		$query    = new Query;  	
		$pageAssigned = $postvalue['banner_assign'];
        $query->select('*')->from('banner')->where(['banner_assign' => $pageAssigned])->andWhere(['not in','id',$id]);
        //echo $query->createCommand()->RawSql; 
        return $query->createCommand()->queryAll(); 
		
	}	 
     
}
