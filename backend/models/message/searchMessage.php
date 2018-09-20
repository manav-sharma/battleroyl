<?php

namespace backend\models\message;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\message\message;

/**
 * searchMessage represents the model behind the search form about `backend\models\message`.
 */
class searchMessage extends message {

    /**
     * @inheritdoc
     */
    public $userFrom;
    public $userTo;
    public $country;
    
    public function rules() {
        return [
            [['message_id'], 'integer'],
            [['user_from', 'user_to', 'message', 'booking_id', 'subject', 'date_created', 'is_trashed', 'is_read','userFrom','userTo','country'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = message::find();
		$query->joinWith(['userFrom','userTo']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['userFrom'] = [
                'asc' => ['user.usrFirstname' => SORT_ASC],
                'desc' => ['user.usrFirstname' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['userTo'] = [
                'asc' => ['uto.usrFirstname' => SORT_ASC],
                'desc' => ['uto.usrFirstname' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['country'] = [
                'asc' => ['user.usrCountry' => SORT_ASC],
                'desc' => ['user.usrCountry' => SORT_DESC],
        ];
        
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'message_id' => $this->message_id,
        ]);
        if ($this->date_created != "") {
            $date = strtotime($this->date_created);
            $newdate = date('Y-m-d', $date);
            $query->andFilterWhere(['like', 'date_created', $newdate]);
        }
        $query->andFilterWhere(['like', 'user_from', $this->user_from])
                ->andFilterWhere(['like', 'user_to', $this->user_to])
                ->andFilterWhere(['like', 'message', $this->message])
                ->andFilterWhere(['like', 'subject', $this->subject])
                ->andFilterWhere(['like', 'booking_id', $this->booking_id])
                ->andFilterWhere(['like', 'date_created', $this->date_created])
                ->andFilterWhere(['like', 'is_trashed', $this->is_trashed])
                ->andFilterWhere(['like',  'user.usrCountry', $this->country])
                ->andFilterWhere(['like', 'user.usrFirstname', $this->userFrom])
                ->orFilterWhere(['like',  'user.usrLastname', $this->userFrom])
                ->andFilterWhere(['like', 'uto.usrFirstname', $this->userTo])
                ->orFilterWhere(['like',  'uto.usrLastname', $this->userTo])
                ->andFilterWhere(['like', 'is_read', $this->is_read]);
        return $dataProvider;
    }

}
