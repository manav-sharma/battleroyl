<?php

namespace app\models\coupon;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\coupon\Coupon;

/**
 * CouponSearch represents the model behind the search form about `app\models\Coupon`.
 */
class CouponSearch extends Coupon
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'discount'], 'integer'],
            [['couponCode', 'description','discountType' , 'validFrom', 'validTill', 'dateCreated'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Coupon::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'discount' => $this->discount,
       
        ]);

        $query->andFilterWhere(['like', 'couponCode', $this->couponCode])
        ->andFilterWhere(['like', 'discountType', $this->discountType])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'validFrom', $this->validFrom])
            ->andFilterWhere(['like', 'validTill', $this->validTill])
            ->andFilterWhere(['like', 'dateCreated', $this->dateCreated]);


        return $dataProvider;
    }
}
