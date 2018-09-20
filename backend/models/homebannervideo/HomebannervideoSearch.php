<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace backend\models\homebannervideo;

use backend\models\homebannervideo\Homebannervideo;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * HomehomebannervideovideoSearch represents the model behind the search form about User.
 */
class HomebannervideoSearch extends Model
{
    /** @var string */
    public $video_banner_id;
    public $video_name;
    public $youtubevideolink;
    public $status;
    public $date_created;

    /** @inheritdoc */
    public function rules()
    {
        return [
          [['video_banner_id'], 'integer'],
          [['youtubevideolink','video_name'], 'safe'],
        ];
    }


    /**
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {

		$query = Homebannervideo::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            
        ]);
        
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if ($this->date_created != "") {
            $date = strtotime($this->date_created);
            $newdate = date('Y-m-d',$date);
            $query->andFilterWhere(['like', 'date_created', $newdate]);
        }

        $query->andFilterWhere(['like', 'youtubevideolink', $this->youtubevideolink])
			  ->andFilterWhere(['like', 'video_name', $this->video_name])
              ->andFilterWhere(['like', 'status', $this->status]);
              
            
 
        return $dataProvider;
    }
}
