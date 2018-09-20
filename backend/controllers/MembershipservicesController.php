<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\membershipservices\AddService;
use backend\models\membershipservices\ServiceSearch;
use backend\models\membershipservices\UpdateService;
use backend\models\membershipservices\Service;
use common\models\Admin;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * Membershipservices controller
 */
class MembershipservicesController extends Controller
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
                        'actions' => ['index','create','delete','update','view','status','services'],
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

    public function actionIndex($id=0) {
		$searchModel  = Yii::createObject(ServiceSearch::className());
        $dataProvider = $searchModel->search(Yii::$app->request->get(),$id);
		$dataProvider->pagination->pageSize = (isset($_GET['p']) ? $_GET['p'] : PAGE_LIMIT);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

    public function actionServices($id) {
		return $this->redirect(['membershipservices/index/'.$id]);
    }

	/**
    * Displays a single New model.
    * @param integer $id
    * @return mixed
    */
    public function actionView($id) {
		$data 			 		= $this->findModel($id);
		$data['service_type'] 	= Yii::$app->commonmethod->membershipservices($data->service_type);
		return $this->render('view', [
            'model' => $data,
        ]);
    }
	 
    public function actionCreate() {
        $data = array();
        $model = new AddService();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->insertdata()) {
                Yii::$app->session->setFlash('item', 'Membership plan has been created successfully!');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('item', 'Please enter valid values for all the fields!');
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
        $updateService	 	= new UpdateService();
        $model 		 		= $updateService->findIdentity($id);
        $userpost 	 		= Yii::$app->request->post('UpdateService');

        if(isset($userpost) && !empty($userpost)) {
				if($model->load(Yii::$app->request->post()) && $model->updatedata($id)) {
					Yii::$app->session->setFlash('item', 'Service has been updated successfully!');
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
		 Yii::$app->session->setFlash('item', 'Service has been deleted successully!');
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
        if (($model = Service::findOne($id)) !== null) {
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
                    Yii::$app->session->setFlash('item' ,'Status has been changed successfully.');
                } else {
                    Yii::$app->session->setFlash('item', 'No status is set for selected images, please try again.');
                }
                die();
            }
        }
    }
}
