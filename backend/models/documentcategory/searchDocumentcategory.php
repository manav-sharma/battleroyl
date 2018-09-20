<?php
namespace backend\models\documentcategory;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\documentcategory\Documentcategory;

/**
 * searchPage represents the model behind the search form about `backend\models\page`.
 */
class searchDocumentcategory extends Documentcategory
{
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'description','status','datetime'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = documentcategory::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        if ($this->datetime != "") {
            $date = strtotime($this->datetime);
            $newdate = date('Y-m-d',$date);
            $query->andFilterWhere(['like', 'datetime', $newdate]);
        }
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'status', $this->status]);
		return $dataProvider;
    }
}
