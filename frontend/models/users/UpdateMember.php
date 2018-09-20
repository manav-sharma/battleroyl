<?php
namespace frontend\models\users;

use frontend\models\users\Users;
use yii\base\Model;
use Yii;


class UpdateMember extends Users {
        public $id;
        public $usrFirstname;
        public $usrLastname;
        public $username;
        public $dob;
        public $gender;
        public $auth_key;
        public $password;
        public $repeat_password;
        public $usrCountry;
        public $usrCurrency;
        public $chkusrInterests;
        public $chkusrLanguage;
    
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['usrFirstname','usrLastname','email','usrCountry','usrCurrency','usrState','usrCity','gender','usrInterests','usrDayPrice','usrHourPrice','usrDescription','phonecode','usrPhone','chkusrInterests', 'chkusrLanguage'], 'required', 'on'=>'update' ],
                ['password', 'string', 'min' => 8, 'max' => 20, 'on'=>'update' ],
                ['repeat_password', 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => false, 'message'=>"Passwords don't match", 'on'=>'update' ],
                ['usrFirstname', 'match', 'pattern' => '/^[a-z ]+$/i', 'message' => Yii::t('yii','First Name only accepts alphabets and space.')],
                ['usrLastname', 'match', 'pattern' => '/^[a-z ]+$/i', 'message' => Yii::t('yii','Last Name only accepts alphabets and space.')],
                [['usrFirstname', 'usrLastname'], 'string',  'min' => 1, 'max' => 60, 'on'=>'update' ],
                ['usrPhone', 'number'],
                [['usrPhone'], 'string', 'min' => 5, 'max' => 15,'message'=> Yii::t('yii','Phone number should be greater than 5 and less than 15')],
                ['email', 'email'],
                [['email'], 'unique', 'on'=>'update' ],
                [['dob'], 'safe'],
                ['email', 'string', 'max' => 80],
				
                [['usrDayPrice','usrHourPrice'], 'integer'],
                [['usrInterests', 'usrLanguage', 'usrPhone'], 'safe'],                
                [['chkusrInterests', 'chkusrLanguage'], 'checkCount'],                
                
                [['usrDayPrice','usrHourPrice'], 'compare', 'compareValue' => 0, 'operator' => '>'],
                ['usrDescription','string', 'min' => 150, 'max' => 1000],
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
    public function attributeLabels() {
        return [
            'id' 				 => Yii::t('yii','ID'),
            'usrFirstname'      => Yii::t('yii','First name'),
            'usrLastname'       => Yii::t('yii','Last name'),
            'email'	         => Yii::t('yii','Email address'),
            'dob'          	 => Yii::t('yii','Date of birth'),
            'phonecode'     	 => Yii::t('yii','Country Code'),
            'usrPhone'     	 => Yii::t('yii','Phone number'),
            'usrCountry'	     => Yii::t('yii','Country'),
            'usrCurrency'	     => Yii::t('yii','Currency'),
            'usrAddress'	     => Yii::t('yii','Insider area'),
            'usrDescription'	 => Yii::t('yii','Descriptions'),
            'usrProfileImage'	 => Yii::t('yii','Profile Picture'),
            'gender'	 		 => Yii::t('yii','Gender'),
            'usrState'	 		 => Yii::t('yii','State/County'),
            'usrCity'	 		 => Yii::t('yii','City'),
            'password'	 		 => Yii::t('yii','New Password'),
            'repeat_password'	 => Yii::t('yii','Confirm New Password'),
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
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id]);
    }
    
    /**
     * becomeMember.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function becomeMember($id,$val) {
        $val['usrInterests'] = isset($val['usrInterests'])?array_filter($val['usrInterests']):[];
        $this->chkusrInterests = $interests = implode(",",$val['usrInterests']);
        $val['usrLanguage'] = isset($val['usrLanguage'])?array_filter($val['usrLanguage']):[];
	$this->chkusrLanguage = $languages = implode(",",$val['usrLanguage']);
        
        if (!$this->validate()) {
            return null;
        }

        if(isset($val['usrInterests']) && count($val['usrInterests']) == 1) {
            $interests=$interests.',';
        }
				
        $this->scenario 	 = 'update';
        $user = Users::findOne(['id' => $id]);

        $user->usrFirstname 	= $val['usrFirstname'];
        $user->usrLastname  	= $val['usrLastname'];
        $user->gender       	= $val['gender'];
        $user->email        	= $val['email'];
        $user->usrCountry   	= $val['usrCountry'];
        $user->country_sortname = $val['country_sortname'];
        $user->usrCurrency   	= (isset($val['usrCurrency']) ? $val['usrCurrency'] : '');
        $user->usrState     	= $val['usrState'];
        $user->usrCity      	= $val['usrCity'];
        $user->dob     			= $val['year']."-".$val['month']."-".$val['day'];
        $user->phonecode = $val['phonecode'];
        $user->usrPhone     	= $val['usrPhone'];
        if(!empty($val['usrProfileImage'])) {
			$user->usrProfileImage 	= $val['usrProfileImage'];
		}

		if(!empty($val['usrIdDocument'])) {
			$user->usrIdDocument 	= $val['usrIdDocument'];
		}
        $user->usrType     		= MEMBER;
        $user->usrDayPrice  	= $val['usrDayPrice'];
        $user->usrHourPrice  	= $val['usrHourPrice'];
        $user->usrDescription  	= $val['usrDescription'];
        $user->usrAddress	  	= $val['usrAddress'];
        $user->usrInterests 	= $interests;
        $user->usrLanguage      = (isset($languages) && $languages != '' ? $languages : 'en');
        return $user->save() ? $user : null;
    }
}
