<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class Profile extends Model
{
    public $username;
    public $fullname;
    public $email;
    public $password_hash;
	public $verifyPassword;
    public $gender;   
    public $dob;
   
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('yii','This username is already taken')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('yii','This email address is already taken.')],

           
            ['password_hash', 'string', 'min' => 6],
            ['verifyPassword','compareAttribute' =>'password',],
            
            ['gender','required'],
            
             ['fullname', 'required'],
             ['dob', 'required']
        ];
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
	
	/**
     * update user.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function updateUser($id)
    {
      
   
        $user = User::findOne(['id' => $id]);
        
        $user->username = $this->username;
        $user->fullname = $this->fullname;
        $user->gender 	= $this->gender;
		$user->dob 		= date('Y-m-d',strtotime($this->dob));
        $user->email 	= $this->email;

       
        return $user->save() ? $user : null;
    }
} 
