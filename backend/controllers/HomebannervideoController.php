<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\homebannervideo\AddHomebannervideoForm;
use backend\models\homebannervideo\HomebannervideoSearch;
use backend\models\homebannervideo\UpdateHomebannervideo;
use backend\models\homebannervideo\Homebannervideo;
use common\models\Admin;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;


/**
 * Homebannervideo controller
 */
class HomebannervideoController extends Controller
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
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
		$searchModel  = Yii::createObject(HomebannervideoSearch::className());
        $dataProvider = $searchModel->search(Yii::$app->request->get());
		$dataProvider->pagination->pageSize = (isset($_GET['p']) ? $_GET['p'] : PAGE_LIMIT);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

	 /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
	return $this->render('view', [
            'model' => $this->findModel($id),
        ]);	
    }
	 
    public function actionCreate() {
        $data = array();
        $model = new AddHomebannervideoForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$postedVal = Yii::$app->request->post('AddHomebannervideoForm');
			############################################################
			if ($model->signup()) {

				Yii::$app->session->setFlash('item', 'Homebannervideo has been created successfully!');
				return $this->redirect(['index']);
			} else {
				Yii::$app->session->setFlash('item', 'Please enter valid values for all the fields!');
			}
        }
        return $this->render('signup', [
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
		$data = array();
        $Homebannervideomodel = $this->findModel($id);
        $updateHomebannervideo = new UpdateHomebannervideo();
        $model = $updateHomebannervideo->findIdentity($id);
        $userpost = Yii::$app->request->post('UpdateHomebannervideo');
        if(isset($userpost) && !empty($userpost)) {
			if($model->load(Yii::$app->request->post()) && $model->updateHomebannervideo($id)) {
				Yii::$app->session->setFlash('item', 'Homebannervideo has been updated successfully!');
				return $this->redirect(['index']);				
			} else{
				Yii::$app->session->setFlash('item', 'Please enter valid values for all the fields!');
			}
		} else{ 
			$model->setAttributes($Homebannervideomodel->getAttributes());
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
     
    public function actionDelete($id){
		$this->findModel($id)->delete();
		 Yii::$app->session->setFlash('item', 'Selected homebannervideo deleted successully!');
		return $this->redirect(['index']);
	}
	
	 /**
     * Finds the CrudTest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CrudTest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Homebannervideo::findOne($id)) !== null) {
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
        $menupost = Yii::$app->request->post('Updatebanner');
         if(isset($menupost) && !empty($menupost)) {
            if (Yii::$app->request->isAjax){
                $model->status = $menupost['status'];
                if($model->save()) {
                    if($model->status == '1') { $st = 'Active'; } else { $st = 'Inactive'; }
                    Yii::$app->session->setFlash('item' ,$st.' status set for selected homebannervideo successfully.');
                } else {
                    Yii::$app->session->setFlash('item', 'No status is set for selected homebannervideo, please try again.');
                }
                die();
            }
        }
    }  
    
}
