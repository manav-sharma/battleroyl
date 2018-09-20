<?php
namespace backend\models\memberships;
use backend\models\memberships\Package;
use yii\base\Model;
use Yii;

/**
 * AddNews
 */
class AddPackage extends Model {

    public $name;
    public $image;
    public $description;
    public $amount;
    public $membership_type;
    public $package_type;
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
    public function attributeLabels() {
        return [
            'name' 				=> 'Name',
            'image' 			=> 'Image',
            'description' 		=> 'Description',
            'amount' 			=> 'amount',
            'membership_type'	=> 'membership_type',
            'datetime' 			=> 'Date',
            'status' 			=> 'Status',
        ];
    }

    public function addpackage() {
        if (!$this->validate()) {
            return null;
        }

        $package 					= new Package();     
        $package->name 				= $this->name;
        $package->description   	= $this->description;
        $package->amount 			= $this->amount;
        $package->status 			= ACTIVE;
        $package->membership_type	= $this->membership_type;
        $package->package_type	= $this->package_type;
        return $package->save() ? $package : null;
    }
}
