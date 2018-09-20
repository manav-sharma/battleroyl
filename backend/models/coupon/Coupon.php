<?php

namespace app\models\coupon;

use Yii;

/**
 * This is the model class for table "coupon".
 *
 * @property integer $id
 * @property string $couponCode
 * @property string $description
 * @property integer $discount
 * @property string $validFrom
 * @property string $validTill
 * @property string $dateCreated
 */
class Coupon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coupon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['couponCode', 'description', 'discount', 'validFrom', 'validTill','discountType'], 'required'],
            [['couponCode'], 'string' , 'min' => 5 , 'max' => 40],
            [['discount'], 'integer'],
            [['discount'], 'string' , 'min' => 1 , 'max' => 3],
            [['description', 'validFrom', 'validTill'], 'string', 'min' => 10 , 'max' => 255],
            [['validTill'],'compare','compareAttribute'=>'validFrom','operator'=>'>','message'=>'{attribute} must be greater than "{compareValue}".']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'couponCode' => 'Coupon Code',
            'description' => 'Description',
            'discountType' => 'Discount Type',
            'discount' => 'Discount',
            'validFrom' => 'Valid From',
            'validTill' => 'Valid Till',
            'dateCreated' => 'Date Created',
        ];
    }
}
