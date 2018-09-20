<?php
namespace backend\models\users;
use common\models\User;
use yii\base\Model;
use Yii;

/**
 * UpdateUser
 */
class UpdateUser extends User
{
    public $firstname;
    public $lastname;
    public $email;
    public $phone;
    public $password;
    public $repeat_password;
    public $profile_image;
    public $address;
    public $status;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['firstname', 'lastname','email', 'address','phone'], 'required'],
            ['firstname', 'match', 'pattern' => '/^[a-z ]+$/i', 'message' => 'First Name only accepts alphabets and space.'],
            ['firstname', 'filter', 'filter' => 'trim'],
            [['firstname','lastname'], 'string', 'max' => 40],
            ['lastname', 'match', 'pattern' => '/^[a-z ]+$/i', 'message' => 'Last Name only accepts alphabets and space.'],
            ['lastname', 'filter', 'filter' => 'trim'],
            ['email', 'string', 'max' => 255],
            ['email', 'email'],
            ['email','custom_function_validation'],
            ['password', 'string', 'min' => 8, 'max' => 20],
            ['phone', 'integer','min' => 8],
            ['repeat_password', 'compare', 'compareAttribute' => 'password'],
        ];
    }
    
    public function custom_function_validation($attribute){
		if ($this->$attribute) {
			$check = $this->checkUserEmail($this->$attribute,$this->id);
			if($check == 1) {
				return true;
			} else {
				$this->addError($attribute, 'This email address has already been taken.');
				return false;
			}	
		}
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'firstname' 		=> 'First Name',
            'lastname' 			=> 'Last Name',
            'email' 			=> 'Email',
            'profile_image' 	=> 'Profile Image',
            'address' 			=> 'Address',
        ];
    }
    
    
    public function checkUserEmail($email,$userid) {
		$getquery =  Users::find()->where(['id' => $userid])->one();
		$query    =  Users::find()->where(['email' => $email])->one();
		if(empty($query)){
			return true;
		} else {
			if($query['email'] == $getquery['email']){
				return true;
			} else {
				return false;	
			}
		}
	}

     /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id]);
    }

    /**
     * update member.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function updateUser($id) {
        if (!$this->validate()) {
            return null;
        }
        
        $user = Users::findOne(['id' => $id]);        
        $user->firstname 		= $this->firstname;
        $user->lastname 		= $this->lastname;
        $user->email 			= $this->email;
        $user->phone 			= $this->phone;
        $user->address 			= $this->address;
        if($this->profile_image != '')
            $user->profile_image = $this->profile_image;     

        if($this->password != '')
            $user->setPassword($this->password);

        return $user->save() ? $user : null;
    }
}
