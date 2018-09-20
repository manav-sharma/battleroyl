<?php

namespace frontend\models;

use Yii;

/**
 * Inerests model
 *
 * @property integer $id
 * @property string $Inerests
 */
class Account extends \yii\db\ActiveRecord {

    //public $account_type;
    //public $account_holder_name;
    //public $accept_currency;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'accountsetting';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['account_type'], 'required'],
            [
                ['paypal_email_address','accept_currency'], 'required','when' => function($model) {
		return $model->account_type == 'PAYPAL';
            }
            ],
            [['paypal_email_address'], 'email'],
            [['account_holder_name','bank_name','IBAN','branch_code','account_number','region'], 'required',  'when' => function($model) {
		return $model->account_type == 'BANK';
            }],
        ];
    }
//'on'=>'BANK', 'on'=>'PAYPAL',
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'paypal_email_address' 	=> Yii::t('yii','Paypal Email Address'),
            'account_holder_name' 	=> Yii::t('yii','Account Holder Name'),
            'bank_name' 			=> Yii::t('yii','Bank Name'),
            'IBAN' 					=> Yii::t('yii','IBAN'),
            'branch_code' 			=> Yii::t('yii','Branch Code'),
            'account_number' 		=> Yii::t('yii','Account Number'),
            'accept_currency' 		=> Yii::t('yii','Currency'),
            'account_type' 			=> Yii::t('yii','Account Type'),
            'region' 				=> Yii::t('yii','Europe Region'),
            'guyde_user_id' 		=> Yii::t('yii','guyde user id'),
            'datetime' 				=> Yii::t('yii','Datetime'),
        ];
    }

   /**
     * getGuyde
     * @param N/A
     * @return array
     */     
    public function getGuyde()
    {
        return $this->hasOne(\backend\models\users\Users::className(), ['id' => 'guyde_user_id']);
    }

}

?>
