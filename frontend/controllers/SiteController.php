<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use common\models\Country;
use common\models\State;
use common\models\City;
use frontend\models\Home;
use frontend\models\Seasons;
use frontend\models\ContactForm;
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
class SiteController extends Controller {
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
    public function actionIndex() {
		//$model = new \frontend\models\Search();
        return $this->render('home');
    }
    
    static function _getuserId()
    {
        return Yii::$app->user->id;
    }
    
	/**
	* Displays homepage.
	* @return mixed
	*/
    public function actionHome() {
        $model   	= new Home;
        $videos  	= $model->homeVideos();
        $posts  	= $model->homePosts();
        $parentCity = $model->homeParentcity();
        $aboutUs 	= $model->getAboutus();
        //echo '<pre>'; print_r($aboutUs); die('con');
        return $this->render('home',['model'=>array('parentcity'=>$parentCity,'videos'=>$videos,'posts'=>$posts,'about'=>$aboutUs)]);
    }
    
    /**
	* Displays homepage.
	* @return mixed
	*/
    public function actionLanding() {
        return $this->render('landing');
    }
    
    
    public function actionSeason(){
		
		$model     = new Seasons;
		$parenCity = Yii::$app->getRequest()->getQueryParam('parentCity');
		$subCity   =  Yii::$app->getRequest()->getQueryParam('subCity');
		$seasons   = $model->getseason($parenCity,$subCity );
		return $this->render('season',['season'=>$seasons]);
	}
	
	
	public function actionViewcontestant(){
		if (Yii::$app->user->isGuest) {
            return $this->redirect( Url::to(['site/login']) );
        }
		$season_id = Yii::$app->getRequest()->getQueryParam('season_id');
		$query = new Query;
		$query->select('*')
			  ->from('tbl_contestant')
			  ->where(['season_id'=>$season_id,'status'=>'1'])
			  ->orderBy(['contestant_name'=>SORT_ASC]);
		$countQuery = clone $query;	  
		$pages = new Pagination(['totalCount' => $countQuery->count()]);
		$models = $query->offset($pages->offset)
						->limit(12);		
		$rows = $query->all();
		$command = $query->createCommand();
		$rows = $command->queryAll();
		$pages->setPageSize(12);
		if(!empty( $rows )) {
			foreach($rows as $values) {
				$newquery = new Query;
				$newquery->select('*')
				  ->from('tbl_contestant_detail')
				  ->where(['contestant_id'=>$values['contestant_id']]);
				$getrows = $newquery->all();
				$newcommand = $newquery->createCommand();
				$getrows = $newcommand->queryAll();
				$newArray[] = array(
					'contestant_id'  		  => $values['contestant_id'],
					'contestant_name'  		  => $values['contestant_name'],
					'contestant_description'  => $values['contestant_description'],
					'contestant_youtubelink'  => $values['contestant_youtubelink'],
					'contestant_votes'  	  => $values['contestant_votes'],
					'result' 				  => $values['result'],
					'status'  				  => $values['status'],
					'season_id'  			  => $values['season_id'],
					'date_created'  		  => $values['date_created'],
					'images' 				  => $getrows
				);
			}
		} else {
			$newArray = $rows;
		}
		return $this->render('contestants',['contestants'=>$newArray,'pages' => $pages,'season_id'=>$season_id]);
	}
	
	public function actionViewarchivecontestant(){
		if (Yii::$app->user->isGuest) {
            return $this->redirect( Url::to(['site/login']) );
        }
		$season_id = Yii::$app->getRequest()->getQueryParam('season_id');
		$query = new Query;
		$query->select('*')
			  ->from('tbl_contestant')
			  ->where(['season_id'=>$season_id])
			  ->orderBy(['contestant_name'=>SORT_ASC]);
		$countQuery = clone $query;	  
		$pages = new Pagination(['totalCount' => $countQuery->count()]);
		$models = $query->offset($pages->offset)
						->limit(12);		
		$rows = $query->all();
		$command = $query->createCommand();
		$rows = $command->queryAll();
		$pages->setPageSize(12);
		if(!empty( $rows )) {
			foreach($rows as $values) {
				$newquery = new Query;
				$newquery->select('*')
				  ->from('tbl_contestant_detail')
				  ->where(['contestant_id'=>$values['contestant_id']]);
				$getrows = $newquery->all();
				$newcommand = $newquery->createCommand();
				$getrows = $newcommand->queryAll();
				$newArray[] = array(
					'contestant_id'  		  => $values['contestant_id'],
					'contestant_name'  		  => $values['contestant_name'],
					'contestant_description'  => $values['contestant_description'],
					'contestant_youtubelink'  => $values['contestant_youtubelink'],
					'contestant_votes'  	  => $values['contestant_votes'],
					'result' 				  => $values['result'],
					'status'  				  => $values['status'],
					'season_id'  			  => $values['season_id'],
					'date_created'  		  => $values['date_created'],
					'images' 				  => $getrows
				);
			}
		} else {
			$newArray = $rows;
		}
		return $this->render('contestants',['contestants'=>$newArray,'pages' => $pages,'season_id'=>$season_id]);
	}
	
	
	public function actionViewleaderboard(){
		if (Yii::$app->user->isGuest) {
            return $this->redirect( Url::to(['site/login']) );
        }
		$season_id = Yii::$app->getRequest()->getQueryParam('season_id');
		$model     = new Seasons; 
		$query = new Query;
		$query->select('*')
			  ->from('tbl_contestant')
			  ->where(['season_id'=>$season_id,'status'=>'1'])
			  ->orderBy(['contestant_votes'=>SORT_DESC]);
		$countQuery = clone $query;	  
		$pages = new Pagination(['totalCount' => $countQuery->count()]);
		$models = $query->offset($pages->offset)
						->limit(12);		
		$rows = $query->all();
		$command = $query->createCommand();
		$rows = $command->queryAll();
		$pages->setPageSize(12);
		if(!empty( $rows )) {
			foreach($rows as $values) {
				$newquery = new Query;
				$newquery->select('*')
				  ->from('tbl_contestant_detail')
				  ->where(['contestant_id'=>$values['contestant_id']]);
				$getrows = $newquery->all();
				$newcommand = $newquery->createCommand();
				$getrows = $newcommand->queryAll();
				$newArray[] = array(
					'contestant_id'  		  => $values['contestant_id'],
					'contestant_name'  		  => $values['contestant_name'],
					'contestant_description'  => $values['contestant_description'],
					'contestant_youtubelink'  => $values['contestant_youtubelink'],
					'contestant_votes'  	  => $values['contestant_votes'],
					'result' 				  => $values['result'],
					'status'  				  => $values['status'],
					'season_id'  			  => $values['season_id'],
					'date_created'  		  => $values['date_created'],
					'images' 				  => $getrows
				);
			}
		} else {
			$newArray = $rows;
		}
		$highest_votes = $model->contestantWithHighestVotes($season_id);
		return $this->render('leaderboards',['leaderboards'=>$newArray,'pages' => $pages,'highestvote_contestant'=>$highest_votes]);
	}
	
	
	public function actionArchives(){
		$model     	   					= 	new Seasons;
		$parenCity 						= 	Yii::$app->getRequest()->getQueryParam('parentCity');
		$subCity   						=  	Yii::$app->getRequest()->getQueryParam('subCity');
		if(!empty(Yii::$app->getRequest()->getQueryParam('year'))){
			$year = Yii::$app->getRequest()->getQueryParam('year');
		} else {
			$lastclosedSeason =  $model->getLastClosedSeason();
			$year = $lastclosedSeason['season_year'];
		}
		$seasonDeatils   = 	$model->getSeasonDeatils($parenCity,$subCity,$year);
		if(!empty($seasonDeatils)) {
			$contestantWinnerDeatils   		= 	$model->getcontestantWinnerDeatils($seasonDeatils['season_id']);
			$contestantRunnerUpDeatils     	= 	$model->getcontestantRunnerUpDeatils($seasonDeatils['season_id']);
			$contestantDeatils     			= 	$model->getcontestantDeatils($seasonDeatils['season_id']);
			$yearDeatils   					= 	$model->getyearDeatils($parenCity,$subCity);
			$seasonGroupImages   		    = 	$model->getgroupImages($seasonDeatils['season_id']);
			$model = array('winnerDetails'=>$contestantWinnerDeatils,'runnerUpDeatils'=>$contestantRunnerUpDeatils,'contestantDeatils'=>$contestantDeatils,'yearDeatils'=>$yearDeatils,'season_details'=>$seasonDeatils,'seasonGroupImages'=>$seasonGroupImages);
		
		} else {
			$model = '';
		}

 		return $this->render('archives',['archiveDetails'=>$model]);
	}
	
	
	public function actionContestantdetail(){
		$model     	   = new Seasons;
		$contestant_id = Yii::$app->getRequest()->getQueryParam('contestant_id');
		$details       = $model->getContestantDetails($contestant_id);
		$images        = $model->getContestantImages($contestant_id);
 		return $this->render('contestantdetails',['contestantdetails'=>$details,'images'=>$images]);
	}
	
	
	public function actionStandings(){
		if (Yii::$app->user->isGuest) {
            return $this->redirect( Url::to(['site/login']) );
        }
		$parentCity = Yii::$app->getRequest()->getQueryParam('parentCity');
		$subCity = Yii::$app->getRequest()->getQueryParam('subCity');
		$year = date("Y");
		$model     = new Seasons; 
		$seasonDeatils   = 	$model->getActiveSeasonDeatils($parentCity,$subCity,$year);
		if(!empty($seasonDeatils)) {
			$season_id = $seasonDeatils['season_id'];
			$query = new Query;
			$query->select('*')
				  ->from('tbl_contestant')
				  ->where(['season_id'=>$season_id,'status'=>'1'])
				  ->orderBy(['contestant_votes'=>SORT_DESC]);
		
			
			//~ $query->select('t.*,(@cnt := @cnt + 1) AS rank')
				  //~ ->from('tbl_contestant as t')
				  //~ ->join('CROSS JOIN','(SELECT @cnt := 0) AS rank')
				  //~ ->where(['season_id'=>$season_id,'status'=>'1'])
				  //~ ->orderBy(['contestant_votes'=>SORT_DESC]);
			
				  
			$countQuery = clone $query;	  
			$pages = new Pagination(['totalCount' => $countQuery->count()]);
			$models = $query->offset($pages->offset)
							->limit(12);		
			$rows = $query->all();
			$command = $query->createCommand();
			$rows = $command->queryAll();
			$pages->setPageSize(12);
			if(!empty( $rows )) {
				foreach($rows as $values) {
					$newquery = new Query;
					$newquery->select('*')
					  ->from('tbl_contestant_detail')
					  ->where(['contestant_id'=>$values['contestant_id']]);
					$getrows = $newquery->all();
					$newcommand = $newquery->createCommand();
					$getrows = $newcommand->queryAll();
					$newArray[] = array(
						'contestant_id'  		  => $values['contestant_id'],
						'contestant_name'  		  => $values['contestant_name'],
						'contestant_description'  => $values['contestant_description'],
						'contestant_youtubelink'  => $values['contestant_youtubelink'],
						'contestant_votes'  	  => $values['contestant_votes'],
						'result' 				  => $values['result'],
						'status'  				  => $values['status'],
						'season_id'  			  => $values['season_id'],
						'date_created'  		  => $values['date_created'],
						'images' 				  => $getrows
					);
				}
			} else {
				$newArray = $rows;
			}
			$highest_votes = $model->contestantWithHighestVotes($season_id);
			$details = array('contestants'=>$newArray,'pages' => $pages,'highestvote_contestant'=>$highest_votes);
		} else {
			$details = '';
		}
		
		//echo '<pre>'; print_r($details); //die;
		
		return $this->render('standings',['standings'=>$details]);
	}
	
	
	
	public function actionSubcities() {
		if(!empty(Yii::$app->request->post('parent_id'))) {
			$parent_id = Yii::$app->request->post('parent_id');
		} else {
			$parent_id  = '0';
		}
        $query = new Query;
        $query->select('*')
              ->from('tbl_sub_cities')
              ->where(['main_city_id'=>$parent_id]);
        $rows = $query->all();
        $command = $query->createCommand();
        $rows = $command->queryAll();
        echo json_encode($rows);
	}
	
	
	
	 public function actionFaq(){
		$model   = new Home;
		$faq     = $model->getFaq();
		return $this->render('faq',['faq'=>$faq]);
	}
   

	public function actionRegister() {
		if (!\Yii::$app->user->isGuest) {
            return $this->redirect( Url::to(['users/myprofile']) );
        }
		$model = new AddUserForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$userinfo = Yii::$app->request->post();
            if($model->savedata()) {
                //$res = $this->_sendUserRegistrationEmail($userinfo);
                Yii::$app->session->setFlash('item', Yii::t('yii','Your account has been created successfully. Please use your registered email and password to login.'));
                return $this->redirect(['login']);
            } else {
                Yii::$app->session->setFlash('item', Yii::t('yii','Please enter valid values for all the fields.'));
            }
		}
		return $this->render('register',['model'=>$model]);
	}
	
	
	
	public function actionContactUs() {
		$model = new ContactForm();
        
        $request = Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($model->sendEmail($request['ContactForm']) )
                Yii::$app->session->setFlash('message', Yii::t('yii','Thank you for contacting us. We will get in touch with you shortly.'));
            else
                Yii::$app->session->setFlash('message', Yii::t('yii','Your request could not be processed due to techinical errors. Please try again.'));
            return $this->redirect(['site/contact-us']);        
   
        } else {
            return $this->render('contact-us', [
                'model' => $model,
            ]);
        }
	}


	/*
	* Logs out the current user.
	*
	* @return mixed
	*/
    public function actionLogout() {
        Yii::$app->user->logout();
         return $this->redirect('home');
        //return $this->goHome();
    }
    
    public function actionLogin() {
		$session = Yii::$app->session;
		$parenCity = $session->get('parenCity');
		$subCity = $session->get('subCity');
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect( Url::to(['users/myprofile']) );
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {	
			if($session->has('parenCity') && $session->has('subCity') ) {
				return $this->redirect( Url::to(['site/season?parentCity='.$parenCity.'&subCity='.$subCity]) );
			} else {
				return $this->redirect( Url::to(['users/myprofile']) );
			}
           
        } else if(!empty(Yii::$app->request->post() ) ) {
			$message = Yii::t('yii',"Incorrect Email or password.");
			if(isset($model->errors['user']))
				$message = $model->errors['user'][0];
				Yii::$app->session->setFlash('alertitem', $message);            
        }
  
        return $this->render('login', [
            'model' => $model
        ]);
    }

	/*
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
            throw new NotFoundHttpException(Yii::t('yii','The requested page does not exist.'));
        }
    }

	/*
	* Requests password reset.
	* @return mixed
	*/
    public function actionForgotPassword() {
		if (!\Yii::$app->user->isGuest) {
			return $this->redirect( Url::to(['users/myprofile']) );
		}
		$model = new PasswordResetRequestForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('item', Yii::t('yii','Password reset link has been sent to your email address.'));
				return $this->redirect( Url::to(['site/login']) );
            } else {
                Yii::$app->session->setFlash('item', Yii::t('yii','Sorry, We are unable to reset the password for the email provided.'));
                return $this->redirect( Url::to(['site/login']) );
            }
        }
        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }
 
	/**
	* Displays reset password request.
	* @return mixed
	*/
	public function actionRequestpasswordreset() {
		return $this->render('requestpasswordreset');
	}

	/**
	* Resets password.
	* @param string $token
	* @return mixed
	* @throws BadRequestHttpException
	*/
    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('item', Yii::t('yii','Your password was reset successfully.'));
            return $this->redirect( Url::to(['site/login']) );
        }
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
