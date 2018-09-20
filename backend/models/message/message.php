<?php

namespace backend\models\message;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property integer $message_id
 * @property string $conversation_id
 * @property string $user_from
 * @property string $user_to
 * @property string $message
 * @property string $booking_id
 * @property string $subject
 * @property string $date_created
 * @property string $is_trashed
 * @property string $is_read
 */
class message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message', 'subject'], 'string'],
            [['message','subject','user_from','user_to'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'message_id' => 'ID',
            'conversation_id' => 'Conversation id',
            'user_from' => 'From',
            'user_to' => 'To',
            'booking_id' => 'Booking id',
            'date_created' => 'Date created',
            'is_trashed' => 'Is trashed',
        ];
    }
	 /**
	 * @getUserFrom
	 */   
    public function getUserFrom()
    {
        return $this->hasOne(\backend\models\users\Users::className(), ['id' => 'user_from']);
    }
	 /**
	 * @getUserTo
	 */   
    
    public function getUserTo()
    {
        return $this->hasOne(\backend\models\users\Users::className(), ['id' => 'user_to'])->from(['uto' => \backend\models\users\Users::tableName()]);
    }
}
