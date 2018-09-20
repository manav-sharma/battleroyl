<?php
namespace frontend\models;
use yii\db\Query;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Document model
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $dateCreated
 * @property string $status
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_posts';
    }
    
    public static function findIdentity($id) {
        return static::findOne(['id' => $id]);
    }
	

}
