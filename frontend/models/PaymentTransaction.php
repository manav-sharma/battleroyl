<?php
namespace frontend\models;
use Yii;

/**
 * This is the model class for table "payment_transaction".
 *
 * @property integer $payment_transaction_id
 */
class PaymentTransaction extends \yii\db\ActiveRecord
{
    /**
     * @ Function Name		: tableName
     * @ Function Params	: NA
     * @ Function Purpose 	: get table name
     * @ Function Returns	: String
     */
    public static function tableName() {
        return 'payment_transaction';
    }

    /**
     * @ Function Name		: rules
     * @ Function Params		: NA 
     * @ Function Purpose 	: define the validations rules to apply on submitted form data
     * @ Function Returns	: array
     */
    public function rules() {
        return [
            [['user_id','amount','trans_id','payment_type','payment_status'], 'required'],
        ];
    }

    /**
     * @ Function Name		: attributeLabels
     * @ Function Params	: NA 
     * @ Function Purpose 	: defing the custom label for fields
     * @ Function Returns	: array
     */
    public function attributeLabels() {
        return [
            'trans_id' => Yii::t('yii','Transaction Id'),
        ];
    }
}
