<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace backend\models\homepagevideo;
use backend\models\homepagevideo\Homepagevideo;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * NewsSearch represents the model behind the search form about User.
 */
class HomepagevideoSearch extends Model
{
    /** @var string */
    public $home_video_id;
    public $video_name;
    public $youtubevideolink;
    public $date_created;
    public $status;

    /** @inheritdoc */
    public function rules() {
        return [
         [['home_video_id'], 'integer'],
          [['video_name','date_created','youtubevideolink','status'], 'safe'],
        ];
    }

    /**
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
		$query = Homepagevideo::find();
		//$query->joinWith(['user']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['home_video_id' => SORT_DESC]]
        ]);
        //~ $dataProvider->sort->attributes['user'] = [
                //~ 'asc' => ['user.firstname' => SORT_ASC],
                //~ 'desc' => ['user.firstname' => SORT_DESC],
        //~ ];         

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->date_created != "") {
            $date = strtotime($this->date_created);
            $newdate = date('Y-m-d',$date);
            $query->andFilterWhere(['like', 'date_created', $newdate]);
        }
		
        $query->andFilterWhere(['like', 'video_name', $this->video_name])
				->andFilterWhere(['like', 'status', $this->status])
              ->andFilterWhere(['like', 'youtubevideolink', $this->youtubevideolink]);
               	                			

        return $dataProvider;
    }
}
