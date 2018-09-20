<?php
namespace backend\models\contestant;
use yii\base\Model;
use Yii;
use yii\db\Expression;
/**
 * UpdateTestimonail
 */
class UpdateContestant extends Contestant
{
    public $contestant_name;
    public $contestant_description;
    public $contestant_youtubelink;
    public $contestant_votes;
    public $result;
    public $status;
    public $season_id;
    public $date_updated;
    public $contestant_image;

	/**
    * @inheritdoc
    */
    public function rules() {
        return [
			['contestant_votes','integer'],
            [['contestant_name','contestant_description','season_id','result','status','contestant_votes'], 'required'],
			['contestant_name', 'string', 'max' => 100],   
			['contestant_description', 'string', 'max' => 1000],   
			[['contestant_youtubelink','contestant_image','date_updated'],'safe']
        ];
    }

    
    /**
    * @inheritdoc
    */
    public static function findIdentity($id) {
        return static::findOne(['contestant_id' => $id]);
    }
    
    /**
    * update banner.
    *
    * @return User|null the saved model or null if saving fails
    */
	public function updatecontestant($id,$mediaArr='') {
        if (!$this->validate()) {
            return null;
        }
        $contestant 				= Contestant::findOne(['contestant_id' => $id]); 
        $contestant->contestant_name 		  = $this->contestant_name;
        $contestant->contestant_description   = $this->contestant_description;
        $contestant->season_id  			  = $this->season_id;
        $contestant->contestant_youtubelink   = $this->contestant_youtubelink;
        $contestant->contestant_votes   	  = $this->contestant_votes;
        $contestant->result   	  			  = $this->result;
        $contestant->status 		          = $this->status;
        $contestant->date_updated 		      =  new Expression('NOW()');
        if($contestant->save()) {
			if(!empty($mediaArr)) {
				$response_counter=0;
				$contestant_id = $contestant->contestant_id;
				if(isset($mediaArr['contestant_image']) && !empty($mediaArr['contestant_image'])) {
					foreach($mediaArr['contestant_image'] as $img) {
						$data2 					= new Documents();
						$data2->contestant_id 	 = $contestant_id;
						$data2->contestant_image = $img;
						if($data2->save()) {
							$response_counter=1;
						}
					}
				}
				//return $response_counter ? $response_counter : null;
			}
			return $contestant->contestant_id;	
		} else {
			return null;    
		}
        
        //return $contestant->save() ? $contestant : null;  

    }
}
