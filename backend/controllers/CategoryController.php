<?php

namespace backend\controllers;

use Yii;
use app\models\category\Category;
use app\models\category\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
		$searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
		$dataProvider->pagination->pageSize = (isset($_GET['p']) ? $_GET['p'] : PAGE_LIMIT);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post())) {

			$model->category_date_created = date('Y-m-d h:m:s');
			if($_POST ['Category'] ['parent_id']== ""){
					$model->parent_id = 0;
			} else {
				$model->parent_id = $_POST ['Category'] ['parent_id'];
			}
			
            if($model->save()) {
					Yii::$app->session->setFlash('item', 'Category has been created successfully!');
					return $this->redirect('index');
			} else {
					Yii::$app->session->setFlash('item', 'There was some error while sending your request. Please try again later!');
					return $this->render('create', [
						'model' => $model,
					]);
			}
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->category_date_created = date('Y-m-d h:m:s');
			if($_POST ['Category'] ['parent_id']== ""){
					$model->parent_id = 0;
			}
			if($model->save()) {
				Yii::$app->session->setFlash('item', 'Category has been updated successfully!');
				return $this->redirect(['index']);	
			} else {
				Yii::$app->session->setFlash('item', 'Please enter valid values for all the fields!');
				$data['class'] = "alert-danger";			
			}
			return $this->redirect(['view', 'id' => $model->category_id]);
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
		 $catpost = Yii::$app->request->post('UpdateCategory');
		 if(isset($catpost) && !empty($catpost)) {
			if (Yii::$app->request->isAjax){
				$model->category_status = $catpost['status'];
				if($model->save()) {
					Yii::$app->session->setFlash('item', $model->category_status.' status set for selected category successfully.');
				} else {
					Yii::$app->session->setFlash('item', 'No status is set for selected menu, please try again.');
				}
				die();
			}
		}
	}
	
    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
		Yii::$app->session->setFlash('item', 'Selected category deleted successully!');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
