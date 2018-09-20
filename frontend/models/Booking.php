<?php

namespace frontend\models;

use Yii;

/**
 * Inerests model
 *
 * @property integer $id
 * @property string $Inerests
 */
class Booking extends \yii\db\ActiveRecord {

    public $payment_method;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'booking';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['booked_from_date', 'booked_to_date', 'payment_method'], 'required'],
            [['no_of_hours'], 'integer'],
            ['booked_from_date', 'validateDates'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'booked_from_date' 	=> Yii::t('yii','From date'),
            'booked_to_date' 	=> Yii::t('yii','To date'),
        ];
    }

   /**
     * validateDates
     * @param N/A
     * @return array
     */
    public function validateDates() {
        if (strtotime($this->booked_from_date) > strtotime($this->booked_to_date)) {
            $this->addError('booked_from_date', Yii::t('yii', 'Please select a valid date range'));
            $this->addError('booked_to_date', Yii::t('yii', 'Please select a valid date range'));
        }
    }

   /**
     * isBooked
     * @param $id
     * @return array
     */
    public function isBooked($id) {
        $fromDate = $this->booked_from_date;
        $toDate = $this->booked_to_date;

        $WHERE = "booking_status = '1' AND guyde_user_id = $id AND (CAST('$fromDate' AS DATE) BETWEEN booking.booked_from_date and booking.booked_to_date OR CAST('$toDate' AS DATE) BETWEEN booking.booked_from_date and booking.booked_to_date)";
        $query = new yii\db\Query;
        $query->select('booking_id')
                ->from('booking')
                ->where($WHERE);
        $Result = $query->createCommand()->queryAll();
        if (empty($Result))
            return false;
        else
            return true;
    }

   /**
     * getCustomer
     * @param N/A
     * @return array
     */    
    public function getCustomer()
    {
        return $this->hasOne(\backend\models\users\Users::className(), ['id' => 'customer_user_id']);
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
    
    public function getMember()
    {
        return $this->hasOne(\backend\models\users\Users::className(), ['id' => 'guyde_user_id'])->from(['uto' => \backend\models\users\Users::tableName()]);
    }

   /**
     * getPaidStatus
     * @param N/A
     * @return array
     */    
    public function getPaidStatus()
    {
        if($this->adminPaymentStatus == '0')
            $status = 'Pending';
        else if($this->adminPaymentStatus == '1')
            $status = 'Paid';
        else if($this->adminPaymentStatus == '2')
            $status = 'Unpaid';
        
        return $status;
    }

}

?>
