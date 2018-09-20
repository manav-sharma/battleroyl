<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\advertisements\AdvertisementSearch;
use backend\models\advertisements\Advertisement;
use backend\models\advertisements\UpdateAdvertisement;
use common\models\Admin;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\helpers\Html;
use backend\models\users\Users;
use backend\models\memberships\Package;

use yii\web\UploadedFile;
use common\models\ImageUpload;
/**
 * Advertisement controller
 */
class AdvertisementsController extends Controller
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
                        'actions' => ['index','delete','view','update','status'],
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
		$searchModel  = Yii::createObject(AdvertisementSearch::className());
        $dataProvider = $searchModel->search(Yii::$app->request->get());
		$dataProvider->pagination->pageSize = (isset($_GET['p']) ? $_GET['p'] : PAGE_LIMIT);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

	/**
    * Displays a single Service model.
    * @param integer $id
    * @return mixed
    */
    public function actionView($id) {
		$data = $this->findModel($id);
		$user = Users::findOne($data->user_id);
		$package = Package::findOne($data->membership_id);
		$data['user_id'] = $user['firstname'].' '.$user['lastname'];
		$data['membership_id'] = $package['name'];
		$images = json_decode($data['user_images']);
		$mImage='';
		if(isset($data['user_images']) && !empty($data['user_images'])) {
			foreach($images as $img) {
				$mImage = $mImage.' '.Html::img(SITE_URL."common/uploads/images/".$img, ['width' => '80px','height' => '80px']);
			}
		}
		$data['user_images'] = $mImage;
		return $this->render('view', [
            'model' => $data,
        ]);	
    }

    /**
    * Update an existing record.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id
    * @return mixed
    */
    public function actionUpdate($id) {
        $modelImageUpload 	= new ImageUpload();
		$data 			  	= array();
        $updateModel 		= $this->findModel($id);
        $updateService	 	= new UpdateAdvertisement();
        $model 		 		= $updateService->findIdentity($id);
        $userpost 	 		= Yii::$app->request->post('UpdateAdvertisement');
        if(isset($userpost) && !empty($userpost)) {
				$model->advertisement_image = '';
				if (Yii::$app->request->isPost) {
					$modelImageUpload->advertisement_image = UploadedFile::getInstance($modelImageUpload, 'advertisement_image');
					if ($modelImageUpload->advertisement_image && $uploadedFileNameArray = $modelImageUpload->upload_advertisement_image()) {
						$model->advertisement_image = $uploadedFileNameArray['originalImage'];
					}
				}
				if($model->load(Yii::$app->request->post()) && $model->updatedata($id)) {
					Yii::$app->session->setFlash('item', 'Advertisement has been updated successfully!');
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
    * Deletes an existing record.
    * If deletion is successful, the browser will be redirected to the 'index' page.
    * @param integer $id
    * @return mixed
    */
    public function actionDelete($id) {
		$this->findModel($id)->delete();
		 Yii::$app->session->setFlash('item', 'Selected record deleted successully!');
		return $this->redirect(['index']);
	}
	
	/**
    * Finds the record based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return CrudTest the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
    protected function findModel($id) {
        if (($model = Advertisement::findOne($id)) !== null) {
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
                    Yii::$app->session->setFlash('item' ,'Advertisement status has been changed successfully.');
                } else {
                    Yii::$app->session->setFlash('item', 'No status is set for selected item, please try again.');
                }
                die();
            }
        }
    }
}
