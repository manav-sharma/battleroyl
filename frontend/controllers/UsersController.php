<?php

namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\users\AddUserForm;
use frontend\models\users\UserSearch;
use frontend\models\users\UpdateUser;
use frontend\models\users\ChangePassword;
use frontend\models\users\Users;
use common\models\Admin;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use frontend\models\users\ProfilePictureUpload;
/**
 * Site controller
 */
class UsersController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [

                    [
                        'actions' => ['index','update','myprofile','settings','password'],
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

        
    /**
     * list users
     * @return mixed
    */ 
    public function actionIndex() {
        //$this->layout = '@frontend/web/themes/myguyde/views/layouts/main';

        $searchModel = Yii::createObject(UserSearch::className());
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        $dataProvider->pagination->pageSize = 10;
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    
    /**
     * Displays profile of a user.
     *
     * @return mixed
     */
    public function actionMyprofile() {
		$userId = Yii::$app->user->getId();
		$userModel = $this->findModel($userId);
        return $this->render('myprofile', ['model' => $userModel]);
    }
    
    /**
     * Update an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionSettings() {
        $id = Yii::$app->user->getId();
        $modelImageUpload = new ProfilePictureUpload();
        $userModel = $this->findModel($id);
        $updateUser = new UpdateUser();
        $model = $updateUser->findIdentity($id);
        $userpost = Yii::$app->request->post('UpdateUser');
        if (isset($userpost) && !empty($userpost)) {
            $model->profile_image = '';
            if (Yii::$app->request->isPost) {
                $modelImageUpload->profile_image = UploadedFile::getInstance($modelImageUpload, 'profile_image');
                if ($modelImageUpload->profile_image && $uploadedFileNameArray = $modelImageUpload->upload()) {
                    $model->profile_image = $uploadedFileNameArray['originalImage'];
                }
            }
            if ($model->load(Yii::$app->request->post()) && $model->updateUser($id)) {
                Yii::$app->session->setFlash('item', 'Your profile has been updated successfully!');
                return $this->redirect(['users/settings']);
            } else {
                Yii::$app->session->setFlash('item', 'Your profile has not been updated successfully!');
            }
        } else {
            $model->setAttributes($userModel->getAttributes());
        }
        
        return $this->render('edit-profile', [
            'model' => $model,
            'modelImageUpload' => $modelImageUpload,
            
        ]);
    }
    
 
    
    public function actionPassword() {
		$id = Yii::$app->user->getId();
		$updatePassword = new ChangePassword();
		$changePassword = Yii::$app->request->post('ChangePassword');
		if (isset($changePassword) && !empty($changePassword)) {
            if ($updatePassword->load(Yii::$app->request->post()) && $updatePassword->UpdatePassword($id)) {
                Yii::$app->session->setFlash('item', 'Your password has been updated successfully!');
                return $this->redirect(['users/password']);
            } else {
                Yii::$app->session->setFlash('item', 'Your password has not been updated successfully!');
            }
        }
        return $this->render('password',['model' => $updatePassword]);
    }
   
    /**
     * Finds the CrudTest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CrudTest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
   
    
    

}
