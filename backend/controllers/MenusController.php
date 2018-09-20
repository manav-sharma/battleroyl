<?php

namespace backend\controllers;

use Yii;
use app\models\menu\Menus;
use app\models\menu\MenusSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * MenusController implements the CRUD actions for Menus model.
 */
class MenusController extends Controller
{
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
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Menus models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenusSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
		$dataProvider->pagination->pageSize = (isset($_GET['p']) ? $_GET['p'] : PAGE_LIMIT);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menus model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Menus model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menus();
	
        if ($model->load(Yii::$app->request->post())) {
			$model->mnuName 			= (isset($_POST['Menus']['mnuName']) ? $_POST['Menus']['mnuName'] : '' );
			
			$menuN = preg_replace('/\s*/', '', $_POST['Menus']['mnuName']);
			$mSlug = strtolower($menuN);
			
			$model->mnuStatus 			= $_POST['Menus']['mnuStatus'];		
			$model->menuSlug 			= $mSlug;			
			$model->mnuDateCreated 		= date('Y-m-d h:m:s');
			
				if($model->save()) {
					$data['respmesg'] = "Menu has been created successfully!";
					$data['class'] = "alert-success";
					Yii::$app->session->setFlash('item', 'Menu has been created successfully!');
					return $this->redirect('index');					
				} else {
					$data['respmesg'] = "Please enter valid values for all the fields!";
					$data['class'] = "alert-danger";	
					Yii::$app->session->setFlash('item', 'There was some error while sending your request. Please try again later!');
					return $this->render('create', [
						'model' => $model,
					]);							
				}
				return $this->redirect(['view', 'id' => $model->mnuId]);
			} else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Menus model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
			$model->mnuName 			= (isset($_POST['Menus']['mnuName']) ? $_POST['Menus']['mnuName'] : '' );
			
			$menuN = preg_replace('/\s*/', '', $_POST['Menus']['mnuName']);
			$mSlug = strtolower($menuN);
			
			$model->mnuStatus 			= $_POST['Menus']['mnuStatus'];		
			$model->menuSlug 			= $mSlug;
			
				if($model->save()) {
					$data['respmesg'] = "Menu has been updated successfully!";
					$data['class'] = "alert-success";
					Yii::$app->session->setFlash('item', 'Menu has been updated successfully!');
					return $this->redirect(['index']);	
				} else {
					$data['respmesg'] = "Please enter valid values for all the fields!";
					$data['class'] = "alert-danger";			
				}
             return $this->redirect(['view', 'id' => $model->mnuId]);
             
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
     /**
     * Updates Status an existing Menus model.
     * @param integer $id
     * @return 
     */   
	public function actionStatus($id) {
		$model = $this->findModel($id);
		 $menupost = Yii::$app->request->post('UpdateMenu');
		 if(isset($menupost) && !empty($menupost)) {
			if (Yii::$app->request->isAjax){
				$model->mnuStatus = $menupost['status'];
				if($model->save()) {
					Yii::$app->session->setFlash('item', $model->mnuStatus.' status set for selected menu successfully.');
				} else {
					Yii::$app->session->setFlash('item', 'No status is set for selected menu, please try again.');
				}
				die();
			}
		}
	}    

    /**
     * Deletes an existing Menus model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('item', 'Selected menu deleted successully!');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Menus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menus::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
