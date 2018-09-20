<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\posts\AddPosts;
use backend\models\posts\PostsSearch;
use backend\models\posts\UpdatePosts;
use backend\models\posts\Posts;
use common\models\Admin;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

##############= FOR FILE UPLOAD =################
use yii\web\UploadedFile;
use backend\models\posts\PostsPictureUpload;

/**
* Testimonail controller
**/
class PostsController extends Controller
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
		$searchModel  = Yii::createObject(PostsSearch::className());
        $dataProvider = $searchModel->search(Yii::$app->request->get());
		$dataProvider->pagination->pageSize = (isset($_GET['p']) ? $_GET['p'] : PAGE_LIMIT);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

	/**
    * Displays a single Posts model.
    * @param integer $id
    * @return mixed
    */
    public function actionView($id) {
		return $this->render('view', [
            'model' => $this->findModel($id),
        ]);	
    }
	 
    public function actionCreate() {
		
        $modelImageUpload = new PostsPictureUpload();
        $modelImageUpload->scenario = 'update-profile';
        $data = array();
        $model = new AddPosts();
        //~ if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
//~ 
            //~ Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            //~ return \yii\widgets\ActiveForm::validate($model);
        //~ }
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$postval 			= Yii::$app->request->post('AddPosts');
            $model->image 		= '';
            $model->status   	= '1';
            if (Yii::$app->request->isPost) {
                $modelImageUpload->image = UploadedFile::getInstance($modelImageUpload, 'image');
                if ($modelImageUpload->image && $uploadedFileNameArray = $modelImageUpload->upload()) {
                    $model->image = $uploadedFileNameArray['originalImage'];
                }
            }

            if ($model->addposts()) {
                Yii::$app->session->setFlash('item', 'New Post has been created successfully!');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('item', 'Please enter valid values for all the fields!');
            }
        }
        return $this->render('create', [
            'data' => $data,
            'model' => $model,
            'modelImageUpload' => $modelImageUpload,
        ]);
    }
		    
    /**
    * Update an existing Users model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id
    * @return mixed
    */
    public function actionUpdate($id) {
        $modelImageUpload 	= new PostsPictureUpload();
		$data 			  	= array();
        $updateModel 		= $this->findModel($id);
        $updatePosts		= new UpdatePosts();
        $model 		 		= $updatePosts->findIdentity($id);
        $userpost 	 		= Yii::$app->request->post('UpdatePosts');
		//echo '<pre>'; print_r($userpost); die();
        if(isset($userpost) && !empty($userpost)) {
            #######################= FILE UPLOAD =######################
				$model->image = '';
				if (Yii::$app->request->isPost) {
					$modelImageUpload->image = UploadedFile::getInstance($modelImageUpload, 'image');
					if ($modelImageUpload->image && $uploadedFileNameArray = $modelImageUpload->upload() ) {
						$model->image = $uploadedFileNameArray['originalImage'];
					}
				}
				if($model->load(Yii::$app->request->post()) && $model->updateposts($id)) {
					Yii::$app->session->setFlash('item', 'Post has been updated successfully!');
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
			'modelImageUpload' => $modelImageUpload,
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
        if (($model = Posts::findOne($id)) !== null) {
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
                    Yii::$app->session->setFlash('item' ,'Post status has been changed successfully.');
                } else {
                    Yii::$app->session->setFlash('item', 'No status is set for selected images, please try again.');
                }
                die();
            }
        }
    }
}
