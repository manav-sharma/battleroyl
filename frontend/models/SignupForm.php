<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $fullname;
    public $email;
    public $password;
    public $gender;   
    public $dob;
    public $captcha;
   
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('yii','This username is already taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('yii','This email address is already taken.')],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['captcha', 'required'],
            ['captcha', 'captcha'],
            ['gender','required'],
            ['fullname', 'required'],
            ['dob', 'required']
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;		
        $user->fullname = $this->fullname;
        $user->gender 	= $this->gender;
		$user->dob 		= date('Y-m-d',strtotime($this->dob));
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
    
    	 /**
     * Finds the CrudTest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CrudTest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    
      function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
			return false;
            throw new NotFoundHttpException(Yii::t('yii','The requested page does not exist.'));
        }
    }
} 
