<?php
namespace backend\models\memberships;

use yii\base\Model;
use Yii;

/**
 * UpdateNews
 */
class UpdatePackage extends Package
{
    public $name;
    public $image;
    public $description;
    public $datetime;
    public $status;

	/**
     * @inheritdoc
     */
    public function rules() {
        return [
			 [['name','description','amount','membership_type','package_type'], 'required'],
			 ['name', 'string', 'max' => 60],  
			 [['amount'],'number','max' => 100000], 
			 ['description', 'string', 'max' => 250], 				 
        ];
    }

    /**
    * @inheritdoc
    */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id]);
    }
    
    /**
    * update news.
    *
    * @return User|null the saved model or null if saving fails
    */
	public function updatepackage($id) {
        if (!$this->validate()) {
            return null;
        }
        $package 				= Package::findOne(['id' => $id]);
        $package->name 				= $this->name;
        $package->description   	= $this->description;
        $package->amount 			= $this->amount;
        $package->membership_type	= $this->membership_type;
        $package->package_type	= $this->package_type;
        return $package->save() ? $package : null;
	}
}
