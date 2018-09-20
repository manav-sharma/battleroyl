<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace backend\models\realestate;

use backend\models\realestate\Realestate;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DocumentSearch represents the model behind the search form about User.
 */
class RealestateSearch extends Model
{
    /** @var string */
    public $id;
    public $cat_id;
    public $title;
    public $filename;
    public $description;
    public $category;
    public $document_type;
    public $datetime;
    public $status;

    /** @inheritdoc */
    public function rules() {
        return [
         [['id'], 'integer'],
          [['title','cat_id','description','document_type','datetime','status','category'], 'safe'],
        ];
    }

    /**
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
		$query = Realestate::find();
		//$query->joinWith(['category']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]] 
        ]);
		/*
        $dataProvider->sort->attributes['category'] = [
                'asc' => ['category.name' => SORT_ASC],
                'desc' => ['category.name' => SORT_DESC],
        ];
        */
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
              //  ->andFilterWhere(['like', 'category.name', $this->category])
                ->andFilterWhere(['like', 'document_type', $this->document_type])
                ->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'status', $this->status]);
        return $dataProvider;
    }
}
