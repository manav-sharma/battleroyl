<?php
namespace frontend\controllers; 

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\helpers\Url;
use frontend\models\FeedbackRating;
use common\models\Admin;
use yii\db\Query;
class FeedbackController extends Controller {

    private $limit = 10;

	public function beforeAction($action) { 
		return true;
	}
	
	 /**
     * @ Function Name		: actionPostFeedback
     * @ Function Params	: @id- booking id
     * @ Function Purpose 	: function to post rating/feedback against a booking.
     * @ Function Returns	: render view 
     */
	public function actionPostFeedback($id){
		$loggedUser = Yii::$app->user->identity->attributes; 
		
		$bookingModel = \frontend\models\Booking::findOne(['booking_id' => $id]); 
        if ($bookingModel === null)
            return $this->redirect([strtolower($loggedUser['usrType']).'/index']);
         
        $loggedUserId = Yii::$app->user->getId(); 
         
        $feedbackModel = FeedbackRating::findOne(['sender_userid' => $loggedUserId, 'booking_id' => $id]);
        if ($feedbackModel === null)
           $feedbackModel = new FeedbackRating();
           
        if($feedbackModel->load(Yii::$app->request->post()) && $feedbackModel->validate()) {
			    
			$feedbackModel->sender_userid = $loggedUserId;
			$feedbackModel->receiver_userid = $bookingModel->guyde_user_id;
			$feedbackModel->status = '1';
			$feedbackModel->booking_id = $id;
			
			if($feedbackModel->save()) {
				$this->_sendFeedbackNotification($feedbackModel,$loggedUser);
			}
			if($loggedUser['usrType'] == 'Customer')
				return $this->redirect(['customer/paymenthistory']);
			elseif($loggedUser['usrType'] == 'Member')
				return $this->redirect(['member/bookinghistory']);
				
		}
          
        return $this->render('post-feedback', [
            'model' => $feedbackModel
        ]);
            
	}
	
    private function _sendFeedbackNotification( $feedbackinfo='' , $senderuser='' ) {
		$alias = 'FEEDBACKNOTIFICATION01';
		$recieveruser = \frontend\models\users\Users::findOne($feedbackinfo->receiver_userid);
		$fromEmail = $this->getAdminEmailID();
		$emailContent = $this->getEmailContent($alias);
		if(isset($emailContent) && !empty($emailContent)) {
			$clink = '<a href="'.SITE_URL.'" target="_blank">here</a>';
			$msg = '';
			$msg .=  $emailContent['message'];
			$time =  date('d M, Y - h:m A');
			$logo = '<a href=""><img src = "' . SITE_LOGO . '" /></a>';
			$senderName = $senderuser['usrFirstname'].' '.$senderuser['usrLastname'];

			$subject  ="Customer feedback";
			$message  ='';
			$message .='<tr>';
				$message .='<td align="left">';
					$message .='<table width="500" border="0" bgcolor="#2c1f14" cellspacing="1" cellpadding="6" style=" color:#585858;">';
						$message .='<tr  bgcolor="#333333">';
							$message .='<td colspan="2" style="border-top:#333333 solid 0px; font-size:14px; font-weight:400; color:#ffffff; text-transform:capitalize;   padding:8px;">Ratings details</td>';
						$message .='</tr>';
						$message .='<tr  bgcolor="#ffffff">';
							$message .='<td width="100" >Sender Name</td>';
							$message .='<td width="270" >' . @$senderName . '</td>';
						$message .='</tr>';
						$message .='<tr  bgcolor="#ffffff">';
							$message .='<td>Comment</td>';
							$message .='<td >' . @$feedbackinfo->comment . '</td>';
						$message .='</tr>';
						$message .='<tr  bgcolor="#ffffff">';
							$message .='<td>Rating Stars</td>';
							$message .='<td >' . @$feedbackinfo->starrating . '</td>';
						$message .='</tr>';
					$message .='</table>';
				$message .='</td>';
			$message .='</tr>';
			$message .='<tr>';
				$message .='<td height="15"></td>';
			$message .='</tr>';

			$msg = str_replace("<{username}>", $recieveruser->usrFirstname,  str_replace("&lt;{username}&gt;", $recieveruser->usrFirstname, $msg));		
			$msg = str_replace("<{link}>", $clink,  str_replace("&lt;{link}&gt;", $clink, $msg));
			$msg = str_replace("<{logo}>", $logo,  str_replace("&lt;{logo}&gt;", $logo, $msg));
			$msg = str_replace("<{time}>", $time,  str_replace("&lt;{time}&gt;", $time, $msg));
			$msg = str_replace("<{subject}>", $subject,  str_replace("&lt;{subject}&gt;", $subject, $msg));
			$msg = str_replace("<{baseurl}>", SITE_URL,  str_replace("&lt;{baseurl}&gt;", SITE_URL, $msg));
			$msg = str_replace("<{content}>", $message,  str_replace("&lt;{content}&gt;", $message, $msg));
			$mail = Yii::$app->mailer->compose(['html' => 'layouts/mail1'],['content' => $msg, 'subject' => $subject])
			->setFrom($fromEmail)
			->setTo($recieveruser->email)
			->setSubject($subject)
			->send(); 	
			return $mail;
		} else {
			$subject  ="Customer feedback";
			$message  ='';
			$message .='<tr>';
				$message .='<td height="26" style="font-size:15px; font-weight:500; color:#333333;">Dear ' . @$postArr['usrFirstname'] . ',</td>';
			$message .='</tr>';
			$message .='<tr>';
				$message .='<td style="font-size:13px; color:#585858; line-height:18px; padding-bottom:10px;">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content here, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for lorem ipsum will uncover many web sites still in their infancy. Please click <a target="_blank" href="'.$link.'">here</a> to verify your email address. Below are login details:</td>';
			$message .='</tr>';
			$message .='<tr>';
				$message .='<td height="5"></td>';
			$message .='</tr>';
			$message .='<tr>';
				$message .='<td align="left">';
					$message .='<table width="500" border="0" bgcolor="#2c1f14" cellspacing="1" cellpadding="6" style=" color:#585858;">';
						$message .='<tr  bgcolor="#333333">';
							$message .='<td colspan="2" style="border-top:#333333 solid 0px; font-size:14px; font-weight:400; color:#ffffff; text-transform:capitalize;   padding:8px;">Login details</td>';
						$message .='</tr>';
						$message .='<tr  bgcolor="#ffffff">';
							$message .='<td width="100" >Name</td>';
							$message .='<td width="270" >' . @$postArr['cname'] . '</td>';
						$message .='</tr>';
						$message .='<tr  bgcolor="#ffffff">';
							$message .='<td>Comment</td>';
							$message .='<td >' . @$postArr->comment . '</td>';
						$message .='</tr>';
						$message .='<tr  bgcolor="#ffffff">';
							$message .='<td>Rating</td>';
							$message .='<td >' . @$postArr->starrating . '</td>';
						$message .='</tr>';						
					$message .='</table>';
				$message .='</td>';
			$message .='</tr>';
			$message .='<tr>';
				$message .='<td height="15"></td>';
			$message .='</tr>';
			
			$mail = Yii::$app->mailer->compose(['html' => 'layouts/mail'],['content' => $message, 'subject' => $subject])
			->setFrom($fromEmail)
			->setTo($postArr['email'])
			->setSubject($subject)
			->send();
			return $mail;
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
