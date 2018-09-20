<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\helpers\Url;
use frontend\models\users\Users;
use frontend\models\Booking;
use yii\db\Query;

class BookingController extends Controller {

    private $limit = 10;

	public function beforeAction($action) {
		return true;
	}
	
	    
     /**
     * @ Function Name		: actionBookMember
     * @ Function Params	: @id- item id - member/guide/user id
     * @ Function Purpose 	: function to book member/guide.
     * @ Function Returns	: render view 
     */
    public function actionBookMember($id) {
		$customer = Yii::$app->user->identity;
		// Throw exception if user try to book him/herself
		if($customer->id == $id) {
			throw new \yii\web\ForbiddenHttpException(Yii::t('yii','You are not allowed to access this page.'));
			return false;
		}
		
		$guideDetails = Users::findOne($id);
		if($guideDetails === null) {
			throw new NotFoundHttpException(Yii::t('yii','Page not found.'));
			return false;
		}
                //echo '<pre>'; print_r(Yii::$app->session->get('searchpost')); 
                //die;
                $searchDestination = Yii::$app->session->get('searchDestination');
                $travellersCnt	   = Yii::$app->session->get('travellers');
                
		$model = new Booking;
		if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $travellersCnt =  Yii::$app->request->post('booked_travelers');
            Yii::$app->session->set('travellers', $travellersCnt);

			$currencyName = Yii::$app->request->post('Booking');
			$currency_name	=	"USD";
			if(isset($currencyName['currency_name']) && !empty($currencyName['currency_name'])) {
				$currency_name	=	$currencyName['currency_name'];
			}
			$currency_sign	=	"$";
			if(isset($currencyName['currency_sign']) && !empty($currencyName['currency_sign'])) {
				$currency_sign	=	$currencyName['currency_sign'];
			}			
			$memberInfo = \frontend\models\users\Users::findOne($id);
			
			$model->booked_from_date = date('Y-m-d',strtotime($model->booked_from_date));
			$model->booked_to_date = date('Y-m-d',strtotime($model->booked_to_date));
			
			$datediff = strtotime($model->booked_to_date) - strtotime($model->booked_from_date); 
			$dayCount = 1+floor($datediff/(60*60*24));
			
			if($model->isBooked($id)) {
				Yii::$app->session->setFlash('item', Yii::t('yii','Already booked for the selected date range! Please choose another Insider.'));
				return $this->render('book-member', [
                                    'model' => $model,
                                    'member_info' => $memberInfo,
                                    'search_String' => isset($searchDestination['searchString'])? $searchDestination['searchString']:'',
               'travellers_Cnt' => isset($travellersCnt)? $travellersCnt:''
				]);
               
			}
			#Check Availability
			$query	 = new Query;
			$query->select('available_dates')->from('user_availability')->where('user_id = '.$id);
			$availability = $query->createCommand()->queryOne();
			$availability = array_filter($availability);
			if(empty($availability)){
				Yii::$app->session->setFlash('item', Yii::t('yii','Not Available! Please choose another Insider.'));
				return $this->render('book-member', [
                                    'model' => $model,
                                    'member_info' => $memberInfo,
                                    'search_String' => isset($searchDestination['searchString'])? $searchDestination['searchString']:'',
               'travellers_Cnt' => isset($travellersCnt)? $travellersCnt:''
				]);
					
			}else{
					$dateRanges = Yii::$app->funcns->dateRangeAllDates($model->booked_from_date,$model->booked_to_date);
					$available_dates = explode(",",$availability['available_dates']);
					
					if(count(array_intersect($dateRanges, $available_dates)) != count($dateRanges))
					{
						Yii::$app->session->setFlash('item', Yii::t('yii','Not Available! Please choose a different date range.'));
						return $this->render('book-member', [
                                                    'model' => $model,
                                                    'member_info' => $memberInfo,
                                                    'search_String' => isset($searchDestination['searchString'])? $searchDestination['searchString']:'',
               'travellers_Cnt' => isset($travellersCnt)? $travellersCnt:''
						]);
					}
				}
			############# services charges ###########
			$query = new Query;
			$query->select('service_fee')->from('admin');
			$service_fee = $query->createCommand()->queryOne();
			$service_charge	=	0;
			if(isset($service_fee['service_fee']) && $service_fee['service_fee'] > 0 )
			{
				$service_charge	=	$service_fee['service_fee'];
			}
			#########################################

			if($dayCount == 1 && $model->no_of_hours>0 && $model->no_of_hours <= 8) {
				$booking_price = $model->no_of_hours*$guideDetails->usrHourPrice;   
			}else{
				$booking_price = $dayCount*$guideDetails->usrDayPrice;
                                $model->no_of_days = $dayCount;
                                $model->no_of_hours = 0;
			}

			$service_fee	=	($service_charge/100)*$booking_price;
            $referencenumber = mt_rand(100000, 999999);				
				
			$query2 = new Query;
			$query2->select('admin_fee')->from('admin');
			$commission = $query2->createCommand()->queryOne();		
			$admin_fee = 5;
			if(isset($commission['admin_fee']) && $commission['admin_fee'] > 0) {
				$admin_fee	=	($booking_price/100) * $commission['admin_fee'];
			}
			$booking_price	=	$booking_price+$service_fee;	
			$searchDestination = Yii::$app->session->get('searchDestination');
			$model->booking_destination = isset($searchDestination['searchString'])? $searchDestination['searchString']:'';
		
			$model->customer_user_id 	= $customer->id;
			$model->guyde_user_id 		= $id;
			$model->booking_price 		= $booking_price;
			$model->admin_fee 		= $admin_fee;
			$model->service_fee 		= $service_fee;
            $model->no_of_travellers = $travellersCnt;
            $model->reference_number = $referencenumber;                                
			$model->save();

			$bookReqDetail	=	array();
			$bookReqDetail['booking_id']		=	$model->booking_id;
			$bookReqDetail['guyde_user_id']		=	$model->guyde_user_id;
			$bookReqDetail['customer_user_id']	=	$model->customer_user_id;
			$bookReqDetail['booking_price']		=	$model->booking_price;
			$bookReqDetail['booking_destination']=	$model->booking_destination;
			
			//$this->sendBookingRequsetMessage($bookReqDetail);
			//$this->bookingReqSuccessEmail($bookReqDetail);
			
			Yii::$app->session->set('booking_details',[
				'booking_id'=>$model->booking_id,
				'guyde_user_id'=>$model->guyde_user_id,
				'customer_user_id'=>$model->customer_user_id,
				'currency_name'=>$currency_name,
				'currency_sign'=>$currency_sign,
				'booking_price'=>$model->booking_price,
				'booking_destination'=>$model->booking_destination
			]);			
			
			if($model->payment_method == 'CDCard')
				$this->redirect(['payment/directpayment']);	
			elseif($model->payment_method == 'PayPal')
				$this->redirect(['payment/expresscheckout']);	
				
		}
		
		$member = \frontend\models\users\Users::findOne($id);
            return $this->render('book-member', [
               'member_info' => $member,
               'model' => $model,
               'search_String' => isset($searchDestination['searchString'])? $searchDestination['searchString']:'',
               'travellers_Cnt' => isset($travellersCnt)? $travellersCnt:''
            ]);
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
        Yii::$app->db->createCommand()
            ->insert('messages', ['user_from' => $booking_details['customer_user_id'],'user_to' => $booking_details['guyde_user_id'],'message' => $message,'booking_id' => $booking_details['booking_id'],'status' => '1','booking_request' => '1'])->execute();
    }

 	 /**
     * @ Function Name		: booking Requset
     * @ Function Params	: 
     * @ Function Purpose 	: email template 
     * @ Function Returns	: boolean true/false
     */    
    public function bookingReqSuccessEmail($booking_details){
		$member = \frontend\models\users\Users::findOne($booking_details['guyde_user_id']);
		$customer = \frontend\models\users\Users::findOne($booking_details['customer_user_id']);
		$booking = \frontend\models\Booking::findOne($booking_details['booking_id']);
		
		$bookingDate = $booking->booked_from_date;
		$datediff = strtotime($booking->booked_to_date) - strtotime($booking->booked_from_date); 
		if($datediff > 0)
			$bookingDate .= ' - '.$booking->booked_to_date;

		$this->emailToMember($customer,$member,$booking_details,$bookingDate);
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
		$subject  ="New booking request has been received.";
		$message  ='';
		$message .='<tr>';
			$message .='<td height="26" style="font-size:15px; font-weight:500; color:#333333;">Dear '.$member->usrFirstname.',</td>';
		$message .='</tr>';
		$message .='<tr>';
			$message .='<td style="font-size:13px; color:#585858; line-height:18px; padding-bottom:10px;"> A new booking request has been sent by '.$customer['usrFirstname'].' '.$customer['usrLastname'].'. Please click <a href="'.SITE_URL.'" target="_blank">here</a> to access your account. See details below:</td>';
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

	public function actionDownloadBookingInfo($id=0) {
		$userId = Yii::$app->user->getId();
		$booking = \frontend\models\Booking::findOne($id);
		if(isset($booking) && !empty($booking)) {
			if($userId == $booking['customer_user_id']) {
				$get_user_id = $booking['guyde_user_id'];
				$amount = Yii::$app->formatter->asCurrency($booking->booking_price);
			} elseif($userId == $booking['guyde_user_id']) {
				$get_user_id = $booking['customer_user_id'];
				$amount = Yii::$app->formatter->asCurrency($booking->booking_price-($booking->admin_fee+$booking->service_fee));
			} else {
				return $this->redirect( Url::to(['site/index']) );
			}

			$usersinfo = \frontend\models\users\Users::findOne($get_user_id);
			if(isset($usersinfo) && !empty($usersinfo)) {
				$name = (isset($usersinfo->usrFirstname) ? $usersinfo->usrFirstname : '').' '.(isset($usersinfo->usrLastname) ? $usersinfo->usrLastname : '');
			}

			$amount = Yii::$app->formatter->asCurrency($booking->booking_price-($booking->admin_fee+$booking->service_fee));	
			$bookingDate = $booking->booked_from_date;
			$datediff = strtotime($booking->booked_to_date) - strtotime($booking->booked_from_date); 
			if($datediff > 0)
				 $bookingDate .= ' - '.$booking->booked_to_date;

			return $this->render('booking/examples/bookinginfo',['booking'=>$booking,'name'=>$name,'txtAmount'=>$amount,'bookingDate'=>$bookingDate]);
		} else {
			return $this->redirect( Url::to(['site/index']) );
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
    	
}	
