<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\helpers\Url;

use common\models\PaymentForm;
use frontend\models\PaymentTransaction;
use frontend\models\users\Users;
use yii\db\Query;

class PaymentController extends Controller {

 	 /**
     * @ Function Name		: actionExpresscheckout
     * @ Function Params	: $action{object} 
     * @ Function Purpose 	: The function will payment process
     * @ Function Returns	: boolean true/false
     */   
    public function actionExpresscheckout() {

        $loggeduser = Yii::$app->user->identity->attributes;
		$booking_details = Yii::$app->session->get('booking_details');
        $price = $booking_details['booking_price'];
        $currency_sign = (isset($booking_details['currency_sign']) ? $booking_details['currency_sign'] : '$');
        $currency_name =  (isset($booking_details['currency_name']) ? $booking_details['currency_name'] : 'USD');
        if ($price === null)
            return $this->goHome();

        Yii::$app->session->set('orderPrice', $price);
        $paymentInfo['Order']['theTotal'] = $price;
        $paymentInfo['Order']['currency_name'] = $currency_name;
        $paymentInfo['Order']['description'] = "Booking Payment of ".$currency_sign.''. $price;
        $paymentInfo['Order']['quantity'] = '1';
        
        $paymentInfo['Authorization'] = false;
		$paymentInfo['RecurringPayment'] = false;

        $result = Yii::$app->Paypal->SetExpressCheckout($paymentInfo);

        if (!Yii::$app->Paypal->isCallSucceeded($result)) {
            if (Yii::$app->Paypal->apiLive === true) {
                //Live mode basic error message
                $error = Yii::t('yii','We were unable to process your request. Please try again later');
            } else {
                //Sandbox output the actual error message to dive in.
                $error = isset($result['L_LONGMESSAGE0'])?$result['L_LONGMESSAGE0']:Yii::t('yii','We were unable to process your request. Please try again later');
            }

            Yii::$app->session->setFlash('item', $error);
       
            return $this->redirect(["booking/book-member/" . $booking_details['guyde_user_id']]);
        }else {
            $token = urldecode($result["TOKEN"]);

            $payPalURL = Yii::$app->Paypal->paypalUrl . $token;
            $this->redirect($payPalURL);
        }
    }

 	 /**
     * @ Function Name		: actionConfirm
     * @ Function Params	: $action{object} 
     * @ Function Purpose 	: confirm payment process
     * @ Function Returns	: boolean true/false
     */ 
    public function actionConfirm($params = array()) {
        $booking_details = Yii::$app->session->get('booking_details');
		$loggeduser = Yii::$app->user->identity->attributes;
        $params = Yii::$app->request->queryParams;

        if (empty($params))
           return $this->redirect(["booking/book-member/" . $booking_details['guyde_user_id']]);

        $token = trim($params['token']);
        $payerId = trim($params['PayerID']);

        $result = Yii::$app->Paypal->GetExpressCheckoutDetails($token);

		$result['PAYERID'] = $payerId;
        $result['TOKEN'] = $token;
        $result['ORDERTOTAL'] = $booking_details['booking_price'];
        $result['currency_name'] = $booking_details['currency_name'];

        Yii::$app->session->remove('orderPrice');

        //Detect errors 
        if (!Yii::$app->Paypal->isCallSucceeded($result)) {
            if (Yii::$app->Paypal->apiLive === true) {
                //Live mode basic error message
                $error = Yii::t('yii','We were unable to process your request. Please try again later');
            } else {
                //Sandbox output the actual error message to dive in.
                
                $error = isset($result['L_LONGMESSAGE0'])?$result['L_LONGMESSAGE0']:Yii::t('yii','We were unable to process your request. Please try again later');
            }
            Yii::$app->session->setFlash('item', $error);
            return $this->redirect(["booking/book-member/" . $booking_details['guyde_user_id']]);
        } else {
			
			$result['Authorization'] = false;
			
            $paymentResult = Yii::$app->Paypal->DoExpressCheckoutPayment($result);

            //Detect errors  
            if (!Yii::$app->Paypal->isCallSucceeded($paymentResult)) {
                if (Yii::$app->Paypal->apiLive === true) {
                    //Live mode basic error message
                    $error = Yii::t('yii','We were unable to process your request. Please try again later');
                } else {
                    //Sandbox output the actual error message to dive in.
                    $error = isset($paymentResult['L_LONGMESSAGE0'])?$paymentResult['L_LONGMESSAGE0']:Yii::t('yii','We were unable to process your request. Please try again later');
                }

                Yii::$app->session->setFlash('item', Yii::t('yii',$error));
                return $this->redirect(["booking/book-member/" . $booking_details['guyde_user_id']]);
            } else {
                //payment was completed successfully

                $transmodel = new PaymentTransaction();
               
                $transmodel->user_id = Yii::$app->user->getId();
                $transmodel->booking_id = $booking_details['booking_id'];
				$transmodel->amount = $paymentResult['AMT'];
				$transmodel->trans_id = $paymentResult['TRANSACTIONID'];
				$transmodel->payment_type = $paymentResult['PAYMENTTYPE'];
				$transmodel->currency = $booking_details['currency_name'];
				
				$transmodel->payment_status = $paymentResult['PAYMENTSTATUS']; //Completed
				 // Save response date to DB
                $transmodel->save();
				$this->paymentSuccessEmail();
				
                $success_message = Yii::t('yii',"Thank you! You have successfully paid for your booking.");

                Yii::$app->session->setFlash('item', $success_message);
                if($loggeduser['usrType'] == 'Customer')
					return $this->redirect(['customer/paymenthistory']);
				elseif($loggeduser['usrType'] == 'Member')
					return $this->redirect(['member/bookinghistory']);
			
            }
        }
    }

 	 /**
     * @ Function Name		: actionCancel
     * @ Function Params	: 
     * @ Function Purpose 	: cancel payment
     * @ Function Returns	: boolean true/false
     */ 
    public function actionCancel() {
		$booking_details = Yii::$app->session->get('booking_details');
		Yii::$app->session->remove('booking_details');
		
       Yii::$app->session->setFlash('item', Yii::t('yii','You have cancelled the payment.'));
       return $this->redirect(["booking/book-member/" . $booking_details['guyde_user_id']]);
    }

 	 /**
     * @ Function Name		: actionDirectpayment
     * @ Function Params	: 
     * @ Function Purpose 	: direct payment 
     * @ Function Returns	: boolean true/false
     */ 
    public function actionDirectpayment() {

        $loggeduser = Yii::$app->user->identity->attributes;

        $model = new PaymentForm();
        if (!($model->load(Yii::$app->request->post()) && $model->validate())) {
			
			return $this->render('payment-form', [
                        'model' => $model,
            ]);

        } else {
			$booking_details = Yii::$app->session->get('booking_details');
			$price = $booking_details['booking_price'];
			$currency_name = $booking_details['currency_name'];
		
			$fname = isset($model->fname_oncard)?$model->fname_oncard:$loggeduser['usrFirstname'];	
			$lname = isset($model->lname_oncard)?$model->lname_oncard:$loggeduser['usrLastname'];	
				
            $paymentInfo = array('Member' =>
                array(
                    'first_name' => $fname,
                    'last_name' => $lname,
                    'currency_name' => $currency_name,
                    'billing_address' => 'address_here',
                    'billing_address2' => 'address2_here',
                    'billing_country' => 'country_here',
                    'billing_city' => 'city_here',
                    'billing_state' => 'state_here',
                    'billing_zip' => isset($model->billing_zipcode)?$model->billing_zipcode:''	
                ),
                'CreditCard' =>
                array(
                    'credit_type' => $model->cc_type,
                    'card_number' => $model->cc_number,
                    'expiration_month' => $model->exp_month,
                    'expiration_year' => $model->exp_year,
                    'cv_code' => $model->cvv
                ),
                'Order' =>
                array('theTotal' => $price)
            );
			
            /*
             * On Success, $result contains [AMT] [CURRENCYCODE] [AVSCODE] [CVV2MATCH]  
             * [TRANSACTIONID] [TIMESTAMP] [CORRELATIONID] [ACK] [VERSION] [BUILD] 
             *  
             * On Fail, $ result contains [AMT] [CURRENCYCODE] [TIMESTAMP] [CORRELATIONID]  
             * [ACK] [VERSION] [BUILD] [L_ERRORCODE0] [L_SHORTMESSAGE0] [L_LONGMESSAGE0]  
             * [L_SEVERITYCODE0]  
             */
         
            $result = Yii::$app->Paypal->DoDirectPayment($paymentInfo);

            //Detect Errors 
            if (!Yii::$app->Paypal->isCallSucceeded($result)) {
                if (Yii::$app->Paypal->apiLive === true) {
                    //Live mode basic error message
                    $error = Yii::t('yii','We were unable to process your request. Please try again later');
                } else {
                    //Sandbox output the actual error message to dive in.
                    $error = isset($result['L_LONGMESSAGE0'])?$result['L_LONGMESSAGE0']:Yii::t('yii','We were unable to process your request. Please try again later');
                }

                Yii::$app->session->setFlash('error_mesg', $error);
              
				return $this->redirect(["payment/directpayment"]);
            }else {
                //Payment was completed successfully, do your stuff

                $transmodel = new PaymentTransaction();
                
                $transmodel->user_id = $loggeduser['id'];
                $transmodel->booking_id = $booking_details['booking_id'];
                $transmodel->amount = $result['AMT'];
                $transmodel->trans_id = $result['TRANSACTIONID'];
                $transmodel->payment_type = $paymentInfo['CreditCard']['credit_type'];
                $transmodel->payment_status = 'Completed';
                $transmodel->currency = $booking_details['currency_name'];
                // Save response date to DB
                $transmodel->save();
				
				$this->paymentSuccessEmail();
				
                $success_message = Yii::t('yii',"Thank you! You have successfully paid for your booking.");
			
                Yii::$app->session->setFlash('item', $success_message);
				if($loggeduser['usrType'] == 'Customer')
					return $this->redirect(['customer/paymenthistory']);
				elseif($loggeduser['usrType'] == 'Member')
					return $this->redirect(['member/bookinghistory']);
            }
        }
    }

 	 /**
     * @ Function Name		: paymentSuccessEmail
     * @ Function Params	: 
     * @ Function Purpose 	: email template 
     * @ Function Returns	: boolean true/false
     */    
    public function paymentSuccessEmail(){
		$customer = Yii::$app->user->identity->attributes;
		$booking_details = Yii::$app->session->get('booking_details');
		$member = \frontend\models\users\Users::findOne($booking_details['guyde_user_id']);
		$booking = \frontend\models\Booking::findOne($booking_details['booking_id']);
		
		$bookingDate = $booking->booked_from_date;
		$datediff = strtotime($booking->booked_to_date) - strtotime($booking->booked_from_date); 
		if($datediff > 0)
			$bookingDate .= ' - '.$booking->booked_to_date;

		$bookingPrice = $booking->booking_price - ($booking->admin_fee+$booking->service_fee);
		$bookingPrice2 = $booking->booking_price;
		########### booking email ###############
		$this->sendBookingRequsetMessage($booking_details);
		$this->emailToMemberForBookingReq($customer,$member,$booking_details,$bookingDate,$bookingPrice,$booking);
		
		########## payment successful emails ########
		$this->emailToAdmin($customer,$member);
		//$this->emailToMember($customer,$member,$booking_details,$bookingDate);
		$this->emailToCustomer($customer,$member,$booking_details,$bookingDate,$bookingPrice2,$booking);

	}

 	 /**
     * @ Function Name		: emailToAdmin
     * @ Function Params	: 
     * @ Function Purpose 	: email to admin 
     * @ Function Returns	: boolean true/false
     */
    public function emailToAdmin($customer,$member) {
		$fromEmail = Yii::$app->params['supportEmail'];
		$toEmail = 	$this->getAdminEmailID();
		$alias='PAYMENTADMIN01';
		$emailContent = $this->getEmailContent($alias);
		if(isset($emailContent['message']) && !empty($emailContent['message'])) {
			$msg = '';
			$msg .=  $emailContent['message'];
			$time =  date('d M, Y - h:m A');
			$logo = '<a href=""><img src = "' . SITE_LOGO . '" /></a>';

			$subject  ="Payment has been made successfully.";
			$message  ='';
			$message .='<tr>';
				$message .='<td height="15"></td>';
			$message .='</tr>';
			
			$cname = $customer['usrFirstname'].' '.$customer['usrLastname'];
			$gname = $member['usrFirstname'].' '.$member['usrLastname'];
			$msg = str_replace("<{username}>", 'Admin',  str_replace("&lt;{username}&gt;", 'Admin', $msg));	
			$msg = str_replace("<{cname}>", $cname,  str_replace("&lt;{cname}&gt;", $cname, $msg));
			$msg = str_replace("<{gname}>", $gname,  str_replace("&lt;{gname}&gt;", $gname, $msg));
			$msg = str_replace("<{logo}>", $logo,  str_replace("&lt;{logo}&gt;", $logo, $msg));
			$msg = str_replace("<{time}>", $time,  str_replace("&lt;{time}&gt;", $time, $msg));
			$msg = str_replace("<{subject}>", $subject,  str_replace("&lt;{subject}&gt;", $subject, $msg));
			$msg = str_replace("<{baseurl}>", SITE_URL,  str_replace("&lt;{baseurl}&gt;", SITE_URL, $msg));
			$msg = str_replace("<{content}>", $message,  str_replace("&lt;{content}&gt;", $message, $msg));				   
			$mail = Yii::$app->mailer->compose(['html' => 'layouts/mail1'],['content' => $msg, 'subject' => $subject])
			->setFrom($fromEmail)
			->setTo($toEmail)
			->setSubject($subject)
			->send();
			return $mail;
		} else {
			$subject  ="Payment has been made successfully.";
			$message  ='';
			$message .='<tr>';
				$message .='<td height="26" style="font-size:15px; font-weight:500; color:#333333;">Dear Admin,</td>';
			$message .='</tr>';
			$message .='<tr>';
				$message .='<td style="font-size:13px; color:#585858; line-height:18px; padding-bottom:10px;">'.$customer['usrFirstname'].' '.$customer['usrLastname'].' has successfully paid for booking of the member: '.$member['usrFirstname'].' '.$member['usrLastname'].'.</td>';
			$message .='</tr>';
			$message .='<tr>';
				$message .='<td height="15"></td>';
			$message .='</tr>';
			
			$mail = Yii::$app->mailer->compose(['html' => 'layouts/mail'],['content' => $message, 'subject' => $subject])
			->setFrom($fromEmail)
			->setTo($toEmail)
			->setSubject($subject)
			->send();
			return $mail;	
		}
	}

 	 /**
     * @ Function Name		: emailToMember
     * @ Function Params	: 
     * @ Function Purpose 	: email to member 
     * @ Function Returns	: boolean true/false
     */     
    public function emailToMember($customer,$member,$booking_details,$bookingDate) {
		
		$fromEmail = Yii::$app->params['supportEmail'];
		$toEmail 	= $member->email;
		$subject  ="Congratulations! You have been hired.";
		$message  ='';
		$message .='<tr>';
			$message .='<td height="26" style="font-size:15px; font-weight:500; color:#333333;">Dear '.$member->usrFirstname.',</td>';
		$message .='</tr>';
		$message .='<tr>';
			$message .='<td style="font-size:13px; color:#585858; line-height:18px; padding-bottom:10px;"> You have been hired by '.$customer['usrFirstname'].' '.$customer['usrLastname'].'. Please click <a href="'.SITE_URL.'" target="_blank">here</a> to access your account. Details are given below:</td>';
		$message .='</tr>';
		$message .='<tr>';
		$message .='<td height="15"></td>';
		$message .='</tr>  
					<tr><td align="left"><table width="287" border="0" bgcolor="#2c1f14" cellspacing="1" cellpadding="6" style=" color:#585858;">
						<tr  bgcolor="#333333">
						  <td colspan="2" style="border-top:#333333 solid 0px; font-size:14px; font-weight:400; color:#ffffff; text-transform:capitalize;   padding:8px;">Booking Detail</td>
						</tr>
						<tr  bgcolor="#ffffff">
						  <td width="100" >Booking Location</td>
						  <td width="270" >'.$booking_details['booking_destination'].'</td>
						</tr>
						<tr  bgcolor="#ffffff">
						  <td>Booking Date</td>
						  <td >'.$bookingDate.'</td>
						</tr>
					  </table></td>
					</tr>';
		
		$mail = Yii::$app->mailer->compose(['html' => 'layouts/mail'],['content' => $message, 'subject' => $subject])
		->setFrom($fromEmail)
		->setTo($toEmail)
		->setSubject($subject)
		->send();
		return $mail;	
	}
 
  	 /**
     * @ Function Name		: emailToCustomer
     * @ Function Params	: 
     * @ Function Purpose 	: email to customer
     * @ Function Returns	: boolean true/false
     */    
    public function emailToCustomer($customer,$member,$booking_details,$bookingDate,$bookingPrice,$booking) {
		$travellersCnt	   = Yii::$app->session->get('travellers');
		$fromEmail = Yii::$app->params['supportEmail'];
		$toEmail 	= $customer['email'];
		$alias='PAYMENTCUSTOMER01';
		$emailContent = $this->getEmailContent($alias);
		if(isset($emailContent['message']) && !empty($emailContent['message'])) {
			$clink = '<a href="'.SITE_URL.'" target="_blank">here</a>';
			$msg = '';
			$msg .=  $emailContent['message'];
			$time =  date('d M, Y - h:m A');
			$logo = '<a href=""><img src = "' . SITE_LOGO . '" /></a>';
			$subject  ="Payment has been made successfully.";
			$message  ='';
			$message .='<tr><td align="left"><table width="500" border="0" bgcolor="#2c1f14" cellspacing="1" cellpadding="6" style=" color:#585858;">
							<tr  bgcolor="#333333">
							  <td colspan="2" style="border-top:#333333 solid 0px; font-size:14px; font-weight:400; color:#ffffff; text-transform:capitalize;   padding:8px;">Booking Detail</td>
							</tr>
							<tr  bgcolor="#ffffff">
							  <td width="100" >Booking Location</td>
							  <td width="270" >'.$booking_details['booking_destination'].'</td>
							</tr>
							<tr  bgcolor="#ffffff">
							  <td>Booking Date</td>
							  <td >'.$bookingDate.'</td>
							</tr>';

						if(isset($booking->no_of_hours) && $booking->no_of_hours > 0) {	
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Hours</td>
											<td >'.$booking->no_of_hours.'</td>
										</tr>';
						} else {
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Days</td>
											<td >'. (isset($booking->no_of_days) ? $booking->no_of_days : '') .'</td>
										</tr>';
						}

						$message .='<tr  bgcolor="#ffffff">
							  <td>Booking Price</td>
							  <td >'.$booking_details['currency_sign'].' '.$bookingPrice.'</td>
							</tr>						
							<tr  bgcolor="#ffffff">
							  <td>Number of Travelers</td>
							  <td >'. (isset($travellersCnt) ? $travellersCnt : 2).'</td>
							</tr>						
						  </table></td>
						</tr>';
			
			//$cname = $customer['usrFirstname'].' '.$customer['usrLastname'];
			//$gname = $member['usrFirstname'].' '.$member['usrLastname'];
			$msg = str_replace("<{username}>", $customer['usrFirstname'],  str_replace("&lt;{username}&gt;", $customer['usrFirstname'], $msg));	
			//$msg = str_replace("<{cname}>", $cname,  str_replace("&lt;{cname}&gt;", $cname, $msg));
			//$msg = str_replace("<{gname}>", $gname,  str_replace("&lt;{gname}&gt;", $gname, $msg));
			$msg = str_replace("<{link}>", $clink,  str_replace("&lt;{link}&gt;", $clink, $msg));	
			$msg = str_replace("<{logo}>", $logo,  str_replace("&lt;{logo}&gt;", $logo, $msg));
			$msg = str_replace("<{time}>", $time,  str_replace("&lt;{time}&gt;", $time, $msg));
			$msg = str_replace("<{subject}>", $subject,  str_replace("&lt;{subject}&gt;", $subject, $msg));
			$msg = str_replace("<{baseurl}>", SITE_URL,  str_replace("&lt;{baseurl}&gt;", SITE_URL, $msg));
			$msg = str_replace("<{content}>", $message,  str_replace("&lt;{content}&gt;", $message, $msg));				   
			$mail = Yii::$app->mailer->compose(['html' => 'layouts/mail1'],['content' => $msg, 'subject' => $subject])
			->setFrom($fromEmail)
			->setTo($toEmail)
			->setSubject($subject)
			->send();
			return $mail;
		} else {
			$subject  ="Payment has been made successfully.";
			$message  ='';
			$message .='<tr>';
				$message .='<td height="26" style="font-size:15px; font-weight:500; color:#333333;">Dear '.$customer['usrFirstname'].',</td>';
			$message .='</tr>';
			$message .='<tr>';
				$message .='<td style="font-size:13px; color:#585858; line-height:18px; padding-bottom:10px;">Your payment for the booking has been done successfully. Please click <a href="'.SITE_URL.'" target="_blank">here</a> to access your account. Booking details are given below:</td>';
			$message .='</tr>';
			$message .='<tr>';
				$message .='<td height="15"></td>';
			$message .='</tr>';
			$message .='<tr><td align="left"><table width="500" border="0" bgcolor="#2c1f14" cellspacing="1" cellpadding="6" style=" color:#585858;">
							<tr  bgcolor="#333333">
							  <td colspan="2" style="border-top:#333333 solid 0px; font-size:14px; font-weight:400; color:#ffffff; text-transform:capitalize;   padding:8px;">Booking Detail</td>
							</tr>
							<tr  bgcolor="#ffffff">
							  <td width="100" >Booking Location</td>
							  <td width="270" >'.$booking_details['booking_destination'].'</td>
							</tr>
							<tr  bgcolor="#ffffff">
							  <td>Booking Date</td>
							  <td >'.$bookingDate.'</td>
							</tr>';

						if(isset($booking->no_of_hours) && $booking->no_of_hours > 0) {	
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Hours</td>
											<td >'.$booking->no_of_hours.'</td>
										</tr>';
						} else {
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Days</td>
											<td >'. (isset($booking->no_of_days) ? $booking->no_of_days : '') .'</td>
										</tr>';
						}

						$message .='<tr  bgcolor="#ffffff">
							  <td>Booking Price</td>
							  <td >'.$booking_details['currency_sign'].' '.$bookingPrice.'</td>
							</tr>						
							<tr  bgcolor="#ffffff">
							  <td>Number of Travelers</td>
							  <td >'. (isset($travellersCnt) ? $travellersCnt : 2).'</td>
							</tr>						
						  </table></td>
						</tr>';
			
			$mail = Yii::$app->mailer->compose(['html' => 'layouts/mail'],['content' => $message, 'subject' => $subject])
			->setFrom($fromEmail)
			->setTo($toEmail)
			->setSubject($subject)
			->send();
			return $mail;
		}
	}

    /**
     * @ Function Name		: sendBookingRequsetMessage
     * @ Function Params	: booking details {array}
     * @ Function Purpose 	: send booking request message
     * @ Function Returns	: return
     */
    public function sendBookingRequsetMessage($booking_details = 0) {
        $userId = Yii::$app->user->getId();
        $message="New booking request has been sent from customer.";
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
     * @ Function Name		: emailToMember
     * @ Function Params	: 
     * @ Function Purpose 	: email to member 
     * @ Function Returns	: boolean true/false
     */     
    public function emailToMemberForBookingReq($customer,$member,$booking_details,$bookingDate,$bookingPrice,$booking) {
		$travellersCnt	   = Yii::$app->session->get('travellers');
		$fromEmail = Yii::$app->params['supportEmail'];
		$toEmail 	= $member->email;
		$alias='BOOKINGREQUESTTOMEMBER01';
		$emailContent = $this->getEmailContent($alias);
		if(isset($emailContent['message']) && !empty($emailContent['message'])) {
			$clink = '<a href="'.SITE_URL.'" target="_blank">here</a>';
			$msg = '';
			$msg .=  $emailContent['message'];
			$time =  date('d M, Y - h:m A');
			$logo = '<a href=""><img src = "' . SITE_LOGO . '" /></a>';
			$subject  ="New booking request has been received.";
			
			$message  ='';
			$message .='<tr><td align="left"><table width="500" border="0" bgcolor="#2c1f14" cellspacing="1" cellpadding="6" style=" color:#585858;">
							<tr  bgcolor="#333333">
							  <td colspan="2" style="border-top:#333333 solid 0px; font-size:14px; font-weight:400; color:#ffffff; text-transform:capitalize;   padding:8px;">Booking Detail</td>
							</tr>
							<tr  bgcolor="#ffffff">
							  <td width="100" >Booking Location</td>
							  <td width="270" >'.$booking_details['booking_destination'].'</td>
							</tr>
							<tr  bgcolor="#ffffff">
							  <td>Booking Date</td>
							  <td >'.$bookingDate.'</td>
							</tr>';
					
						if(isset($booking->no_of_hours) && $booking->no_of_hours > 0) {	
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Hours</td>
											<td >'.$booking->no_of_hours.'</td>
										</tr>';
						} else {
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Days</td>
											<td >'. (isset($booking->no_of_days) ? $booking->no_of_days : '') .'</td>
										</tr>';
						}

			$message .='<tr  bgcolor="#ffffff">
							  <td>Booking Price</td>
							  <td >'.$booking_details['currency_sign'].' '.$bookingPrice.'</td>
							</tr>						
							<tr  bgcolor="#ffffff">
							  <td>Number of Travelers</td>
							  <td >'. (isset($travellersCnt) ? $travellersCnt : 2).'</td>
							</tr>						
						  </table></td>
						</tr>';
			
			$cname = $customer['usrFirstname'].' '.$customer['usrLastname'];
			//$gname = $member['usrFirstname'].' '.$member['usrLastname'];
			$msg = str_replace("<{username}>", $member->usrFirstname,  str_replace("&lt;{username}&gt;", $member->usrFirstname, $msg));	
			$msg = str_replace("<{cname}>", $cname,  str_replace("&lt;{cname}&gt;", $cname, $msg));
			//$msg = str_replace("<{gname}>", $gname,  str_replace("&lt;{gname}&gt;", $gname, $msg));
			$msg = str_replace("<{link}>", $clink,  str_replace("&lt;{link}&gt;", $clink, $msg));	
			$msg = str_replace("<{logo}>", $logo,  str_replace("&lt;{logo}&gt;", $logo, $msg));
			$msg = str_replace("<{time}>", $time,  str_replace("&lt;{time}&gt;", $time, $msg));
			$msg = str_replace("<{subject}>", $subject,  str_replace("&lt;{subject}&gt;", $subject, $msg));
			$msg = str_replace("<{baseurl}>", SITE_URL,  str_replace("&lt;{baseurl}&gt;", SITE_URL, $msg));
			$msg = str_replace("<{content}>", $message,  str_replace("&lt;{content}&gt;", $message, $msg));				   
			$mail = Yii::$app->mailer->compose(['html' => 'layouts/mail1'],['content' => $msg, 'subject' => $subject])
			->setFrom($fromEmail)
			->setTo($toEmail)
			->setSubject($subject)
			->send();
			return $mail;
		} else {
			$subject  ="New booking request has been received.";
			$message  ='';
			$message .='<tr>';
				$message .='<td height="26" style="font-size:15px; font-weight:500; color:#333333;">Dear '.$member->usrFirstname.',</td>';
			$message .='</tr>';
			$message .='<tr>';
				$message .='<td style="font-size:13px; color:#585858; line-height:18px; padding-bottom:10px;">A new booking request has been sent by '.$customer['usrFirstname'].' '.$customer['usrLastname'].'. Please click <a href="'.SITE_URL.'" target="_blank">here</a> to access your account. See details below:</td>';
			$message .='</tr>';
			$message .='<tr>';
			$message .='<td height="15"></td>';
			$message .='</tr>  
						<tr><td align="left"><table width="500" border="0" bgcolor="#2c1f14" cellspacing="1" cellpadding="6" style=" color:#585858;">
							<tr  bgcolor="#333333">
							  <td colspan="2" style="border-top:#333333 solid 0px; font-size:14px; font-weight:400; color:#ffffff; text-transform:capitalize;   padding:8px;">Booking Detail</td>
							</tr>
							<tr  bgcolor="#ffffff">
							  <td width="100" >Booking Location</td>
							  <td width="270" >'.$booking_details['booking_destination'].'</td>
							</tr>
							<tr  bgcolor="#ffffff">
							  <td>Booking Date</td>
							  <td >'.$bookingDate.'</td>
							</tr>';
					
						if(isset($booking->no_of_hours) && $booking->no_of_hours > 0) {	
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Hours</td>
											<td >'.$booking->no_of_hours.'</td>
										</tr>';
						} else {
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Days</td>
											<td >'. (isset($booking->no_of_days) ? $booking->no_of_days : '') .'</td>
										</tr>';
						}

			$message .='<tr  bgcolor="#ffffff">
							  <td>Booking Price</td>
							  <td >'.$booking_details['currency_sign'].' '.$bookingPrice.'</td>
							</tr>						
							<tr  bgcolor="#ffffff">
							  <td>Number of Travelers</td>
							  <td >'. (isset($travellersCnt) ? $travellersCnt : 2).'</td>
							</tr>						
						  </table></td>
						</tr>';
			
			$mail = Yii::$app->mailer->compose(['html' => 'layouts/mail'],['content' => $message, 'subject' => $subject])
			->setFrom($fromEmail)
			->setTo($toEmail)
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
		$modelLink = new \common\models\Admin();
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
