<?php
namespace backend\models\message;

use backend\models\message\message;
use yii\base\Model;
use Yii;

use yii\behaviors\TimestampBehavior;

/**
 * AddMessageForm
 */
class AddMessageForm extends Model
{
    public $user_to;
    public $subject;
    public $message;
    
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message', 'subject'], 'string'],
            [['message','subject','user_to'], 'required'],
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
     * send message
     *
     * @return message|null the saved model or null if saving fails
     */
    public function sendmessage()
    {
        if (!$this->validate()) {
            return null;
        }
        $msg = new Message();
        $msg->user_from 		= 1;
        $msg->user_to  			= $this->user_to;
        $msg->subject  			= $this->subject;
        $msg->message  			= $this->message;
        $msg->date_created      = date("Y-m-d H:m:s");
        $msg->is_trashed        = '0';
        $msg->status        	= '1';
        $msg->send_status       = '1';
        return $msg->save() ? $msg : null;
    }

	
    
}
