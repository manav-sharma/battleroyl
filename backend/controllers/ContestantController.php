<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\contestant\AddContestant;
use backend\models\contestant\ContestantSearch;
use backend\models\contestant\UpdateContestant;
use backend\models\contestant\Contestant;
use backend\models\contestant\Documents;
use common\models\Admin;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

##############= FOR FILE UPLOAD =################
use yii\web\UploadedFile;
use common\models\ImageUpload;
use backend\models\contestant\Uploads;

/**
* Testimonail controller
**/
class ContestantController extends Controller
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
                        'actions' => ['index','create','delete','update','view','status','deletepmedia'],
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

    public function actionIndex() {
		$searchModel  = Yii::createObject(ContestantSearch::className());
        $dataProvider = $searchModel->search(Yii::$app->request->get());
		$dataProvider->pagination->pageSize = (isset($_GET['p']) ? $_GET['p'] : PAGE_LIMIT);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

	/**
    * Displays a single Contestant model.
    * @param integer $id
    * @return mixed
    */
    public function actionView($id) {
		return $this->render('view', [
            'model' => $this->findModel($id),
        ]);	
    }
	 
    public function actionCreate() {
        $modelImageUploadA = new Uploads();
        $data = array();
        $model = new AddContestant();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$client_removed_images = array();
			if(isset($userpost['client_side_removed_images']) && !empty($userpost['client_side_removed_images'])) {
				$client_removed_images = explode(",",$userpost['client_side_removed_images']);
			}
			$postval 			= Yii::$app->request->post('AddContestant');
            $model->status   	= '1';
            $modelImageUploadA->contestant_image = '';
            if (Yii::$app->request->isPost) {
				$modelImageUploadA->contestant_image = UploadedFile::getInstances($modelImageUploadA, 'contestant_image');
				if ($modelImageUploadA->contestant_image && $uploadedFileNameArray = $modelImageUploadA->upload($client_removed_images) ) {
					$documentsArr['contestant_image'] = $uploadedFileNameArray['originalImage'];
				} else {
					$documentsArr['contestant_image'] = '';
				}
				
            }

            if ($model->addcontestant($documentsArr)) {
                Yii::$app->session->setFlash('item', 'Contestant has been created successfully!');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('item', 'Please enter valid values for all the fields!');
            }
        }
        return $this->render('create', [
            'data' => $data,
            'model' => $model,
            'modelImageUpload' => $modelImageUploadA,
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
        //$modelImageUploadA->scenario = 'upa';
        $data  = array();
        $updateModel 		= $this->findModel($id);
        $updateContestant	= new UpdateContestant();
        $model 		 		= $updateContestant->findIdentity($id);
        $userpost 	 		= Yii::$app->request->post('UpdateContestant');

        if(isset($userpost) && !empty($userpost)) {
			###########= client side removed images ##############
			$client_removed_images = array();
			if(isset($userpost['client_side_removed_images']) && !empty($userpost['client_side_removed_images'])) {
				$client_removed_images = explode(",",$userpost['client_side_removed_images']);
			}
				
			$model->contestant_image 		= '';
			$documentsArr = array();
			if (Yii::$app->request->isPost) {
				
				$modelImageUploadA->contestant_image = UploadedFile::getInstances($modelImageUploadA, 'contestant_image');
				if ($modelImageUploadA->contestant_image && $uploadedFileNameArray = $modelImageUploadA->upload($client_removed_images) ) {
					$documentsArr['contestant_image'] 		= $uploadedFileNameArray['originalImage'];
				} else {
					$documentsArr['contestant_image'] = '';
				}
			}

			if($model->load(Yii::$app->request->post()) && $model->updatecontestant($id,$documentsArr)) {
				Yii::$app->session->setFlash('item', 'Contestant has been updated successfully!');
				return $this->redirect(['index']);				
			} else {
				Yii::$app->session->setFlash('item', 'Please enter valid values for all the fields!');
			}
		} else {
			$model->setAttributes($updateModel->getAttributes());
		}

		###############= uploaded images =###############
		$mediaArr = array();
		$mediaArr['contestant_image'] 			=  Yii::$app->commonmethod->contestantImages($id);
		
		//echo '<pre>'; print_r($mediaArr['contestant_image']); die;
		
		return $this->render('update', [
			'data' => $data,
			'model' => $model,
			'modelImageUpload' => $modelImageUploadA,
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
		 Yii::$app->session->setFlash('item', 'Selected news deleted successully!');
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
        if (($model = Contestant::findOne($id)) !== null) {
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
                    Yii::$app->session->setFlash('item' ,'Contestant status has been changed successfully.');
                } else {
                    Yii::$app->session->setFlash('item', 'No status is set for selected images, please try again.');
                }
                die();
            }
        }
    }
}
