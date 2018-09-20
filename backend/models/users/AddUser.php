<?php

namespace backend\models\users;

use backend\models\users\Users;
use yii\base\Model;
use Yii;

/**
 * AddMemberForm
 */
class AddUser extends Users { 

    public $firstname;
    public $lastname;
    public $email;
    public $phone;
    public $address;
    public $password;
    public $repeat_password;
    public $profile_image;
    public $status;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['firstname', 'lastname', 'email', 'password', 'repeat_password','phone','address'], 'required'],
            ['firstname', 'match', 'pattern' => '/^[a-z ]+$/i', 'message' => 'First Name only accepts alphabets and space.'],
            ['firstname', 'filter', 'filter' => 'trim'],
            [['firstname','lastname'], 'string', 'max' => 40],
            ['lastname', 'match', 'pattern' => '/^[a-z ]+$/i', 'message' => 'Last Name only accepts alphabets and space.'],
            ['lastname', 'filter', 'filter' => 'trim'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\backend\models\users\Users', 'message' => 'This email address has already been taken.'],
            ['phone', 'integer','min' => 8],
            ['password', 'string', 'min' => 8, 'max' => 20],
            ['repeat_password', 'compare', 'compareAttribute' => 'password'],
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
     * signup user.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup($postArr) {
        if (!$this->validate()) {
            return null;
        }		

        $user = new Users();
        $user->firstname 		= $this->firstname;
        $user->lastname 		= $this->lastname;
        $user->email 			= $this->email;
        $user->phone 			= $this->phone;
        $user->address 			= $this->address;
        $user->status 			= '1';
        $user->profile_image 	= $this->profile_image;				
		$user->date_created 	= date("Y-m-d H:i:s");					
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->password_hash = $this->setPassword($this->password_hash);
            return true;
        } else {
            return false;
        }
    }
}
