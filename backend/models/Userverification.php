<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "userverification".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $token
 * @property string $type
 * @property string $status
 * @property string $dateCreated
 */
class Userverification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'userverification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'token', 'type', 'status', 'dateCreated'], 'required'],
            [['user_id'], 'integer'],
            [['type', 'status'], 'string'],
            [['dateCreated'], 'safe'],
            [['token'], 'string', 'max' => 80]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'token' => 'Token',
            'type' => 'Type',
            'status' => 'Status',
            'dateCreated' => 'Date Created',
        ];
    }
}
