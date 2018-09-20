<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace backend\models\partners;
use backend\models\partners\Partners;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
* BusinessOpportunity represents the model behind the search form about Bussiness.
*/
class PartnerSearch extends Model
{
    public $id;
    public $property_type;
    public $title;
    public $price;
    public $documents;
    public $photos;
    public $copy_of_deed;
    public $copy_of_licenses;
    public $copy_of_power_of_attorney;
    public $description;
    public $status;
    public $datetime;
    public $user_id;
    public $propertytype;

    /** @inheritdoc */
    public function rules() {
        return [
         [['id','property_type','user_id'], 'integer'],
          [['title','price','documents','documents','photos','description','copy_of_deed','copy_of_licenses','copy_of_power_of_attorney','status','datetime','propertytype'], 'safe'],
        ];
    }

    /**
    * @param $params
    *
    * @return ActiveDataProvider
    */
    public function search($params) {
		$query = Partners::find();
		$query->joinWith(['propertytype']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]] 
        ]);

        $dataProvider->sort->attributes['propertytype'] = [
                'asc' => ['property_types.name' => SORT_ASC],
                'desc' => ['property_types.name' => SORT_DESC],
        ];
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        
        if ($this->datetime != "") {
            $date = strtotime($this->datetime);
            $newdate = date('Y-m-d',$date);
            $query->andFilterWhere(['like', 'datetime', $newdate]);
        }

        $query->andFilterWhere(['like', 'title', $this->title])
                ->andFilterWhere(['like', 'partners.description', $this->description])
                ->andFilterWhere(['like', 'price', $this->price])
                ->andFilterWhere(['like', 'property_types.name', $this->propertytype])
                ->andFilterWhere(['like', 'partners.status', $this->status]);
        return $dataProvider;
    }
}
