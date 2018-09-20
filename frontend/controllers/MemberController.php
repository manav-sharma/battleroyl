<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\users\UpdateMember;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\users\Users;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\users\AddUserForm;
use common\models\Admin;
use yii\helpers\Url;
use yii\web\ErrorAction;
use common\models\Country;
use common\models\State;
use common\models\City;
use yii\data\Pagination;
use yii\db\Query;

##############= FOR FILE UPLOAD =################
use yii\web\UploadedFile;
use frontend\models\users\ProfilePictureUpload;
use frontend\models\users\UserIdDocumentUpload;

/**
 * Member controller
 */
class MemberController extends Controller {
    /**
     * @inheritdoc
    */
    public $enableCsrfValidation = false;
    private $limit = 10;
    public function actions() {
        return [       
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],                    
        ];
    }
      
      /**
     * @ Function Name		: beforeAction
     * @ Function Params	: $action{object} 
     * @ Function Purpose 	: The function will execute before each function call
     * @ Function Returns	: boolean true/false
     */

    public function beforeAction($action) {
        if (parent::beforeAction($action)) {
            if(Yii::$app->user->isGuest)
            {
				if(Yii::$app->controller->action->id != 'index')
					Yii::$app->session->set('afterlogin',Yii::$app->request->url);
				
                return Yii::$app->user->loginRequired();
                
            }
            return true; 
        } else {
            return false;
        }
    }
     
	/**
	 * @ Function Name		: actionIndex
	 * @ Function Params	: 
	 * @ Function Purpose 	: member profile
	 * @ Function Returns	: render view
	 */  
    public function actionIndex() {
		$attributes = Yii::$app->user->identity->getattributes();
		if(isset($attributes['usrType']) && $attributes['usrType'] == CUSTOMER) {
			return $this->redirect( Url::to(['customer/index']) );
		}		
        return $this->render('index');
    }

	/**
	 * @ Function Name		: actionBookinghistory
	 * @ Function Params	: 
	 * @ Function Purpose 	: get booking details
	 * @ Function Returns	: render view
	 */    
    public function actionBookinghistory() {
		$attributes = Yii::$app->user->identity->getattributes();
		if(isset($attributes['usrType']) && $attributes['usrType'] == CUSTOMER) {
			return $this->redirect( Url::to(['customer/index']) );
		}		
		 $userId 	= Yii::$app->user->getId();
         $dataArray = array();

         #################= Get All Booking Histroy =###############
         $query = new Query;
         $query->select('booking.*,guyde.usrFirstname as guydeFN,guyde.usrLastname as guydeLN,customer.usrFirstname as customerFN,customer.usrLastname as customerLN')
         ->from('booking')
         ->join('LEFT JOIN', 'user guyde', 'guyde.id = booking.guyde_user_id')
         ->join('LEFT JOIN', 'user customer', 'customer.id = booking.customer_user_id')
         ->where('booking.customer_user_id = '.$userId);
         //->where('booking.booking_status ="1" AND booking.customer_user_id = '.$userId.' OR booking.guyde_user_id = '.$userId);
         $countQuery = clone $query;
         $pagesA 	 = new Pagination(['totalCount' => $countQuery->count()]);
         $pagesA->setPageSize($this->limit);
		 $query->offset($pagesA->offset)->limit($this->limit);         
         $bookingResultAll = $query->createCommand()->queryAll();

         #################= Get Recieved Payment Booking =###############         
         $query = new Query;
         $query->select('booking.*,guyde.usrFirstname as guydeFN,guyde.usrLastname as guydeLN,customer.usrFirstname as customerFN,customer.usrLastname as customerLN')
         ->from('booking')
         ->join('LEFT JOIN', 'user guyde', 'guyde.id = booking.guyde_user_id')
         ->join('LEFT JOIN', 'user customer', 'customer.id = booking.customer_user_id')
         ->where('booking.guyde_user_id = '.$userId.' AND booking.adminPaymentStatus = "1" AND booking.booking_status="1"');

         $countQuery = clone $query;
         $pagesR 	 = new Pagination(['totalCount' => $countQuery->count()]);
         $pagesR->setPageSize($this->limit);
		 $query->offset($pagesR->offset)->limit($this->limit);         
         $bookingResultRecieved = $query->createCommand()->queryAll();   
		 ####=	adminPaymentStatus=1/recieved payment =#####

		 #################= Get Pending Payment Booking =###############
		 $query = new Query;
         $query->select('booking.*,guyde.usrFirstname as guydeFN,guyde.usrLastname as guydeLN,customer.usrFirstname as customerFN,customer.usrLastname as customerLN')
         ->from('booking')
         ->join('LEFT JOIN', 'user guyde', 'guyde.id = booking.guyde_user_id')
         ->join('LEFT JOIN', 'user customer', 'customer.id = booking.customer_user_id')
         ->where('booking.guyde_user_id = '.$userId.' AND (booking.adminPaymentStatus = "0" AND booking.booking_status="1" || booking.booking_status="3")');
         
         $countQuery = clone $query;
         $pagesP 	 = new Pagination(['totalCount' => $countQuery->count()]);
         $pagesP->setPageSize($this->limit);
		 $query->offset($pagesP->offset)->limit($this->limit);         
         $bookingResultPending = $query->createCommand()->queryAll();
         ####=	adminPaymentStatus=0/pending payment =#####

         $dataArray = array_merge($dataArray, [            
              'bookingResultAll' 	  => $bookingResultAll,
              'bookingResultRecieved' => $bookingResultRecieved,
              'bookingResultPending'  => $bookingResultPending,
              'pagesA' => $pagesA,
              'pagesR' => $pagesR,
              'pagesP' => $pagesP,
         ]);

		 return $this->render('bookinghistory',$dataArray);
	}

	/**
	 * @ Function Name		: actionSettings
	 * @ Function Params	: 
	 * @ Function Purpose 	: update customer profile
	 * @ Function Returns	: render view
	 */
    public function actionSettings() {
		$attributes = Yii::$app->user->identity->getattributes();
		if(isset($attributes['usrType']) && $attributes['usrType'] == CUSTOMER) {
			return $this->redirect( Url::to(['customer/index']) );
		}		
        #####################= FILEUPLOAD MODEL =####################
        $modelUserProfilePictureUpload = new ProfilePictureUpload();
        $modelUserIdDocumentUpload = new UserIdDocumentUpload();

        ######= VALIDATION RULE TO MAKE FILE UPLOAD MENDATORY =######
        $modelUserProfilePictureUpload->scenario = 'update-profile';
        $modelUserIdDocumentUpload->scenario = 'update-profile';
		
		$data = array();
		$id = Yii::$app->user->getId();
        $memberModel = $this->findModel($id);
        $updateMember = new \frontend\models\users\UpdateMember();
        $model = $updateMember->findIdentity($id);
        $model->scenario = 'update';

        $userpost = Yii::$app->request->post('UpdateMember');
        if(isset($userpost) && !empty($userpost)) {
			//echo"<pre>"; print_r($userpost); exit();
			$model->usrProfileImage = '';
			$model->usrIdDocument	= '';
            ####################= PROFILE IMAGE UPLOAD =###################
				if (Yii::$app->request->isPost) { 
					$modelUserProfilePictureUpload->usrProfileImage = UploadedFile::getInstance($modelUserProfilePictureUpload, 'usrProfileImage');
					if ($modelUserProfilePictureUpload->usrProfileImage && $uploadedFileNameArray = $modelUserProfilePictureUpload->upload() ) {
						$model->usrProfileImage = $uploadedFileNameArray['originalImage'];
			####= return array('originalImage'=>$fileNameWithExtension); =####
					}
				}

            #######################= FILE UPLOAD =######################
            if (Yii::$app->request->isPost) {
                $modelUserIdDocumentUpload->usrIdDocument = UploadedFile::getInstance($modelUserIdDocumentUpload, 'usrIdDocument');
                if ($modelUserIdDocumentUpload->usrIdDocument && $uploadedFileNameVal = $modelUserIdDocumentUpload->uploadfile()) {
                    $model->usrIdDocument = $uploadedFileNameVal;
                }
            }

			############################################################	
			$userpost['usrProfileImage']  = $model->usrProfileImage;
			$userpost['usrIdDocument'] 	  = $model->usrIdDocument;
			 if($model->load(Yii::$app->request->post()) && $model->becomeMember( $id , $userpost )) {
				#######= guyde services =######
				$this->guydeServices($userpost,$id);
				$this->guide_availability($userpost,$id);
				###############################
				if(!empty($userpost['usrIdDocument'])) { $this->_uploadIDDocumentNotification($userpost); }
				Yii::$app->session->setFlash('item', Yii::t('yii','Your profile information has been updated successfully.'));
				return $this->redirect(['index']);		
			} else {
				Yii::$app->session->setFlash('item', Yii::t('yii','Please enter valid values for all the fields.'));
			}
		} else {
			$model->setAttributes($memberModel->getAttributes());
		}
		$model->setAttributes($memberModel->getAttributes());

        return $this->render('settings', [
           'model' => $model,
           'modelProfilePictureUpload' => $modelUserProfilePictureUpload,
           'modelUserIdDocumentUpload' => $modelUserIdDocumentUpload,
        ]);
    }
    
    /**
     * Changes users password
     * @return mixed
     */
    public function actionChangePassword()
    {
        ##################= UPDATE CUSTOMER DETAILS =##################
        $data = array();
        $id = Yii::$app->user->getId();
        $Usersmodel = $this->findModel($id);
        $updateUser = new \frontend\models\users\UpdateUser();
        $model = $updateUser->findIdentity($id);
        $model->scenario = 'update-password';
        $userpost = Yii::$app->request->post('UpdateUser');

        if (isset($userpost) && !empty($userpost)) {           

            if ($model->load(Yii::$app->request->post()) && $model->updatePassword($id, $userpost)) {
                Yii::$app->session->setFlash('item', Yii::t('yii', 'You have changed your password successfully.'));
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('item', Yii::t('yii', 'Unable to update password, please try again!'));
            }
        } else {
            $model->setAttributes($Usersmodel->getAttributes());
        }

        $model->setAttributes($Usersmodel->getAttributes());
        return $this->render('change-password', [
            'model' => $model,
        ]);
    }

	/**
	 * @ Function Name		: actionStates
	 * @ Function Params	: 
	 * @ Function Purpose 	: get states
	 * @ Function Returns	: json
	 */
    public function actionStates() {
		$countryID = Yii::$app->request->post('id');
		$states = State ::find()->where(['country_id' => $countryID])->asArray()->all();
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $states;
    }

	/**
	 * @ Function Name		: actionUpdatecities
	 * @ Function Params	: 
	 * @ Function Purpose 	: get cities
	 * @ Function Returns	: json
	 */     
    public function actionUpdatecities() {
		$stateID = Yii::$app->request->post('id');
		$cities = City ::find()->where(['state_id' => $stateID])->asArray()->all();
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $cities;
    }

	/**
	 * @ Function Name		: findModel
	 * @ Function Params	: $id
	 * @ Function Purpose 	: find model
	 * @ Function Returns	: mixed
	 */     
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii','The requested page does not exist.'));
        }
    }  
     
    /**
     * @ Function Name		: _uploadIDDocumentNotification
     * @ Function Params	: $postArr { array }
     * @ Function Purpose 	: send email to admin
     * @ Function Returns	: mixed
     */       
    private function _uploadIDDocumentNotification( $postArr ) {

		#############################= Send User Registration Email =##########################
		$fromEmail = $this->getAdminEmailID();
		$alias='UPLOADDOCUMENT01';
		$emailContent = $this->getEmailContent($alias);
		if(isset($emailContent) && !empty($emailContent)) {
			$clink = '<a href="'.DOCUMENT_DOWNLOAD_PATH.$postArr['usrIdDocument'].'" target="_blank" >here</a>';
			$msg = '';
			$msg .=  $emailContent['message'];
			$time =  date('d M, Y - h:m A');
			$logo = '<a href=""><img src = "' . SITE_LOGO . '" /></a>';

			$fromEmail = $this->getAdminEmailID();
			$subject  ="New document uploaded by Insider.";
			$message  ='';
			$message .='<tr>';
				$message .='<td height="15"></td>';
			$message .='</tr>';
			$name = $postArr['usrFirstname'].' '.$postArr['usrLastname'];
			$msg = str_replace("<{username}>", 'Admin',  str_replace("&lt;{username}&gt;", 'Admin', $msg));
			$msg = str_replace("<{name}>", $name,  str_replace("&lt;{name}&gt;", $name, $msg));
			$msg = str_replace("<{link}>", $clink,  str_replace("&lt;{link}&gt;", $clink, $msg));		
			$msg = str_replace("<{logo}>", $logo,  str_replace("&lt;{logo}&gt;", $logo, $msg));
			$msg = str_replace("<{time}>", $time,  str_replace("&lt;{time}&gt;", $time, $msg));
			$msg = str_replace("<{subject}>", $subject,  str_replace("&lt;{subject}&gt;", $subject, $msg));
			$msg = str_replace("<{baseurl}>", SITE_URL,  str_replace("&lt;{baseurl}&gt;", SITE_URL, $msg));
			$msg = str_replace("<{content}>", $message,  str_replace("&lt;{content}&gt;", $message, $msg));
				   
			$mail = Yii::$app->mailer->compose(['html' => 'layouts/mail1'],['content' => $msg, 'subject' => $subject])
			->setFrom($postArr['email'])
			->setTo($fromEmail)
			->setSubject($subject)
			->send();
			return $mail;
		} else {					
			$subject  ="New document uploaded by user.";
			$message  ='';
			$message .='<tr>';
				$message .='<td height="26" style="font-size:15px; font-weight:500; color:#333333;">Dear Admin,</td>';
			$message .='</tr>';
			$message .='<tr>';
				$message .='<td style="font-size:13px; color:#585858; line-height:18px; padding-bottom:10px;">'.$postArr['usrFirstname'].' '.$postArr['usrLastname'].' has uploaded identity document. Click <a href="'.DOCUMENT_DOWNLOAD_PATH.$postArr['usrIdDocument'].'" target="_blank" >here</a> to review the document.</td>';
			$message .='</tr>';
			$message .='<tr>';
				$message .='<td height="15"></td>';
			$message .='</tr>';
			
			$mail = Yii::$app->mailer->compose(['html' => 'layouts/mail'],['content' => $message, 'subject' => $subject])
			->setFrom($postArr['email'])
			->setTo($fromEmail)
			->setSubject($subject)
			->send();
			return $mail;
		}
		###########################################################################################
	}    


    /**
     * @ Function Name		: actionRatings
     * @ Function Params	: 
     * @ Function Purpose 	: get member rating
     * @ Function Returns	: render view
     */ 
    public function actionRatings() {
		 $userId = Yii::$app->user->getId();
		 $dataArray = array();
		 $query = new Query;
		 $query->select('feedback_rating.*,us.usrFirstname , us.usrLastname, us.usrProfileImage,us.gender,bk.booking_destination as location')
		 ->from('feedback_rating')
		 ->join('LEFT JOIN', 'user us', 'us.id = feedback_rating.sender_userid')
		 ->join('LEFT JOIN', 'booking bk', 'bk.booking_id = feedback_rating.booking_id')
		 ->where('feedback_rating.status = "1" AND feedback_rating.receiver_userid = '.$userId.' ORDER BY feedback_rating.id DESC');
		 $countQuery = clone $query;
		 $pages 	 = new Pagination(['totalCount' => $countQuery->count()]);
		 $pages->setPageSize($this->limit);
		 $query->offset($pages->offset)->limit($this->limit);         
		 $ratingDetails = $query->createCommand()->queryAll();
		 $dataArray 	= array_merge($dataArray, [            
			  'ratingDetails' => $ratingDetails,
			  'pages' 	=> $pages,
		 ]);
		 return $this->render('ratings',$dataArray);
	}

    /**
     * @ Function Name		: actionSendVerificationCode
     * @ Function Params	: 
     * @ Function Purpose 	: send verification code
     * @ Function Returns	: render view
     */ 
	public function actionSendVerificationCode() {
		$userId  		=   Yii::$app->user->getId();
		$uniqueToken	=	mt_rand(100000, 999999);

		if($uniqueToken) {
			$message = "your phone verification code is: ".$uniqueToken;
			$twillio 	= Yii::$app->twillio;
			$message 	= $twillio->getClient()->account->messages->sendMessage(
				'+14086281587',  // From a valid Twilio number
				'+918288034710', // Text this number
				$message
			);
			if(isset($message->sid) && $message->sid != '') {
				$query	 = new Query;
				$query->createCommand()->insert('userverification', ['user_id' => $userId,'token' => $uniqueToken,'type' => 'PHONE','status' => '0', 'dateCreated' => date(DATETIME_FORMAT)])->execute();
				echo true;
			}
		}
	}

    /**
     * @ Function Name		: actionVerifyPhoneNumber
     * @ Function Params	: 
     * @ Function Purpose 	: verify phone number
     * @ Function Returns	: render view
     */
	public function actionVerifyPhoneNumber() {
		$data 	 = array();
		$query	 = new Query;
		$userId  = Yii::$app->user->getId();
		$postArr = Yii::$app->request->post();

        if(isset($postArr['verificationCode']) && !empty($postArr['verificationCode'])) {
			 $query->select('COUNT(id) as cnt')->from('userverification')->where('token = "'.$postArr['verificationCode'].'" AND user_id = '.$userId.' AND type = "PHONE"');
			 $validCount = $query->createCommand()->queryOne();
			 if(isset($validCount['cnt']) && $validCount['cnt'] > 0) {		
				 Yii::$app->db->createCommand()->update('userverification', ['status' => '1'], 'token = "'.$postArr['verificationCode'].'" AND user_id = '.$userId)->execute();
				 Yii::$app->session->setFlash('item', Yii::t('yii','Thank you, your phone number has been verified.'));
				 return $this->redirect( Url::to(['member/index']) );
			 } else {
				Yii::$app->session->setFlash('item', Yii::t('yii','Your verification code is incorrect.'));
			 }
			 unset($postArr['verificationCode']);
		 } else {
			Yii::$app->session->setFlash('item', Yii::t('yii','Please enter your verification code'));
		 }
		return $this->render('verifyphonenumber');
	}

    /**
     * @ Function Name		: guydeServices
     * @ Function Params	: 
     * @ Function Purpose 	: guyde services
     * @ Function Returns	: return
     */
     public function guydeServices($userpost,$userId=0) {
		 
		 if($userId == 0) { 
			 $userId  = Yii::$app->user->getId();
		 }
		
		$conName		=	(isset($userpost['usrCountry']) ?  $userpost['usrCountry'] : '');
		$conShortName	=	(isset($userpost['country_sortname']) ? $userpost['country_sortname'] : '');
		$state[]		=   (isset($userpost['usrState']) ? $userpost['usrState'] : '');
		$city[]			=   (isset($userpost['usrCity']) ?  $userpost['usrCity'] : '');

		$query	 = new Query;
		$query->select('COUNT(id) as cnt')->from('guyde_services')->where('user_id = '.$userId);
		$validCount = $query->createCommand()->queryOne();

		if(isset($validCount['cnt']) && $validCount['cnt'] == 0) {
			$query->createCommand()->insert('guyde_services', ['user_id' => $userId,'country' => $conName,'states' => json_encode($state),'cities' => json_encode($city), 'country_sortname' => $conShortName])->execute();
		} else {
			Yii::$app->db->createCommand()->update('guyde_services', ['country' => $conName,'states' => json_encode($state),'cities' => json_encode($city), 'country_sortname' => $conShortName], 'user_id = '.$userId)->execute();	
		}
		###############################################
	 }

    /**
     * @ Function Name		: guide_availability
     * @ Function Params	: 
     * @ Function Purpose 	: update guide_availability
     * @ Function Returns	: return
     */
     public function guide_availability($userpost,$userId=0) {

		 if($userId == 0) { 
			 $userId  = Yii::$app->user->getId();
		 }

		$avail_dates	=	(isset($userpost['usrAvailability']) ? str_replace(" ", "",$userpost['usrAvailability']) : '');
		//$avail_time		=	(isset($userpost['usrAvailableTime']) ? $userpost['usrAvailableTime'] : '');
		$avail_time		=	"ANY";
		
		$query	 = new Query;
		$query->select('COUNT(id) as cnt')->from('user_availability')->where('user_id = '.$userId);
		$validCount = $query->createCommand()->queryOne();

		if(isset($validCount['cnt']) && $validCount['cnt'] == 0) {
			$query->createCommand()->insert('user_availability', ['user_id' => $userId,'available_dates' => $avail_dates,'available_time' => $avail_time])->execute();
		} else {
			Yii::$app->db->createCommand()->update('user_availability', ['available_dates' => $avail_dates, 'available_time' => $avail_time], 'user_id = '.$userId)->execute();	
		}
		###############################################
	 }

    /**
     * @ Function Name		: actionCancelBooking
     * @ Function Params	: postArr {Array}
     * @ Function Purpose 	: cancel booking from guide profile
     * @ Function Returns	: redirect
     */
    public function actionCancelBooking() {
        $postArr = Yii::$app->request->post();
        $userId  = Yii::$app->user->getId();
        if(isset($postArr['canBookingID']) && !empty($postArr['canBookingID'])) {
			$query	 = new Query;
			Yii::$app->db->createCommand()->update('booking', ['booking_status' => 3,'cancelled_by' =>'2'], 'booking_id = ' . $postArr['canBookingID'])->execute();
			$this->cancelBookingNotifications($postArr['canBookingID'],$userId);
			Yii::$app->session->setFlash('item', Yii::t('yii', 'Booking has been cancelled.'));
		}
        $this->redirect(['member/bookinghistory']);
    }

    /**
     * @ Function Name		: cancelBookingNotifications
     * @ Function Params	: $booking_id
     * @ Function Purpose 	: cancel booking email notification
     * @ Function Returns	: 
     */
    public function cancelBookingNotifications($booking_id,$userId) {
		$query  = new Query;
		$query->select('booking.*,g_us.usrFirstname as g_fn,g_us.usrLastname as g_ln,g_us.email g_email,c_us.usrFirstname as c_fn,c_us.usrLastname as c_ln,c_us.email as c_email,cc.currency_sign')
		->from('booking')
		->join('LEFT JOIN', 'user g_us', 'g_us.id = booking.guyde_user_id')
		->join('LEFT JOIN', 'user c_us', 'c_us.id = booking.customer_user_id')
		->join('LEFT JOIN', 'payment_transaction pt', 'pt.booking_id = booking.booking_id')
		->join('LEFT JOIN', 'currencies cc', 'cc.currency_name = pt.currency')
		->where("booking.booking_status = '3' AND booking.booking_id  = ".$booking_id);
		$userInfo	= $query->createCommand()->queryOne();

		if(isset($userInfo) && !empty($userInfo)) {
			$this->cancelBookingMessage($userInfo);
			$this->cancelBookingEmailToCustomer($userInfo);
			$this->cancelBookingEmailToMember($userInfo);
		}
    }

    /**
     * @ Function Name		: cancelBookingMessage
     * @ Function Params	: booking details {array}
     * @ Function Purpose 	: send booking request message
     * @ Function Returns	: return
     */
    public function cancelBookingMessage($booking_details = 0) {
        $userId = Yii::$app->user->getId();
        $message="The booking has been cancelled by Insider.";
        $thread_id = $this->checkTHreadID($booking_details['customer_user_id'],$booking_details['guyde_user_id']);
        
        if($userId == $booking_details['guyde_user_id']) {
			$from 	= $booking_details['guyde_user_id'];
			$to 	= $booking_details['customer_user_id'];
		} else {
			$to 	= $booking_details['guyde_user_id'];
			$from 	= $booking_details['customer_user_id'];			
		}
        
        Yii::$app->db->createCommand()
            ->insert('messages', ['user_from' => $from,'user_to' => $to,'message' => $message,'booking_id' => $booking_details['booking_id'],'status' => '1','booking_request' => '1', 'thread_id' => $thread_id])->execute();
    }
 
     public function checkTHreadID($userfrom,$userto) {
			$query = new Query;
			$query->select('COUNT(message_id) as cnt')
					->from('messages')
					->where('user_from = '.$userfrom.' AND user_to = '.$userto.' || user_from = '.$userto.' AND user_to = '.$userfrom);
			$msg_cnt = $query->createCommand()->queryOne();
			$threadID	=	0;
			if(isset($msg_cnt['cnt']) && $msg_cnt['cnt'] >= 1) {
				if($msg_cnt['cnt'] == 1) {
					$query->select('message_id')
							->from('messages')
							->where('user_from = '.$userfrom.' AND user_to = '.$userto.' || user_from = '.$userto.' AND user_to = '.$userfrom);
					$response = $query->createCommand()->queryOne();
					$threadID = $response['message_id'];
				} else {
					$query->select('thread_id')
							->from('messages')
							->where('user_from = '.$userfrom.' AND user_to = '.$userto.' || user_from = '.$userto.' AND user_to = '.$userfrom.' AND thread_id != 0')->orderBy('message_id DESC');
					$response = $query->createCommand()->queryOne();

					if(isset($response['thread_id']) && $response['thread_id'] > 0) {
						$threadID = $response['thread_id'];
					} else {
						$query->select('message_id')
								->from('messages')
								->where('user_from = '.$userfrom.' AND user_to = '.$userto.' || user_from = '.$userto.' AND user_to = '.$userfrom)->orderBy('message_id ASC');
						$response = $query->createCommand()->queryOne();					
						$threadID = (isset($response['message_id']) ? $response['message_id'] : 0);						
					}									
				}
			}
			return $threadID;
	}
    
    /**
     * @ Function Name		: cancelBookingEmailToCustomer
     * @ Function Params	: $userInfo
     * @ Function Purpose 	: cancel booking email notification to customer
     * @ Function Returns	: 
     */    
    public function cancelBookingEmailToCustomer($userInfo) {
		$fromEmail = $this->getAdminEmailID();
		
		$bookingDate = $userInfo['booked_from_date'];
		$datediff = strtotime($userInfo['booked_to_date']) - strtotime($userInfo['booked_from_date']); 
		if($datediff > 0)
			$bookingDate .= ' - '.$userInfo['booked_to_date'];		

		$booking	=	array();
		
		#############################= Send User Registration Email =##########################
		$alias='CANCELBOOKING01';
		$emailContent = $this->getEmailContent($alias);
		if(isset($emailContent) && !empty($emailContent)) {
			$clink = '<a href="'.SITE_URL.'" target="_blank">here</a>';
			$msg = '';
			$msg .=  $emailContent['message'];
			$time =  date('d M, Y - h:m A');
			$logo = '<a href=""><img src = "' . SITE_LOGO . '" /></a>';

			$subject  	="Booking has been cancelled.";
			$message  	='';

			$message .='<tr>
						<td align="left"><table width="600" border="0" bgcolor="#2c1f14" cellspacing="1" cellpadding="6" style=" color:#585858;">
							<tr  bgcolor="#333333">
							  <td colspan="2" style="border-top:#333333 solid 0px; font-size:14px; font-weight:400; color:#ffffff; text-transform:capitalize;   padding:8px;">Booking Detail</td>
							</tr>
							<tr  bgcolor="#ffffff">
							  <td width="100" >Booking Location</td>
							  <td width="270" >'.@$userInfo['booking_destination'].'</td>
							</tr>
							<tr  bgcolor="#ffffff">
							  <td>Booking Date</td>
							  <td >'.@$bookingDate.'</td>
							</tr>';
							
						if(isset($userInfo['no_of_hours']) && $userInfo['no_of_hours'] > 0) {	
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Hours</td>
											<td >'.$userInfo['no_of_hours'].'</td>
										</tr>';
						} else {
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Days</td>
											<td >'. (isset($userInfo['no_of_days']) ? $userInfo['no_of_days'] : '') .'</td>
										</tr>';
						}

						$message .='<tr  bgcolor="#ffffff">
							  <td>Booking Price</td>
							  <td >'.$userInfo['currency_sign'].''.$userInfo['booking_price'].'</td>
							</tr>						
							<tr  bgcolor="#ffffff">
							  <td>Number of Travelers</td>
							  <td >'. (isset($userInfo['no_of_travellers']) ? $userInfo['no_of_travellers'] : 2).'</td>
							</tr>						
						  </table></td>
						</tr>';
						
			$cname = $userInfo['c_fn'].' '.$userInfo['c_ln'];
			$gname = $userInfo['g_fn'].' '.$userInfo['g_ln'];
			$msg = str_replace("<{username}>", $cname,  str_replace("&lt;{username}&gt;", $cname, $msg));
			$msg = str_replace("<{name}>", $gname,  str_replace("&lt;{name}&gt;", $gname, $msg));
			$msg = str_replace("<{link}>", $clink,  str_replace("&lt;{link}&gt;", $clink, $msg));		
			$msg = str_replace("<{logo}>", $logo,  str_replace("&lt;{logo}&gt;", $logo, $msg));
			$msg = str_replace("<{time}>", $time,  str_replace("&lt;{time}&gt;", $time, $msg));
			$msg = str_replace("<{subject}>", $subject,  str_replace("&lt;{subject}&gt;", $subject, $msg));
			$msg = str_replace("<{baseurl}>", SITE_URL,  str_replace("&lt;{baseurl}&gt;", SITE_URL, $msg));
			$msg = str_replace("<{content}>", $message,  str_replace("&lt;{content}&gt;", $message, $msg));
				   
			$mail = Yii::$app->mailer->compose(['html' => 'layouts/mail1'],['content' => $msg, 'subject' => $subject])
			->setFrom($fromEmail)
			->setTo(@$userInfo['c_email'])
			->setSubject($subject)
			->send();
		} else {
			$subject  	="Booking has been cancelled.";
			$message  	='';
			
			$message .='<tr>';
				$message .='<td height="26" style="font-size:15px; font-weight:500; color:#333333;">Dear '.@$userInfo['c_fn'].' '.@$userInfo['c_ln'].',</td>';
			$message .='</tr>';
			$message .='<tr>';
				$message .='<td style="font-size:13px; color:#585858; line-height:18px; padding-bottom:10px;">Your booking has been cancelled by '.@$userInfo['g_fn'].' '.@$userInfo['g_ln'].'. Payment will be credited to your account within 2-3 days. Please click <a href="'.SITE_URL.'" target="_blank">here</a> to access your account.</td>';
			$message .='</tr>';
			$message .='<tr>';
				$message .='<td height="15"></td>';
			$message .='</tr>';
			$message .='<tr>
						<td align="left"><table width="600" border="0" bgcolor="#2c1f14" cellspacing="1" cellpadding="6" style=" color:#585858;">
							<tr  bgcolor="#333333">
							  <td colspan="2" style="border-top:#333333 solid 0px; font-size:14px; font-weight:400; color:#ffffff; text-transform:capitalize;   padding:8px;">Booking Detail</td>
							</tr>
							<tr  bgcolor="#ffffff">
							  <td width="100" >Booking Location</td>
							  <td width="270" >'.@$userInfo['booking_destination'].'</td>
							</tr>
							<tr  bgcolor="#ffffff">
							  <td>Booking Date</td>
							  <td >'.@$bookingDate.'</td>
							</tr>';
							
						if(isset($userInfo['no_of_hours']) && $userInfo['no_of_hours'] > 0) {	
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Hours</td>
											<td >'.$userInfo['no_of_hours'].'</td>
										</tr>';
						} else {
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Days</td>
											<td >'. (isset($userInfo['no_of_days']) ? $userInfo['no_of_days'] : '') .'</td>
										</tr>';
						}

						$message .='<tr  bgcolor="#ffffff">
							  <td>Booking Price</td>
							  <td >'.$userInfo['currency_sign'].''.$userInfo['booking_price'].'</td>
							</tr>						
							<tr  bgcolor="#ffffff">
							  <td>Number of Travelers</td>
							  <td >'. (isset($userInfo['no_of_travellers']) ? $userInfo['no_of_travellers'] : 2).'</td>
							</tr>						
						  </table></td>
						</tr>';					

			$mail = Yii::$app->mailer->compose(['html' => 'layouts/mail'],['content' => $message, 'subject' => $subject])
			->setFrom($fromEmail)
			->setTo(@$userInfo['c_email'])
			->setSubject($subject)
			->send();
		}
	}
	
    /**
     * @ Function Name		: cancelBookingEmailToMember
     * @ Function Params	: $userInfo
     * @ Function Purpose 	: cancel booking email notification to member
     * @ Function Returns	: 
     */    
    public function cancelBookingEmailToMember($userInfo) {

		$bookingPrice = $userInfo['booking_price'] - ($userInfo['admin_fee']+$userInfo['service_fee']);
		$bookingDate = $userInfo['booked_from_date'];
		$datediff = strtotime($userInfo['booked_to_date']) - strtotime($userInfo['booked_from_date']); 
		if($datediff > 0)
			$bookingDate .= ' - '.$userInfo['booked_to_date'];
		
		$fromEmail = $this->getAdminEmailID();
		$booking	=	array();

		$alias='CANCELBOOKING02';
		$emailContent = $this->getEmailContent($alias);
		if(isset($emailContent) && !empty($emailContent)) {
			$clink = '<a href="'.SITE_URL.'" target="_blank">here</a>';
			$msg = '';
			$msg .=  $emailContent['message'];
			$time =  date('d M, Y - h:m A');
			$logo = '<a href=""><img src = "' . SITE_LOGO . '" /></a>';

			$subject  	="Booking has been cancelled.";
			$message  	='';

			$message .='<tr>
						<td align="left"><table width="600" border="0" bgcolor="#2c1f14" cellspacing="1" cellpadding="6" style=" color:#585858;">
							<tr  bgcolor="#333333">
							  <td colspan="2" style="border-top:#333333 solid 0px; font-size:14px; font-weight:400; color:#ffffff; text-transform:capitalize;   padding:8px;">Booking Detail</td>
							</tr>
							<tr  bgcolor="#ffffff">
							  <td width="100" >Booking Location</td>
							  <td width="270" >'.@$userInfo['booking_destination'].'</td>
							</tr>
							<tr  bgcolor="#ffffff">
							  <td>Booking Date</td>
							  <td >'.@$bookingDate.'</td>
							</tr>';

						if(isset($userInfo['no_of_hours']) && $userInfo['no_of_hours'] > 0) {	
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Hours</td>
											<td >'.$userInfo['no_of_hours'].'</td>
										</tr>';
						} else {
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Days</td>
											<td >'. (isset($userInfo['no_of_days']) ? $userInfo['no_of_days'] : '') .'</td>
										</tr>';
						}

						$message .='<tr  bgcolor="#ffffff">
							  <td>Booking Price</td>
							  <td >'.$userInfo['currency_sign'].''.$bookingPrice.'</td>
							</tr>						
							<tr  bgcolor="#ffffff">
							  <td>Number of Travelers</td>
							  <td >'. (isset($userInfo['no_of_travellers']) ? $userInfo['no_of_travellers'] : 2).'</td>
							</tr>						
						  </table></td>
						</tr>';
						
			$cname = $userInfo['g_fn'].' '.$userInfo['g_ln'];
			$gname = $userInfo['c_fn'].' '.$userInfo['c_ln'];
			$msg = str_replace("<{username}>", $cname,  str_replace("&lt;{username}&gt;", $cname, $msg));
			$msg = str_replace("<{name}>", $gname,  str_replace("&lt;{name}&gt;", $gname, $msg));
			$msg = str_replace("<{link}>", $clink,  str_replace("&lt;{link}&gt;", $clink, $msg));		
			$msg = str_replace("<{logo}>", $logo,  str_replace("&lt;{logo}&gt;", $logo, $msg));
			$msg = str_replace("<{time}>", $time,  str_replace("&lt;{time}&gt;", $time, $msg));
			$msg = str_replace("<{subject}>", $subject,  str_replace("&lt;{subject}&gt;", $subject, $msg));
			$msg = str_replace("<{baseurl}>", SITE_URL,  str_replace("&lt;{baseurl}&gt;", SITE_URL, $msg));
			$msg = str_replace("<{content}>", $message,  str_replace("&lt;{content}&gt;", $message, $msg));
				   
			$mail = Yii::$app->mailer->compose(['html' => 'layouts/mail1'],['content' => $msg, 'subject' => $subject])
			->setFrom($fromEmail)
			->setTo(@$userInfo['g_email'])
			->setSubject($subject)
			->send();
		} else {		
			$subject  	="Booking has been cancelled.";
			$message  	='';
			
			$message .='<tr>';
				$message .='<td height="26" style="font-size:15px; font-weight:500; color:#333333;">Dear '.@$userInfo['g_fn'].' '.@$userInfo['g_ln'].',</td>';
			$message .='</tr>';
			$message .='<tr>';
				$message .='<td style="font-size:13px; color:#585858; line-height:18px; padding-bottom:10px;">You have been cancelled your booking with '.@$userInfo['c_fn'].' '.@$userInfo['c_ln'].'. Please click <a href="'.SITE_URL.'" target="_blank">here</a> to access your account.</td>';
			$message .='</tr>';
			$message .='<tr>';
				$message .='<td height="15"></td>';
			$message .='</tr>';
			$message .='<tr>
						<td align="left"><table width="600" border="0" bgcolor="#2c1f14" cellspacing="1" cellpadding="6" style=" color:#585858;">
							<tr  bgcolor="#333333">
							  <td colspan="2" style="border-top:#333333 solid 0px; font-size:14px; font-weight:400; color:#ffffff; text-transform:capitalize;   padding:8px;">Booking Detail</td>
							</tr>
							<tr  bgcolor="#ffffff">
							  <td width="100" >Booking Location</td>
							  <td width="270" >'.@$userInfo['booking_destination'].'</td>
							</tr>
							<tr  bgcolor="#ffffff">
							  <td>Booking Date</td>
							  <td >'.@$bookingDate.'</td>
							</tr>';

						if(isset($userInfo['no_of_hours']) && $userInfo['no_of_hours'] > 0) {	
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Hours</td>
											<td >'.$userInfo['no_of_hours'].'</td>
										</tr>';
						} else {
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Days</td>
											<td >'. (isset($userInfo['no_of_days']) ? $userInfo['no_of_days'] : '') .'</td>
										</tr>';
						}

						$message .='<tr  bgcolor="#ffffff">
							  <td>Booking Price</td>
							  <td >'.$userInfo['currency_sign'].''.$bookingPrice.'</td>
							</tr>						
							<tr  bgcolor="#ffffff">
							  <td>Number of Travelers</td>
							  <td >'. (isset($userInfo['no_of_travellers']) ? $userInfo['no_of_travellers'] : 2).'</td>
							</tr>						
						  </table></td>
						</tr>';
						
			$mail = Yii::$app->mailer->compose(['html' => 'layouts/mail'],['content' => $message, 'subject' => $subject])
			->setFrom($fromEmail)
			->setTo(@$userInfo['g_email'])
			->setSubject($subject)
			->send();
		}
	}
    
    /**
     * @ Function Name		: getAdminEmailID
     * @ Function Params	: 
     * @ Function Purpose 	: get Admin Email
     * @ Function Returns	: return
     */
	public function getAdminEmailID() {
		$modelLink = new Admin();
		$AdminEmail  = $modelLink->getAdminEmail();
		if(isset($AdminEmail['1']) && !empty($AdminEmail['1'])) {
			$fromEmail = $AdminEmail['1'];
		} else {
			$fromEmail = 'testerdept@gmail.com';
		}
		return $fromEmail;
	}		
	public function getEmailContent($alias='') {
        $query = new Query;
        $query->select('message')
                ->from('newsletter_template')
                ->where("code ='" . $alias . "' AND status ='Y'");
        return  $query->createCommand()->queryOne();		
	}			
}
