<?php

namespace app\models\menu;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\menu\Menulinks;
use yii\db\Query;

/**
 * MenulinkSearch represents the model behind the search form about `app\models\Menulinks`.
 */
class MenulinkSearch extends Menulinks
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'menu_id', 'parent_page_id', 'page_id', 'sort_order'], 'integer'],
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
		if(isset($params['id']) && !empty($params['id'])) {
			$this->menu_id = $params['id']; 
		}
        $query = Menulinks::find();
			
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'menu_id' => $this->menu_id,
            'parent_page_id' => $this->parent_page_id,
            'page_id' => $this->page_id,
            'sort_order' => $this->sort_order,
        ]);

        return $dataProvider;
    }
}
