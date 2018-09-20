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
class ChangePassword extends Users {

    public $password;
    public $repeat_password;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
			[['password', 'repeat_password'], 'required'],
            ['password', 'string', 'min' => 8, 'max' => 20],
            ['repeat_password', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {

        return [
            'password' 			    => 'Password',
            'repeat_password' 		=> 'Repeat Password',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id]);
    }

    
    /**
     * update password.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function UpdatePassword($id) {
        if (!$this->validate()) {
            return null;
        }
        $user = Users::findOne(['id' => $id]);
        $user->setPassword($this->password); 
        return $user->save() ? $user : null;
    }

}

