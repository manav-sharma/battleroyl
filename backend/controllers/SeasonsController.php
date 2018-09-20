<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\seasons\AddSeasons;
use backend\models\seasons\SeasonsSearch;
use backend\models\seasons\UpdateSeason;
use backend\models\seasons\Seasons;
use backend\models\seasons\GroupImages;
use backend\models\contestant\Contestant;
use common\models\Admin;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use common\models\ImageUpload;
use backend\models\seasons\Uploads;
use backend\models\seasons\Document;


/**
* Seasons controller
**/
class SeasonsController extends Controller
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
                        'actions' => ['index','create','delete','update','view','status','getsubcities','groupimages','deletepmedia','exportdata','importdata'],
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
		$searchModel  = Yii::createObject(SeasonsSearch::className());
        $dataProvider = $searchModel->search(Yii::$app->request->get());
		$dataProvider->pagination->pageSize = (isset($_GET['p']) ? $_GET['p'] : PAGE_LIMIT);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

	/**
    * Displays a single Seasons model.
    * @param integer $id
    * @return mixed
    */
    public function actionView($id) {
		return $this->render('view', [
            'model' => $this->findModel($id),
        ]);	
    }
	 
    public function actionCreate() {
		
        $data = array();
        $model = new AddSeasons();
       
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$postval = Yii::$app->request->post('AddSeasons');
			$checkPrevious = $model->checkSeason($postval);
			if($checkPrevious) {
				Yii::$app->session->setFlash('item', 'Season cannot be created for Current year or location!');
				return $this->render('create', [
					'data' => $data,
					'model' => $model,
				]);
			} else {
				if ($model->addseasons()) {
					Yii::$app->session->setFlash('item', 'New Season has been created successfully!');
					return $this->redirect(['index']);
				} else {
					Yii::$app->session->setFlash('item', 'Please enter valid values for all the fields!');
				}
			}	
        }
        return $this->render('create', [
            'data' => $data,
            'model' => $model,
        ]);
    }
		    
    /**
    * Update an existing Users model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id
    * @return mixed
    */
    public function actionUpdate($id) {
		
		$data 			  	= array();
        $updateModel 		= $this->findModel($id);
        $updateSeasons		= new UpdateSeason();
        $model 		 		= $updateSeasons->findIdentity($id);
        $userpost 	 		= Yii::$app->request->post('UpdateSeason');
        if(isset($userpost) && !empty($userpost)) {
			$checkPrevious = $model->checkSeason($userpost,$id);
			if($checkPrevious) {
				$model->setAttributes($updateModel->getAttributes());
				Yii::$app->session->setFlash('item', 'Season is already going on for selected Regions!');
				return $this->render('update', [
					'data' => $data,
					'model' => $model,
				]);
			} else {
				if($model->load(Yii::$app->request->post()) && $model->updateseasons($id)) {
					Yii::$app->session->setFlash('item', 'Season has been updated successfully!');
					return $this->redirect(['index']);				
				} else {
					Yii::$app->session->setFlash('item', 'Please enter valid values for all the fields!');
				}
			}
			
		} else {
			$model->setAttributes($updateModel->getAttributes());
		}
		return $this->render('update', [
			'data' => $data,
			'model' => $model,
			
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
		 Yii::$app->session->setFlash('item', 'Selected season deleted successully!');
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
        if (($model = Seasons::findOne($id)) !== null) {
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
         $postArr = Yii::$app->request->post('update');
         if(isset($postArr) && !empty($postArr)) {
            if (Yii::$app->request->isAjax){
                $model->status = $postArr['status'];
                if($model->save()) {
                    Yii::$app->session->setFlash('item' ,'Season status has been changed successfully.');
                } else {
                    Yii::$app->session->setFlash('item', 'No status is set for selected, please try again.');
                }
                die();
            }
        }
    }
    
    
    
    /**
     * Get States based by country id
     * @return JSON
     */
    public function actionGetsubcities() {
        $subCityID = Yii::$app->request->post('id');
        return Yii::$app->commonmethod->updateMaincities($subCityID);
    }
    
    public function actionExportdata($id) {
		$allModels = Contestant::find()->joinWith(['seasons'])->where(['tbl_contestant.season_id'=>$id,'tbl_contestant.status'=>'1'])->all();
		
		
		$mainData = \moonland\phpexcel\Excel::export([
			'models' => $allModels,
			'columns' => ['contestant_id','contestant_name','contestant_votes','seasons.season_name'],
				[
	      				'attribute' => 'contestant_id',
	      				'label' => 'Contestant_ID',
	      		],
	      		[
	      				'attribute' => 'contestant_name',
	      				'label' => 'Contestant_Name',
	      				'format' => 'text',
	      		],
	      		[
	      				'attribute' => 'contestant_votes',
	      				'label' => 'Contestant_Votes',
	      		],
	      		[
	      				'attribute' => 'seasons.season_name',
	      				'label' => 'Season_Name',
	      		],
		]);
		
	}
	
	
	public function actionImportdata($id) {
		$model = new Document();
		if (Yii::$app->request->isPost) {
			$model->importfile = UploadedFile::getInstance($model, 'importfile');
			if  ($fileName = $model->upload()) {
				$uploadedFilePath = Yii::getAlias('@common') .'/uploads/importfiles/'.$fileName;	
				$uploadFile = \moonland\phpexcel\Excel::import( $uploadedFilePath);
				$modelContestant = new Contestant();
				if(!empty($uploadFile)) {
					$response_counter=0;
					foreach($uploadFile as $fileContents) {
						if(array_key_exists('Contestant ID',$fileContents) && array_key_exists('Contestant Votes', $fileContents)) {	
						   $updateData = $modelContestant->updateContestant($fileContents['Contestant ID'],$fileContents['Contestant Votes'],$id);
							if($updateData) {
								$response_counter = 1;
							}	
						} else {
							Yii::$app->session->setFlash('item', 'Please enter valid values for the file!');
						}
					}
					unlink($uploadedFilePath);
					if( $response_counter) {
						Yii::$app->session->setFlash('item', 'Contestant Votes updated successfully!');
					    return $this->redirect(['index']);	
					}  	else {
						Yii::$app->session->setFlash('item', 'Please enter valid values for the file!');
					}		
			    } 
            }
		}
		return $this->render('importdata', ['model' => $model]);
		
	}
	
    
    public function actionGroupimages($id) {
		$modelImageUpload = new Uploads();
        $data  = array();
        $groupimages = new GroupImages();
		###########= client side removed images ##############
		$client_removed_images = array();
		if(isset($userpost['client_side_removed_images']) && !empty($userpost['client_side_removed_images'])) {
			$client_removed_images = explode(",",$userpost['client_side_removed_images']);
		}
				
		$groupimages->group_image = '';
		$documentsArr = array();
		if (Yii::$app->request->isPost) {
			
			$modelImageUpload->group_image = UploadedFile::getInstances($modelImageUpload, 'group_image');
			if ($modelImageUpload->group_image && $uploadedFileNameArray = $modelImageUpload->upload($client_removed_images) ) {
				$documentsArr['group_image'] 		= $uploadedFileNameArray['originalImage'];
			} else {
				$documentsArr['group_image'] = '';
			}
			
			if($groupimages->updategroupimages($id,$documentsArr)) {
				Yii::$app->session->setFlash('item', 'Group Photo has been updated successfully!');
				return $this->redirect(['index']);				
			} else {
				Yii::$app->session->setFlash('item', 'Please enter valid values for all the fields!');
			} 		
		}
		$mediaArr = array();
		$mediaArr['group_image']  =  Yii::$app->commonmethod->seasonImages($id);
		return $this->render('groupimages', [
			'data' => $data,
			'modelImageUpload' => $modelImageUpload,
			'mediaArr' => $mediaArr,
		]);
    }
    
     public function actionDeletepmedia($id) {
		$this->findModelDocument($id)->delete();
	}
	
	protected function findModelDocument($id) {
        if (($model = GroupImages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    } 
    
}
