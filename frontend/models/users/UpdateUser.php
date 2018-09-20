<?php

namespace frontend\models\users;

use frontend\models\users\Users;
use yii\base\Model;
use Yii;

/**
 * This is the model class for table "user".
 
  /**
 * Signup form
 */
class UpdateUser extends Users {

    public $firstname;
    public $lastname;
    public $email;
    public $phone;
    public $address;
    public $profile_image;
    //public $status;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['firstname', 'lastname'], 'required'],
            ['firstname', 'match', 'pattern' => '/^[a-z ]+$/i', 'message' => 'First Name only accepts alphabets and space.'],
            ['firstname', 'filter', 'filter' => 'trim'],
            [['firstname','lastname'], 'string', 'max' => 40],
            ['lastname', 'match', 'pattern' => '/^[a-z ]+$/i', 'message' => 'Last Name only accepts alphabets and space.'],
            ['lastname', 'filter', 'filter' => 'trim'],
            ['email', 'string', 'max' => 255],
            ['email', 'email'],
            ['phone', 'integer', 'min' => 6,],
            [['email','phone','address','profile_image'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {

        return [
            'firstname' 	=> 'First Name',
            'lastname' 		=> 'Last Name',
            'email' 		=> 'Email',
            'profile_image' => 'Profile Image',
            'address' 		=> 'Address',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id]);
    }

    /**
     * update user.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function updateUser($id) {
		//print_r($id); exit();
        if (!$this->validate()) {
            return null;
        }
        //$this->scenario = 'update';
        $user = Users::findOne(['id' => $id]);
        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->address = $this->address;
         if($this->profile_image != '')
            $user->profile_image = $this->profile_image; 
        
		
        return $user->save() ? $user : null;
    }
    
    /**
     * update password.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function UpdatePassword($id, $val) {
        if (!$this->validate()) {
            return null;
        }

        $user = Users::findOne(['id' => $id]);
        
        if (isset($val['password']) && !empty($val['password'])) {
            $user->setPassword($val['password']); 
        }

        return $user->save() ? $user : null;
    }

}
