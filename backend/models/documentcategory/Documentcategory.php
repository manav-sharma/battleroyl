<?php
namespace backend\models\documentcategory;
use Yii;

/**
 * This is the model class for table "interests".
 */
class Documentcategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tbl_document_category';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'description'], 'required'],
            [['name'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' 			=> 'ID',
            'name'		 	=> 'Name',
            'Description' 	=> 'description',
            'status' 		=> 'Status'
        ];
    }
}
