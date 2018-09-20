<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\properties\AddProperties;
use backend\models\properties\SendMessage;
use backend\models\properties\PropertiesSearch;
use backend\models\properties\UpdateProperties;
use backend\models\properties\Properties;
use backend\models\properties\Documents;
use common\models\Admin;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\db\Query;
##############= FOR FILE UPLOAD =################
use yii\web\UploadedFile;
use backend\models\properties\Uploads;

/**
 * News controller
 */
class PropertiesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','create','delete','update','view','status','deletepmedia','updatestates','updatecities','sendmessage'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex() {
		$searchModel  = Yii::createObject(PropertiesSearch::className());
        $dataProvider = $searchModel->search(Yii::$app->request->get());
		$dataProvider->pagination->pageSize = (isset($_GET['p']) ? $_GET['p'] : PAGE_LIMIT);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

	/**
    * Displays a single New model.
    * @param integer $id
    * @return mixed
    */
    public function actionView($id) {
		$data 			 		= $this->findModel($id);
		//echo '<pre>'; print_r($data->usermembership->package->name); exit();
		$property_type 	 		= Yii::$app->commonmethod->propertyTypes($data->property_type);
		$property_for 	 		= Yii::$app->commonmethod->propertyFor($data->property_for);
		$property_right  		= Yii::$app->commonmethod->propertyRights($data->property_right);
		$added_by	    		= Yii::$app->commonmethod->propertyAddedBy($data->added_by);
		$country	    		= Yii::$app->commonmethod->countries($data->country);
		$region	    	 		= Yii::$app->commonmethod->regions($data->region);
		$city		     		= Yii::$app->commonmethod->cities($data->city);
		$data['property_type'] 	= $property_type['name'];
		$data['property_for'] 	= $property_for;
		$data['property_right'] = $property_right;
		$data['added_by'] 		= $added_by;
		$data['country'] 		= $country['name'];
		$data['region'] 		= $region['name'];
		$data['city'] 			= $city['name'];
		$data['area'] 			= $data['area']." sq m2";
		return $this->render('view', [
            'model' => $data,
        ]);
    }

    public function actionCreate() {
        $modelImageUploadA = new Uploads();
        $modelImageUploadB = new Uploads();
        $modelImageUploadC = new Uploads();
        $modelImageUploadD = new Uploads();
        $modelImageUploadE = new Uploads();
        $modelImageUploadA->scenario = 'upa';
        $modelImageUploadB->scenario = 'upb';
        $modelImageUploadC->scenario = 'upc';
        $modelImageUploadD->scenario = 'upd';
        $modelImageUploadE->scenario = 'upe';
        $data  = array();
        $model = new AddProperties();
        if($model->load(Yii::$app->request->post()) && $model->validate()) {
			###########= client side removed images ##############
			$client_removed_images = array();
			if(isset($userpost['client_side_removed_images']) && !empty($userpost['client_side_removed_images'])) {
				//$client_removed_images = explode(",",str_replace("p_","",$userpost['client_side_removed_images']));
				$client_removed_images = explode(",",$userpost['client_side_removed_images']);
			}
			
			###########= client side removed images ##############
			$client_removed_documents = array();
			if(isset($userpost['client_side_removed_documents']) && !empty($userpost['client_side_removed_documents'])) {
				//$client_removed_documents = explode(",",str_replace("p_","",$userpost['client_side_removed_documents']));
				$client_removed_documents = explode(",",$userpost['client_side_removed_documents']);
			}
			###############= 1=Document,2=Image,3=Video,4=360 Video,5=3D Video =####################
			$model->upload_documents 		= '';
			$model->upload_video		 	= '';
			$model->upload_viewvideo	 	= '';
			$model->upload_images 			= '';
			$model->upload_dview_video	 	= '';
			$documentsArr = array();
			if (Yii::$app->request->isPost) {
				$modelImageUploadA->upload_documents = UploadedFile::getInstances($modelImageUploadA, 'upload_documents');
				if ($modelImageUploadA->upload_documents && $uploadedFileNameArray = $modelImageUploadA->upload($client_removed_documents) ) {
					$documentsArr['upload_documents'] = $uploadedFileNameArray['originalImage'];
				}

				$modelImageUploadB->upload_video = UploadedFile::getInstance($modelImageUploadB, 'upload_video');
				if ($modelImageUploadB->upload_video && $uploadedFileNameArray = $modelImageUploadB->uploadB() ) {
					$documentsArr['upload_video'] = $uploadedFileNameArray['originalImage'];
				}

				$modelImageUploadC->upload_viewvideo = UploadedFile::getInstance($modelImageUploadC, 'upload_viewvideo');
				if ($modelImageUploadC->upload_viewvideo && $uploadedFileNameArray = $modelImageUploadC->uploadC() ) {
					$documentsArr['upload_viewvideo'] = $uploadedFileNameArray['originalImage'];
				}

				$modelImageUploadD->upload_images = UploadedFile::getInstances($modelImageUploadD, 'upload_images');
				if ($modelImageUploadD->upload_images && $uploadedFileNameArray = $modelImageUploadD->uploadD($client_removed_images) ) {
					$documentsArr['upload_images'] = $uploadedFileNameArray['originalImage'];
				}

				$modelImageUploadE->upload_dview_video = UploadedFile::getInstance($modelImageUploadE, 'upload_dview_video');
				if ($modelImageUploadE->upload_dview_video && $uploadedFileNameArray = $modelImageUploadE->uploadE() ) {
					$documentsArr['upload_dview_video'] = $uploadedFileNameArray['originalImage'];
				}
			}

			if ($model->insertdata($documentsArr)) {
				Yii::$app->session->setFlash('item', 'Property has been created successfully!');
				return $this->redirect(['index']);
			} else {
				Yii::$app->session->setFlash('item', 'Please enter valid values for all the fields!');
			}
        }

        return $this->render('create', [
            'data' => $data,
            'model' => $model,
            'modelImageUpload' => array('modelImgA'=>$modelImageUploadA,'modelImgB'=>$modelImageUploadB,'modelImgC'=>$modelImageUploadC,'modelImgD'=>$modelImageUploadD,'modelImgE'=>$modelImageUploadE),
        ]);
    }

    /**
    * Update an existing Users model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id
    * @return mixed
    */
    public function actionUpdate($id) {
        $modelImageUploadA = new Uploads();
        $modelImageUploadB = new Uploads();
        $modelImageUploadC = new Uploads();
        $modelImageUploadD = new Uploads();
        $modelImageUploadE = new Uploads();
        $modelImageUploadA->scenario = 'upa';
        $modelImageUploadB->scenario = 'upb';
        $modelImageUploadC->scenario = 'upc';
        $modelImageUploadD->scenario = 'upd';
        $modelImageUploadE->scenario = 'upe';

        $data  = array();
        $updateModel 		= $this->findModel($id);
        $updateProperties	= new UpdateProperties();
        $model 		 		= $updateProperties->findIdentity($id);
        $userpost 	 		= Yii::$app->request->post('UpdateProperties');

        if(isset($userpost) && !empty($userpost)) {
			###########= client side removed images ##############
			$client_removed_images = array();
			if(isset($userpost['client_side_removed_images']) && !empty($userpost['client_side_removed_images'])) {
				//$client_removed_images = explode(",",str_replace("p_","",$userpost['client_side_removed_images']));
				$client_removed_images = explode(",",$userpost['client_side_removed_images']);
			}
			
			###########= client side removed images ##############
			$client_removed_documents = array();
			if(isset($userpost['client_side_removed_documents']) && !empty($userpost['client_side_removed_documents'])) {
				//$client_removed_documents = explode(",",str_replace("p_","",$userpost['client_side_removed_documents']));
				$client_removed_documents = explode(",",$userpost['client_side_removed_documents']);
			}			
			
			###############= 1=Document,2=Image,3=Video,4=360 Video,5=3D Video =####################			
			$model->upload_documents 	= '';
			$model->upload_video 		= '';
			$model->upload_viewvideo 	= '';
			$model->upload_images 		= '';
			$model->upload_dview_video 	= '';
			$documentsArr = array();
			if (Yii::$app->request->isPost) {
				$modelImageUploadA->upload_documents = UploadedFile::getInstances($modelImageUploadA, 'upload_documents');
				if ($modelImageUploadA->upload_documents && $uploadedFileNameArray = $modelImageUploadA->upload($client_removed_documents) ) {
					$documentsArr['upload_documents'] 	= $uploadedFileNameArray['originalImage'];
				}

				$modelImageUploadB->upload_video = UploadedFile::getInstance($modelImageUploadB, 'upload_video');
				if ($modelImageUploadB->upload_video && $uploadedFileNameArray = $modelImageUploadB->uploadB() ) {
					$documentsArr['upload_video'] 		= $uploadedFileNameArray['originalImage'];
				}

				$modelImageUploadC->upload_viewvideo = UploadedFile::getInstance($modelImageUploadC, 'upload_viewvideo');
				if ($modelImageUploadC->upload_viewvideo && $uploadedFileNameArray = $modelImageUploadC->uploadC() ) {
					$documentsArr['upload_viewvideo'] 	= $uploadedFileNameArray['originalImage'];
				}

				$modelImageUploadD->upload_images = UploadedFile::getInstances($modelImageUploadD, 'upload_images');
				if ($modelImageUploadD->upload_images && $uploadedFileNameArray = $modelImageUploadD->uploadD($client_removed_images) ) {
					$documentsArr['upload_images'] 		= $uploadedFileNameArray['originalImage'];
				}

				$modelImageUploadE->upload_dview_video = UploadedFile::getInstance($modelImageUploadE, 'upload_dview_video');
				if ($modelImageUploadE->upload_dview_video && $uploadedFileNameArray = $modelImageUploadE->uploadE() ) {
					$documentsArr['upload_dview_video'] = $uploadedFileNameArray['originalImage'];
				}
			}

			if($model->load(Yii::$app->request->post()) && $model->updatedata($id,$documentsArr)) {
				Yii::$app->session->setFlash('item', 'Property has been updated successfully!');
				return $this->redirect(['index']);				
			} else {
				Yii::$app->session->setFlash('item', 'Please enter valid values for all the fields!');
			}
		} else {
			$model->setAttributes($updateModel->getAttributes());
		}

		###############= uploaded files, documents, videos, images, views =###############
		$mediaArr=array();
		$mediaArr['documents'] 			=  Yii::$app->commonmethod->propertyDocuments($id);
		$mediaArr['video'] 				=  Yii::$app->commonmethod->propertyVideo($id);
		$mediaArr['viewvideo'] 			=  Yii::$app->commonmethod->propertyViewvideo($id);
		$mediaArr['images'] 			=  Yii::$app->commonmethod->propertyImages($id);
		$mediaArr['dview_video'] 		=  Yii::$app->commonmethod->propertyDviewvideo($id);

		return $this->render('update', [
			'data' => $data,
			'model' => $model,
			'modelImageUpload' => array('modelImgA'=>$modelImageUploadA,'modelImgB'=>$modelImageUploadB,'modelImgC'=>$modelImageUploadC,'modelImgD'=>$modelImageUploadD,'modelImgE'=>$modelImageUploadE),
			'mediaArr' => $mediaArr,
		]);
    }

    /**
    * Deletes an existing CrudTest model.
    * If deletion is successful, the browser will be redirected to the 'index' page.
    * @param integer $id
    * @return mixed
    */
    public function actionDelete($id) {
		$this->findModel($id)->delete();
		Documents::deleteAll('property_id = :property_id', [':property_id' => $id]);
		Yii::$app->session->setFlash('item', 'Selected properties deleted successully!');
		return $this->redirect(['index']);
	}
	
	/**
    * Finds the CrudTest model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return CrudTest the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
    protected function findModel($id) {
        if (($model = Properties::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    public function actionDeletepmedia($id) {
		$this->findModelDocument($id)->delete();
	}
	
    protected function findModelDocument($id) {
        if (($model = Documents::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }    

    /**
    * Action Status
    * If deletion is successful, the browser will be redirected to the 'index' page.
    * @param integer $id
    * @return mixed
    */
    public function actionStatus($id) {
         $model = $this->findModel($id);
         $menupost = Yii::$app->request->post('update');
         if(isset($menupost) && !empty($menupost)) {
            if (Yii::$app->request->isAjax){
                $model->status = $menupost['status'];
                if($model->save()) {
                    Yii::$app->session->setFlash('item' ,'Properties status has been changed successfully.');
                } else {
                    Yii::$app->session->setFlash('item', 'No status is set for selected images, please try again.');
                }
                die();
            }
        }
    }
    
    /**
     * Get States based by country id
     * @return JSON
     */
    public function actionUpdatestates() {
        $countryID = Yii::$app->request->post('id');
        return Yii::$app->commonmethod->updateStates($countryID);
    }

    /**
     * Get City based on State id
     * @return JSON
     */
    public function actionUpdatecities() {
        $stateID = Yii::$app->request->post('id');
        return Yii::$app->commonmethod->updateCities($stateID);
    }
}
