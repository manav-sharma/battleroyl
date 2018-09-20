<?php
namespace backend\models\realestate;

use Yii;
use backend\models\documentcategory\Documentcategory;
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
class Realestate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_real_estate_market';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'datetime',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['filename','title','description'], 'string'],
                [['cat_id','title','description'], 'required'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id'		 	=> 'ID',
            'cat_id' 		=> 'Category Id',
            'title' 		=> 'Title',
            'description' 	=> 'Description',
            'document_type' => 'Document Type',
            'datetime' 		=> 'Datetime',
            'status'	    => 'Status',
        ];
    }

    /**
     * @getCategory: get categories
     */
    public function getCategory() {
        return $this->hasOne(Documentcategory::className(), ['id' => 'cat_id']);
    }    
}
