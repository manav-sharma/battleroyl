<?php

namespace app\models\menu;

use Yii;

/**
 * This is the model class for table "menus".
 *
 * @property integer $mnuId
 * @property string $mnuName
 * @property string $menuSlug
 * @property string $mnuStatus
 * @property string $mnuDateCreated
 */
class Menus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mnuName', 'menuSlug'], 'required'],
            ['mnuName', 'match', 'pattern' => '/^[a-z ]+$/i', 'message' => 'Name only accepts alphabets and space.'],
            [['mnuStatus'], 'string'],
            [['mnuDateCreated'], 'safe'],
            [['mnuName'], 'string', 'max' => 25],
            [['menuSlug'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mnuId' => 'ID',
            'mnuName' => 'Name',
            'menuSlug' => 'Slug',
            'mnuStatus' => 'Status',
            'mnuDateCreated' => 'Date Created',
        ];
    }
}
