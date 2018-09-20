<?php
namespace frontend\models\users;

//use common\models\User;
use frontend\models\users\Users;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class AddMemberForm extends Model
{
    public $usrFirstname;
    public $usrLastname;
    public $email;
    public $password;
    public $repeat_password;
    public $usrProfileImage;
    public $gender;
    public $usrCurrency;
    public $usrCountry;
    public $usrDescription;
    public $accept_terms;
    public $usrState;
    public $usrCity;
    public $phonecode;
    public $usrPhone;
    public $usrDayPrice;
    public $usrHourPrice;
    public $usrInterests;
    public $dob;
    public $usrIdDocument;
    public $usrLanguage;
    public $usrAddress;
    public $country_sortname;

    public $chkusrInterests;
    public $chkusrLanguage;
    
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['usrFirstname','usrLastname','email','password','repeat_password','usrCountry','usrState','usrCity','gender','usrInterests','usrDayPrice','usrHourPrice','usrDescription','phonecode', 'usrPhone','usrLanguage','usrCurrency','country_sortname','usrAddress','chkusrInterests', 'chkusrLanguage'], 'required' ],
                ['password', 'string', 'min' => 6, 'max' => 20, 'on'=>'update' ],
                ['repeat_password', 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => false, 'message'=>"Passwords don't match", 'on'=>'update' ],
                ['usrFirstname', 'match', 'pattern' => '/^[a-z ]+$/i', 'message' => Yii::t('yii','First Name only accepts alphabets and space.')],
                ['usrLastname', 'match', 'pattern' => '/^[a-z ]+$/i', 'message' => Yii::t('yii','Last Name only accepts alphabets and space.')],
                [['usrFirstname', 'usrLastname'], 'string',  'min' => 1, 'max' => 60, 'on'=>'update' ],
                ['usrPhone', 'number'],
                [['usrPhone'], 'string', 'min' => 5, 'max' => 15,'message'=> Yii::t('yii','Phone number should be greater than 5 and less than 15')],
                [['email'], 'unique', 'on'=>'update' ],
                [['dob'], 'safe'],
				['email', 'email'],
				['email', 'string', 'max' => 80],
				['email', 'unique', 'targetClass' => '\frontend\models\users\Users', 'message' => Yii::t('yii','This email address has already been taken.')],                
				['password', 'string', 'min' => 8, 'max' => 20],
				['repeat_password','compare','compareAttribute'=>'password'],				
				[['usrDayPrice','usrHourPrice','usrCurrency'], 'integer'],
				[['usrInterests', 'usrLanguage', 'usrPhone'], 'safe'],                
                [['chkusrInterests', 'chkusrLanguage'], 'checkCount'],               
                [['usrDayPrice','usrHourPrice'], 'compare', 'compareValue' => 0, 'operator' => '>'],
                ['usrDescription','string', 'min' => 150, 'max' => 1000],
                array('accept_terms', 'compare', 'compareValue' => 1, 'message' => Yii::t('yii','You should accept term to use our service.')),
        ];
    }
    
    public function checkCount($attribute, $params)
    {
        // no real check at the moment to be sure that the error is triggered
        if(count(explode(',',$this->$attribute)) <= 5)
            return;
            
        $attrLabel = '';
        switch($attribute)
        {
            case 'chkusrInterests':
                $attrLabel = 'Interest';
                break;
                
            case 'chkusrLanguage':
                $attrLabel = 'Language';
                break;
                
        }
        $this->addError($attribute, Yii::t('yii', "You can choose max 5 $attrLabel."));
    }
    
     /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }
    
    
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' 		=> Yii::t('yii','ID'),
            'usrFirstname'      => Yii::t('yii','First name'),
            'usrLastname'       => Yii::t('yii','Last name'),
            'email'	         => Yii::t('yii','Email address'),
            'dob'          	 => Yii::t('yii','Date of birth'),
            'phonecode'     	 => Yii::t('yii','Country Code'),
            'usrPhone'     	 => Yii::t('yii','Phone number'),
            'usrCurrency'	     => Yii::t('yii','Currency'),
            'usrCountry'	     => Yii::t('yii','Country'),
            'usrProfileImage'	 => Yii::t('yii','Profile Picture'),
            'gender'	 		 => Yii::t('yii','Gender'),
            'usrState'	 		 => Yii::t('yii','State/County'),
            'usrCity'	 		 => Yii::t('yii','City'),
            'usrAddress'	     => Yii::t('yii','Insider area'),
            'password'	 		 => Yii::t('yii','Password'),
            'repeat_password'	 => Yii::t('yii','Confirm Password'),
            'usrInterests' 	 => Yii::t('yii','Interests'),
            'usrDayPrice'  	 => Yii::t('yii','Daily price'),
            'usrHourPrice'  	 => Yii::t('yii','Hourly price'),
            'usrIdDocument'	 => Yii::t('yii','ID document'),
            'usrDescription'	 => Yii::t('yii','Descriptions'),
            
            'chkusrInterests'	 => Yii::t('yii','Interests'),
            'chkusrLanguage'	 => Yii::t('yii','Languages'),
        ];
    }

    /**
     * signup user.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signupWithMember($data)
    {
        $val['usrLanguage'] = isset($this->usrLanguage)?array_filter($this->usrLanguage):[];
        $this->chkusrLanguage = $languages = implode(",",$this->usrLanguage);
        $val['usrInterests'] = isset($this->usrInterests)?array_filter($this->usrInterests):[];
        $this->chkusrInterests = $interests  =   implode(",",$this->usrInterests);
        
        if (!$this->validate()) {
            return null;
        }
        
        if(isset($this->usrInterests) && count($this->usrInterests) == 1)   {
            $interests = $interests.',';
        }
		     
        $lan  = Yii::$app->language;
        $user = new Users();
        
        $user->usrFirstname 	= $this->usrFirstname;
        $user->usrLastname  	= $this->usrLastname;
        $user->username			= time();
        $user->gender       	= $this->gender;
        $user->email        	= $this->email;
        $user->status       	= PENDING;
        $user->country_sortname = $this->country_sortname;
        $user->usrCurrency   	= (isset($this->usrCurrency) ? $this->usrCurrency : '');        
        $user->usrAddress   	= $this->usrAddress;
        $user->usrCountry   	= $this->usrCountry;
        $user->usrState     	= $this->usrState;
        $user->usrCity      	= $this->usrCity;
        //$user->dob     			= (isset($this->dob) ? date("Y-m-d",strtotime($this->dob)) : '');
        $user->dob     			= $data['year']."-".$data['month']."-".$data['day'];
        $user->phonecode     	= $this->phonecode;        
        $user->usrPhone     	= $this->usrPhone;        
        $user->usrProfileImage  = (isset($this->usrProfileImage) ? $this->usrProfileImage : '');
        $user->usrIdDocument  	= (isset($this->usrIdDocument) ? $this->usrIdDocument : '');   
        $user->usrDescription   = $this->usrDescription;
        $user->usrCountry  		= $this->usrCountry;
        $user->usrRegistrationType = EMAIL;
        $user->setPassword($this->password);      
        $user->usrType      	= MEMBER;
        $user->usrLanguage      = (isset($languages) && $languages != '' ? $languages : 'en');
        $user->usrInterests 	= $interests;
        $user->usrDayPrice  	= $this->usrDayPrice;
        $user->usrHourPrice  	= $this->usrHourPrice;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user->id : null;
    }
        
    /**
     * @inheritdoc
     * @param type $insert
     * @return boolean
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
           $this->password_hash = $this->setPassword($this->password_hash);
           return true;
        }else{
           return false;
        }
    }
}
