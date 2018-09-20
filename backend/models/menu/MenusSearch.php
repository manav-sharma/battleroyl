<?php

namespace app\models\menu;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\menu\Menus;

/**
 * MenusSearch represents the model behind the search form about `app\models\Menus`.
 */
class MenusSearch extends Menus
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mnuId'], 'integer'],
            [['mnuName', 'menuSlug', 'mnuStatus', 'mnuDateCreated'], 'safe'],
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
        $query = Menus::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'mnuId' => $this->mnuId,
            'date(mnuDateCreated)' => $this->mnuDateCreated?date('Y-m-d',strtotime($this->mnuDateCreated)):'',
        ]);

        $query->andFilterWhere(['like', 'mnuName', $this->mnuName])
            ->andFilterWhere(['like', 'menuSlug', $this->menuSlug])
            ->andFilterWhere(['like', 'mnuStatus', $this->mnuStatus]);

        return $dataProvider;
    }
}
