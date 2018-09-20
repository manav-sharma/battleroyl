<?php

namespace frontend\controllers;

use Yii;
use frontend\models\users\UpdateUser;
use frontend\models\users\UpdateMember;
use frontend\models\users\Users;
use common\models\Country;
use common\models\State;
use common\models\City;
use common\models\Admin;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\ErrorAction;
use yii\db\Query;

##############= FOR FILE UPLOAD =################
use yii\web\UploadedFile;
use frontend\models\users\ProfilePictureUpload;
use frontend\models\users\UserIdDocumentUpload;

###########PAGINATION###########################
use yii\data\Pagination;

/**
 * Customer controller
 */
class CustomerController extends Controller {

    /**
     * @inheritdoc
     */
    public $enableCsrfValidation = false;
    public $limit = 10;

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
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {

		if(Yii::$app->session->get('afterlogin') !== null) {
			Yii::$app->session->remove('afterlogin');
			return $this->goBack();
		}

		$attributes = Yii::$app->user->identity->getattributes();
		if(isset($attributes['usrType']) && $attributes['usrType'] == MEMBER) {
			return $this->redirect( Url::to(['member/index']) );
		}			
		
        return $this->render('index');
    }
    
    /**
     * Update an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionSettings()
    {
		$attributes = Yii::$app->user->identity->getattributes();
		if(isset($attributes['usrType']) && $attributes['usrType'] == MEMBER) {
			return $this->redirect( Url::to(['member/index']) );
		}		
        #####################= FILEUPLOAD MODEL =####################
        $modelUserProfilePictureUpload = new ProfilePictureUpload();
        $modelUserProfilePictureUpload->scenario = 'update-profile';

        ##################= UPDATE CUSTOMER DETAILS =##################
        $data = array();
        $id = Yii::$app->user->getId();
        $Usersmodel = $this->findModel($id);
        $updateUser = new \frontend\models\users\UpdateUser();
        $model = $updateUser->findIdentity($id);
        $model->scenario = 'update';
        $userpost = Yii::$app->request->post('UpdateUser');

        if (isset($userpost) && !empty($userpost)) {
            $model->usrProfileImage = '';
            ####################= PROFILE IMAGE UPLOAD =###################
            if (Yii::$app->request->isPost) {
                $modelUserProfilePictureUpload->usrProfileImage = UploadedFile::getInstance($modelUserProfilePictureUpload, 'usrProfileImage');
                if ($modelUserProfilePictureUpload->usrProfileImage && $uploadedFileNameArray = $modelUserProfilePictureUpload->upload()) {
                    $model->usrProfileImage = $uploadedFileNameArray['originalImage'];
                    ####= return array('originalImage'=>$fileNameWithExtension); =####
                }
            }
            $userpost['usrProfileImage'] = $model->usrProfileImage;

            if ($model->load(Yii::$app->request->post()) && $model->updateUser($id, $userpost)) {
                Yii::$app->session->setFlash('item', Yii::t('yii', 'Your profile information has been updated successfully.'));
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('item', Yii::t('yii', 'Please enter valid values for all the fields!'));
            }
        } else {
            $model->setAttributes($Usersmodel->getAttributes());
        }

        $model->setAttributes($Usersmodel->getAttributes());
        return $this->render('settings', [
                    'model' => $model,
                    'modelProfilePictureUpload' => $modelUserProfilePictureUpload,
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
     * Displays Paymenthistory.
     *
     * @return int
     */    
    public function actionPaymenthistory() {
		 $userId = Yii::$app->user->getId();
         $dataArray = array();
         $query = new Query;
         $query->select('booking.*,guyde.usrFirstname as guydeFN,guyde.usrLastname as guydeLN,customer.usrFirstname as customerFN,customer.usrLastname as customerLN')
         ->from('booking')
         ->join('LEFT JOIN', 'user guyde', 'guyde.id = booking.guyde_user_id')
         ->join('LEFT JOIN', 'user customer', 'customer.id = booking.customer_user_id')
         ->where("booking.customer_user_id = $userId");
         $countQuery = clone $query;
         $pages = new Pagination(['totalCount' => $countQuery->count()]);
         $pages->setPageSize($this->limit);
		 $query->offset($pages->offset)
				->orderBy("booking.booking_id DESC")
				->limit($this->limit);    
         $bookingResult = $query->createCommand()->queryAll();
         $dataArray = array_merge($dataArray, [
              'bookingResult' => $bookingResult,
              'pages' => $pages,
         ]);
		 return $this->render('paymenthistory',$dataArray);
	}
     /**
     * Displays findModel.
     *
     * @return int
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
     * Displays states.
     *
     * @return mixed
     */
    public function actionStates() {
		$countryID = Yii::$app->request->post('id');
		$states = State ::find()->where(['country_id' => $countryID])->asArray()->all();
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $states;
    }

    /**
    * Displays states.
    *
    * @return mixed
    */
    public function actionUpdatecities() {
		$stateID = Yii::$app->request->post('id');
		$cities = City ::find()->where(['state_id' => $stateID])->asArray()->all();
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $cities;
    }
    
    public function actionGuideProfile($id) {
        
        $guideDetails = Users::findOne($id);
        
        
        ########################REVIEW PAGINATION STARTS#########################################################
        // build a DB query to get all articles with status = 1
        $query = \backend\models\feedback\feedback::find()
                ->where(['receiver_userid' => $id]);

        // get the total number of articles (but do not fetch the article data yet)
        $count = $query->count();
       
        // create a pagination object with the total count
        $reviewsPagination = new Pagination(['totalCount' => $count]);

        // limit the query using the pagination and retrieve the articles
        $reviews = $query->offset($reviewsPagination->offset)
            ->limit($reviewsPagination->limit)
            ->all();
        #####################################REVIEW PAGINATION ENDS###############################################
        
        
        
        return $this->render('guide-profile', [
            'guideDetails' => $guideDetails,
            'reviews' => $reviews,
            'reviewsPagination' => $reviewsPagination
        ]);
    }
    
	
	/**
	 * @ Function Name		: actionBecomeguide
	 * @ Function Params	: 
	 * @ Function Purpose 	: become a member
	 * @ Function Returns	: render view
	 */  
    public function actionBecomeguide() {
		$attributes = Yii::$app->user->identity->getattributes();
		if(isset($attributes['usrType']) && $attributes['usrType'] == MEMBER) {
			return $this->redirect( Url::to(['member/index']) );
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
				###############################				 
				if(!empty($userpost['usrIdDocument'])) { $this->_uploadIDDocumentNotification($userpost); }
				Yii::$app->session->setFlash('item', Yii::t('yii','Your profile information has been updated successfully.'));
				return $this->redirect(['member/index']);				
			} else {
				$model->usrLanguage = '';
				$model->usrInterests = '';				
				Yii::$app->session->setFlash('item', Yii::t('yii','Please enter valid values for all the fields.'));
			}
		} else {
			$model->setAttributes($memberModel->getAttributes());
		}
		$model->setAttributes($memberModel->getAttributes());
        return $this->render('becomeguide', [
           'model' => $model,
           'modelProfilePictureUpload' => $modelUserProfilePictureUpload,
           'modelUserIdDocumentUpload' => $modelUserIdDocumentUpload
        ]);		
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
		##############= country, state, city =################
		
		$conName		=	(isset($userpost['usrCountry']) ? $userpost['usrCountry'] : '');
		$conShortName	=	(isset($userpost['sortname']) ? $userpost['sortname'] : '');
		$state[]		=   (isset($userpost['usrState']) ? $userpost['usrState'] : '');
		$city[]			=   (isset($userpost['usrCity']) ? $userpost['usrCity'] : '');

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
			Yii::$app->db->createCommand()->update('booking', ['booking_status' => 3,'cancelled_by' =>'1'], 'booking_id = ' . $postArr['canBookingID'] . ' AND customer_user_id = ' . $userId)->execute();
			$this->cancelBookingNotifications($postArr['canBookingID'],$userId);
			Yii::$app->session->setFlash('item', Yii::t('yii', 'Booking has been cancelled.'));
		}
        $this->redirect(['customer/paymenthistory']);
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
        $message="The booking has been cancelled by Customer.";
        $thread_id = $this->checkTHreadID($booking_details['customer_user_id'],$booking_details['guyde_user_id']);
        Yii::$app->db->createCommand()
            ->insert('messages', ['user_from' => $booking_details['customer_user_id'],'user_to' => $booking_details['guyde_user_id'],'message' => $message,'booking_id' => $booking_details['booking_id'],'status' => '1','booking_request' => '1', 'thread_id' => $thread_id])->execute();
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
		$alias='CANCELBOOKING03';
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
				$message .='<td style="font-size:13px; color:#585858; line-height:18px; padding-bottom:10px;">You have been cancelled your booking with '.@$userInfo['g_fn'].' '.@$userInfo['g_ln'].'. Please click <a href="'.SITE_URL.'" target="_blank">here</a> to access your account.</td>';
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
		$alias='CANCELBOOKING04';
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
				$message .='<td style="font-size:13px; color:#585858; line-height:18px; padding-bottom:10px;">Your booking has been cancelled by '.@$userInfo['c_fn'].' '.@$userInfo['c_ln'].'. Please click <a href="'.SITE_URL.'" target="_blank">here</a> to access your account.</td>';
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
			$fromEmail = Yii::$app->params['adminEmail'];
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
