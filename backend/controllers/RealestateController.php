<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\realestate\AddRealestateForm;
use backend\models\realestate\RealestateSearch;
use backend\models\realestate\UpdateRealestate;
use backend\models\realestate\Realestate;
use common\models\Admin;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

##############= FOR FILE UPLOAD =################
use yii\web\UploadedFile;
use backend\models\realestate\RealestateUpload;

/**
 * Document controller
 */
class RealestateController extends Controller
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
                        'actions' => ['index','create','delete','update','view','status', 'settings'],
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
		$searchModel  = Yii::createObject(RealestateSearch::className());
        $dataProvider = $searchModel->search(Yii::$app->request->get());
		$dataProvider->pagination->pageSize = (isset($_GET['p']) ? $_GET['p'] : PAGE_LIMIT);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

	 /**
     * Displays a single Document model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
		return $this->render('view', [
            'model' => $this->findModel($id),
        ]);	
    }
	 
    public function actionCreate() {
        $modelDocumentUpload = new RealestateUpload();
        $modelDocumentUpload->scenario = 'update-profile';

        $data = array();
        $model = new AddRealestateForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$postval 			= Yii::$app->request->post('AddRealestateForm');
            $model->filename 	= 'test';
            $model->status   	= '1';
            $model->document_type = '';
            if (Yii::$app->request->isPost) {
                $modelDocumentUpload->filename = UploadedFile::getInstance($modelDocumentUpload, 'filename');
                if ($modelDocumentUpload->filename && $uploadedFileNameArray = $modelDocumentUpload->upload()) {
                    $model->filename = $uploadedFileNameArray['originalImage'];
                    $model->document_type = $uploadedFileNameArray['file_extention'];
                }
            }
            
            if ($model->insertdata()) {
                Yii::$app->session->setFlash('item', 'Real estate has been created successfully!');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('item', 'Please enter valid values for all the fields!');
            }
        }

        return $this->render('create', [
            'data' => $data,
            'model' => $model,
            'modelDocumentUpload' => $modelDocumentUpload,
        ]);
    }
    

		    
    /**
    * Update an existing Users model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id
    * @return mixed
    */
    public function actionUpdate($id) {
        $modelDocumentUpload= new RealestateUpload();
		$data 			  	= array();
        $Documentmodel 		= $this->findModel($id);
        $updateDocument 	= new UpdateRealestate();
        $model 		 		= $updateDocument->findIdentity($id);
        $userpost 	 		= Yii::$app->request->post('UpdateRealestate');

        if(isset($userpost) && !empty($userpost)) {
				$model->filename = '';
				$model->document_type = '';
				if (Yii::$app->request->isPost) {
					$modelDocumentUpload->filename = UploadedFile::getInstance($modelDocumentUpload, 'filename');
					if ($modelDocumentUpload->filename && $uploadedFileNameArray = $modelDocumentUpload->upload() ) {
						$model->filename = $uploadedFileNameArray['originalImage'];
						$model->document_type = $uploadedFileNameArray['file_extention'];
					}
				}
				if($model->load(Yii::$app->request->post()) && $model->updatedata($id)) {
					Yii::$app->session->setFlash('item', 'Real estate has been updated successfully!');
					return $this->redirect(['index']);				
				} else {
					Yii::$app->session->setFlash('item', 'Please enter valid values for all the fields!');
				}
		} else {
			$model->setAttributes($Documentmodel->getAttributes());
		}
		return $this->render('update', [
			'data' => $data,
			'model' => $model,
			'modelDocumentUpload' => $modelDocumentUpload,
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
		 Yii::$app->session->setFlash('item', 'Selected Real estate deleted successully!');
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
        if (($model = Realestate::findOne($id)) !== null) {
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
                    Yii::$app->session->setFlash('item' ,'Status has been updated successfully!');
                } else {
                    Yii::$app->session->setFlash('item', 'No status is set for selected images, please try again.');
                }
                die();
            }
        }
    }
}
