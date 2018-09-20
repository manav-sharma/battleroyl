<?php

namespace app\models\menu;

use Yii;
use backend\models\page\page;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "menulinks".
 *
 * @property integer $id
 * @property integer $menu_id
 * @property integer $parent_page_id
 * @property integer $page_id
 * @property integer $sort_order
 */
class Menulinks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     
    public $Type;
    public $Custom;
    public $Page;
    public $customURL;
    public $customPage;
     
    public static function tableName()
    {
        return 'menulinks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
				[['menu_id', 'title', 'page_id','Page','Type', 'sort_order','menuType'], 'required'],	
				['title', 'match', 'pattern' => '/^[a-z ]+$/i', 'message' => 'Name only accepts alphabets and space.'],			
				[['menu_id', 'parent_page_id', 'page_id', 'sort_order'], 'integer'],
				['Custom', 'required', 'when' => function ($model) {
					return $model->menuType == 'Url';
				}, 'whenClient' => "function (attribute, value) {
					return $('.yt').val() == '1';
				}"],
				['Custom', 'url', 'defaultScheme' => 'http'],
				['title', 'filter', 'filter' => 'trim'],
				['title', 'string', 'min' => 2, 'max' => 10]          
			];			
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_id' => 'Menu ID',
			'title' => 'Name',
			'menuUrl' => 'Url',
            'parent_page_id' => 'Parent',
            'page_id' => 'Page ID',
            'sort_order' => 'Sort Order',
        ];
    }
    /**
     * @get pages 
     */    
	public function getPages() {
			return $this->hasOne(page::className(), ['page_id' => 'id']);
	}
    /**
     * @get page information
     */
	public function getPagesInfo($id) {
			$models = Menulinks::find()->where(['menu_id' =>$id])->all();
			return $models;
	}
    /**
     * @get pages list
     */	
	public function getPagesList() {
	   $models = page::find()->asArray()->all();
	   return ArrayHelper::map($models, 'id','pageName');
	}
    /**
     * @get page parent
     */	
	public function getPageParentList() {
	   $models = Menulinks::find()->where(['parent_page_id' =>0])->all();
	   return ArrayHelper::map($models, 'id','title');
	}
    /**
     * @get menu Id
     */	
	public function getMenuId($id) {
	   $models = Menulinks::find()->where(['id' => $id])->all();
	   return $models;
	}
		
}
