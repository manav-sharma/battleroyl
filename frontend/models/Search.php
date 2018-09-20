<?php
namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Search Model
 */
class Search extends Model
{
    public $search_destination;
    public $travellers;
    public $searchdate;
  
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }
    
    /**
     * @rules
     */
    public function rules()
    {
        return [
            [['search_destination','searchdate','travellers'], 'required'],
            [['searchdate'], 'date', 'format' => 'php:Y-m-d','message'=>Yii::t('yii','Invalid date format')],
            ['searchdate', 'compare', 'compareValue' => date("Y-m-d"), 'operator' => '>=','message'=>Yii::t('yii','Please select a valid date')],
        ];
    }

	/**
     * @attributeLabels
     */
    public function attributeLabels()
    {
        return [];
    }
   
} 
