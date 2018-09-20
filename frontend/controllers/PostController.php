<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use common\models\Country;
use common\models\State;
use common\models\City;
use frontend\models\Posts;
use frontend\models\Home;
use frontend\models\Seasons;
use frontend\models\Comments;
use frontend\models\users\UpdateUser;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\users\Users;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\users\AddUserForm;
use frontend\models\users\AddMemberForm;
use common\models\Admin;
use yii\helpers\Url;
use yii\web\ErrorAction;
use yii\db\Query;

##############= FOR FILE UPLOAD =################
use yii\web\UploadedFile;
use frontend\models\users\ProfilePictureUpload;
use frontend\models\users\UserIdDocumentUpload;
use yii\data\Pagination;

/**
* Site controller
*/
class PostController extends Controller {
	public $enableCsrfValidation = false;
	private $limit = 10;

	/**
	* @inheritdoc
	*/
    public function actions() {
        return [       
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
            'class' => 'yii\authclient\AuthAction',
            'successCallback' => [$this, 'onGPAuthSuccess'],
          ],  
            'authGP' => [
            'class' => 'yii\authclient\AuthAction',
            'successCallback' => [$this, 'onGPAuthSuccess'],
          ],                     
        ];
    }
         
	/**
	* Displays homepage.
	* @return mixed
	*/
	static function _getuserId()
    {
        return Yii::$app->user->id;
    }
	
    public function actionPostlisting() {
        $query = Posts::find()->where(['status' => '1']);
		$countQuery = clone $query;
		$pages = new Pagination(['totalCount' => $countQuery->count()]);
		$models = $query->offset($pages->offset)
			->limit(3)
			->orderBy(['datecreated'=>SORT_DESC])
			->all();
		$pages->setPageSize(3);
		return $this->render('postlisting', [
			'posts' => $models,
			'pages' => $pages,
		]); 
    }
    
    public function actionPostdetail() {
		$id = Yii::$app->getRequest()->getQueryParam('id');
		$model = new Comments;
		if(empty($id)) {
			return $this->redirect(['postlisting']);
		}  else {
			//echo '<pre>'; print_r( Yii::$app->request->post()); die('c');
			if ($model->load(Yii::$app->request->post())  && $model->validate()) {
				if($model->savedata()) {
					Yii::$app->session->setFlash('item', Yii::t('yii','Your comment has been submitted for approval.'));
					return $this->redirect(['postdetail?id='.$id]);
				} else {
					Yii::$app->session->setFlash('item', Yii::t('yii','Please enter valid values for all the fields.'));
				}
			}
			$posts = Posts::findIdentity($id);
			$query = new Query;
			$query->select('*')
				->from('tbl_comments')
				->where(['status' => '1','post_id'=>$id]);
			$countQuery = clone $query;
			$pages = new Pagination(['totalCount' => $countQuery->count()]);
			$models = $query->offset($pages->offset)
				->limit(2)
				->orderBy(['date_created'=>SORT_DESC]);
			$rows = $query->all();
			$command = $query->createCommand();
			$rows = $command->queryAll();
			$pages->setPageSize(2);
			
			//echo '<pre>'; print_r($pages);
			return $this->render('postdetail', [
				'model' => $model,
				'postdetail' => $posts,
				'comments' => $rows,
				'pages' => $pages,
			]);
		} 
    }
    
    
}
