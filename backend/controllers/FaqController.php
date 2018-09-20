<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\faq\AddFaq;
use backend\models\faq\FaqSearch;
use backend\models\faq\UpdateFaq;
use backend\models\faq\Faq;
use common\models\Admin;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

##############= FOR FILE UPLOAD =################
use yii\web\UploadedFile;
use common\models\ImageUpload;

/**
* Testimonail controller
**/
class FaqController extends Controller
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
                        'actions' => ['index','create','delete','update','view','status'],
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
		$searchModel  = Yii::createObject(FaqSearch::className());
        $dataProvider = $searchModel->search(Yii::$app->request->get());
		$dataProvider->pagination->pageSize = (isset($_GET['p']) ? $_GET['p'] : PAGE_LIMIT);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

	/**
    * Displays a single Faq model.
    * @param integer $id
    * @return mixed
    */
    public function actionView($id) {
		return $this->render('view', [
            'model' => $this->findModel($id),
        ]);	
    }
	 
    public function actionCreate() {
       // $modelImageUpload = new ImageUpload();
       // $modelImageUpload->scenario = 'update-profile';
        $data = array();
        $model = new AddFaq();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$postval 			= Yii::$app->request->post('AddFaq');
            $model->image 		= '';
            $model->status   	= '1';
            //~ if (Yii::$app->request->isPost) {
                //~ $modelImageUpload->image = UploadedFile::getInstance($modelImageUpload, 'image');
                //~ if ($modelImageUpload->image && $uploadedFileNameArray = $modelImageUpload->upload()) {
                    //~ $model->image = $uploadedFileNameArray['originalImage'];
                //~ }
            //~ }

            if ($model->addfaq()) {
                Yii::$app->session->setFlash('item', 'Faq has been created successfully!');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('item', 'Please enter valid values for all the fields!');
            }
        }
        return $this->render('create', [
            'data' => $data,
            'model' => $model,
            //'modelImageUpload' => $modelImageUpload,
        ]);
    }
		    
    /**
    * Update an existing Users model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id
    * @return mixed
    */
    public function actionUpdate($id) {
       // $modelImageUpload 	= new ImageUpload();
		$data 			  	= array();
        $updateModel 		= $this->findModel($id);
        $updateFaq	= new UpdateFaq();
        $model 		 		= $updateFaq->findIdentity($id);
        $userpost 	 		= Yii::$app->request->post('UpdateFaq');

        if(isset($userpost) && !empty($userpost)) {
            #######################= FILE UPLOAD =######################
				/*$model->image = '';
				if (Yii::$app->request->isPost) {
					$modelImageUpload->image = UploadedFile::getInstance($modelImageUpload, 'image');
					if ($modelImageUpload->image && $uploadedFileNameArray = $modelImageUpload->upload() ) {
						$model->image = $uploadedFileNameArray['originalImage'];
					}
				}*/
				if($model->load(Yii::$app->request->post()) && $model->updatefaq($id)) {
					Yii::$app->session->setFlash('item', 'Faq has been updated successfully!');
					return $this->redirect(['index']);				
				} else {
					Yii::$app->session->setFlash('item', 'Please enter valid values for all the fields!');
				}
		} else {
			$model->setAttributes($updateModel->getAttributes());
		}
		return $this->render('update', [
			'data' => $data,
			'model' => $model,
			//'modelImageUpload' => $modelImageUpload,
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
        if (($model = Faq::findOne($id)) !== null) {
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
                    Yii::$app->session->setFlash('item' ,'Faq status has been changed successfully.');
                } else {
                    Yii::$app->session->setFlash('item', 'No status is set for selected images, please try again.');
                }
                die();
            }
        }
    }
}
