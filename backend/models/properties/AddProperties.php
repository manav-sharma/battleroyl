<?php
namespace backend\models\properties;
use backend\models\properties\Properties;
use backend\models\properties\Documents;
use yii\base\Model;
use Yii;

/**
 * AddProperties
 */
class AddProperties extends Model {

    public $name;
    public $reference_number;
    public $property_type;
    public $property_for;
    public $address;
    public $country;
    public $region;
    public $city;
    public $build_year;
    public $area;
    public $rooms;
    public $floors;
    public $price;
    public $specification;
    public $description;
    public $property_right;
    public $auction;

    ####### media files	
    public $upload_documents;
    public $upload_video;
    public $upload_viewvideo;
    public $upload_images;
    public $upload_dview_video;

    /**
    * @inheritdoc
    */
    public function rules() {
        return [
            [['name','reference_number','property_type','property_for','country','region','city','build_year','area','rooms','floors','price','specification','property_right','auction','address'], 'required'],
             [['name','address','specification'], 'string', 'max' => 60],  
             ['area','number'],
			 #['area_to', 'compare', 'compareAttribute' => 'area_from', 'operator' => '>=', 'type' => 'number'],
             ['rooms','integer'],
			 #['rooms_max', 'compare', 'compareAttribute' => 'rooms_min', 'operator' => '>=', 'type' => 'number'],
             ['floors','number'],
			 #['floors_max', 'compare', 'compareAttribute' => 'floors_min', 'operator' => '>=', 'type' => 'number'],	
             [['price'],'number','max' => 10000000],
			 #['price_max', 'compare', 'compareAttribute' => 'price_min', 'operator' => '>=', 'type' => 'number'],
        ];
    }

    /**
    * @inheritdoc
    */
    public function attributeLabels() {
        return [
            'name' => 'Name',
            'image' => 'Image',
            'description' => 'Description',
            'datetime' => 'Date',
            'status' => 'Status',
        ];
    }

    public function insertdata($mediaArr='') {
        if (!$this->validate()) {
            return null;
        }
        $expiryDate = date('Y-m-d', strtotime('+1 months'));
        ###############= transaction begin =###############
		$connection = \Yii::$app->db;
		$transaction = $connection->beginTransaction();
		try {
			$data 					= new Properties();
			$data->name 			= $this->name;
			$data->reference_number = $this->reference_number;
			$data->property_type 	= $this->property_type;
			$data->property_for 	= $this->property_for;
			$data->address 			= $this->address;
			$data->country 			= $this->country;
			$data->region 			= $this->region;
			$data->city 			= $this->city;
			$data->build_year 		= $this->build_year;
			$data->area 			= $this->area;
			$data->rooms 			= $this->rooms;
			$data->floors 			= $this->floors;
			$data->price 			= $this->price;
			$data->specification 	= $this->specification;
			$data->property_right 	= $this->property_right;
			$data->added_by 		= '1';
			$data->auction 			= $this->auction;
			$data->expiry_date 		= $expiryDate;
			$data->updated_at 		= date("Y-m-d H:i:s");
			$data->created_at 		= date("Y-m-d H:i:s");
			$data->status 			= ACTIVE;
			if($data->save()) {
			###############= 1=Document,2=Image,3=Video,4=360 Video,5=3D Video =####################	
				$property_id = $data->id;
				if(!empty($mediaArr)) {
					$response_counter=0;
					if(isset($mediaArr['upload_documents']) && !empty($mediaArr['upload_documents'])) {
						foreach($mediaArr['upload_documents'] as $doc) {
							$data1 					= new Documents();
							$data1->name 			= $doc;
							$data1->type 			= '1';
							$data1->property_id 	= $property_id;
							if($data1->save()) {
								$response_counter=1;
							}
						}
					}

					if(isset($mediaArr['upload_images']) && !empty($mediaArr['upload_images'])) {
						foreach($mediaArr['upload_images'] as $img) {
							$data2 					= new Documents();
							$data2->name 			= $img;
							$data2->type 			= '2';
							$data2->property_id 	= $property_id;
							if($data2->save()) {
								$response_counter=1;
							}
						}
					}

					if(isset($mediaArr['upload_video']) && !empty($mediaArr['upload_video'])) {
							$data3 					= new Documents();
							$data3->name 			= $mediaArr['upload_video'];
							$data3->type 			= '3';
							$data3->property_id 	= $property_id;
							if($data3->save()) {
								$response_counter=1;
							}
					}
					
					if(isset($mediaArr['upload_viewvideo']) && !empty($mediaArr['upload_viewvideo'])) {
							$data4 					= new Documents();
							$data4->name 			= $mediaArr['upload_viewvideo'];
							$data4->type 			= '4';
							$data4->property_id 	= $property_id;
							if($data4->save()) {
								$response_counter=1;
							}
					}
		
					if(isset($mediaArr['upload_dview_video']) && !empty($mediaArr['upload_dview_video'])) {
							$data5 					= new Documents();
							$data5->name 			= $mediaArr['upload_dview_video'];
							$data5->type 			= '5';
							$data5->property_id 	= $property_id;
							if($data5->save()) {
								$response_counter=1;
							}
					}
					$transaction->commit();
					return $response_counter ? $response_counter : null;
				}
			}
		} catch(\Exception $e) {
			$transaction->rollback();
			//throw $e;
		}
		return null;  
    }
}
