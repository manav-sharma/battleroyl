<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace backend\models\documentupload;

use backend\models\documentupload\Document;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DocumentSearch represents the model behind the search form about User.
 */
class DocumentSearch extends Model
{
    /** @var string */
    public $id;
    public $cat_id;
    public $title;
    public $filename;
    public $description;
    public $document_type;
    public $datetime;
    public $status;

    /** @inheritdoc */
    public function rules() {
        return [
         [['id','cat_id'], 'integer'],
          [['title','cat_id','description','document_type','datetime','status'], 'safe'],
        ];
    }

    /**
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
		$query = Document::find();
		$query->joinWith(['category']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $dataProvider->sort->attributes['category'] = [
                'asc' => ['category.name' => SORT_ASC],
                'desc' => ['category.name' => SORT_DESC],
        ];
        
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->datetime != "") {
            $date = strtotime($this->datetime);
            $newdate = date('Y-m-d',$date);
            $query->andFilterWhere(['like', 'tbl_document_upload.datetime', $newdate]);
        }

        $query->andFilterWhere(['like', 'title', $this->title])
              //  ->andFilterWhere(['like', 'category.name', $this->category])
                ->andFilterWhere(['like', 'tbl_document_upload.description', $this->description])
                ->andFilterWhere(['like', 'tbl_document_upload.status', $this->status]);
        return $dataProvider;
    }
}
