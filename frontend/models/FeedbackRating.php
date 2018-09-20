<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class FeedbackRating extends ActiveRecord {
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%feedback_rating}}';
    }

    /**
     * @inheritdoc
     */
    
    public function rules()
    {
        return [
            ['starrating', 'required','message'=>Yii::t('yii','Please select the stars to give your rating.')],
            ['comment', 'required'],
			[['comment'], 'string', 'max' => 2000],
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'starrating' => Yii::t('yii','How many stars would you like to rathe this Insider?'),
            'comment' => Yii::t('yii','Comments'), 
        ];
    }
    
    /**
     * one on one relation between booking and feedback_rating
     * @return object
     */
    public function getBooking()
    {
        return $this->hasOne(Jobs::className(), ['booking_id' => 'booking_id']);
    }
    

    
}
