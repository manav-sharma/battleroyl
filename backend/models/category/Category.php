<?php

namespace app\models\category;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $category_id
 * @property string $category_name
 * @property integer $parent_id
 * @property string $category_status
 * @property string $category_date_created
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_name', 'category_status'], 'required'],
            [['category_status'], 'string'],
            [['category_date_created'], 'safe'],
            [['category_name'], 'string', 'min' => 1 , 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'category_name' => 'Category Name',
            'parent.category_name'=> 'Category Parent',
            'category_status' => 'Category Status',
            'category_date_created' => 'Category Date Created',
        ];
    }
    /**
     * @inheritdoc
     */	
	public function getParent()
    {
        return $this->hasOne(Category::className(), ['parent_id' => 'category_id']);
    }
}

