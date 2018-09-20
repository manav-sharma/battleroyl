<?php
namespace backend\models\properties;
use backend\models\properties\Properties;
use backend\models\properties\Documents;
use yii\base\Model;
use Yii;

/**
 * SendMessage
 */
class SendMessage extends Model {
    public $message;
    public $userids;
    public $username;
    public $notification_type;
    /**
    * @inheritdoc
    */
    public function rules() {
        return [
            [['message','userids','notification_type'], 'required'],
            [['message'], 'string', 'max' => 200],
        ];
    }
}
