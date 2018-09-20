<?php

namespace frontend\controllers;

use Yii;
use frontend\models\users\Users;
use frontend\models\messages\Messages;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Admin;
use yii\helpers\Url;
use yii\web\ErrorAction;
use yii\data\Pagination;
use yii\db\Query;

/**
 * Member controller
 */
class MessagesController extends Controller {

    /**
     * @inheritdoc
     */
    private $limit = LIMIT;

    /**
     * @ Function Name		: actionIndex
     * @ Function Params	: NA 
     * @ Function Purpose 	: default index function that will be called to display messages
     * @ Function Returns	: render view
     */
    public function actionIndex() {
        if (Yii::$app->user->isGuest) {
            if (Yii::$app->controller->action->id != 'index')
                Yii::$app->session->set('afterlogin', Yii::$app->request->url);

            return Yii::$app->user->loginRequired();
        }

        /*
         * ->where('is_trashed = 0 AND user_to = ' . $userId . ' 
                            AND (thread_id=0 OR thread_id in 
                                    (
                                        SELECT message_id from messages m 
                                            where m.message_id=messages.thread_id 
                                            AND m.thread_id=0 AND m.user_to not in (' . $userId . ')
                                    ) 
                                )
                            ORDER BY message_id DESC'
                );
         * 
         */
        
        
        $userId = Yii::$app->user->getId();
        $dataArray = array();
        $query = new Query;
        $attributes = Yii::$app->user->identity->getattributes();
        
        /*if(isset($attributes['usrType']) && $attributes['usrType'] == MEMBER) {*/

            $query->select('messages.*,usfrom.usrFirstname as fromfn,usfrom.usrLastname as fromln,usto.usrFirstname as tofn,usto.usrLastname as toln')
                ->from('(select * from messages order by message_id desc) as messages')
                ->join('LEFT JOIN', 'user usfrom', 'usfrom.id = messages.user_from')
                ->join('LEFT JOIN', 'user usto', 'usto.id = messages.user_to')
                ->where('(is_trashed != '.$userId.' AND is_trashed_by_from_user != '.$userId.') AND thread_id!=0 AND (user_to = ' . $userId . ' OR  user_from = ' . $userId . ') GROUP BY thread_id'
                );
            $query2 = 'SELECT `messages`.*, `usfrom`.`usrFirstname` AS `fromfn`, `usfrom`.`usrLastname` AS `fromln`, `usto`.`usrFirstname` AS `tofn`, `usto`.`usrLastname` AS `toln` FROM messages 
LEFT OUTER JOIN messages m2 ON messages.message_id = m2.thread_id
LEFT JOIN `user` `usfrom` ON usfrom.id = messages.user_from LEFT JOIN `user` `usto` ON usto.id = messages.user_to WHERE (messages.is_trashed != '.$userId.' AND messages.is_trashed_by_from_user != '.$userId.') AND messages.thread_id=0 AND (messages.user_to = '.$userId.' OR messages.user_from = '.$userId.') AND m2.thread_id IS NULL';
          $query->union($query2,true);
          //$query->addOrderBy(['message_id'=>SORT_DESC]);
       /* } else {
		$query->select('messages.*,usfrom.usrFirstname as fromfn,usfrom.usrLastname as fromln,usto.usrFirstname as tofn,usto.usrLastname as toln')
                ->from('(select * from messages order by message_id desc) as messages')
                ->join('LEFT JOIN', 'user usfrom', 'usfrom.id = messages.user_from')
                ->join('LEFT JOIN', 'user usto', 'usto.id = messages.user_to')
                ->where('is_trashed = 0 AND thread_id !=0 AND (user_to = ' . $userId . ')
                            
                            GROUP BY thread_id ORDER BY message_id DESC'
                );
	}*/
		
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->setPageSize(LIMIT);
        
        /*$query->createCommand()->getRawSql().' ORDER BY message_id DESC LIMIT '.$pages->offset.','.LIMIT; die;*/
        $messageResult = Yii::$app->db->createCommand($query->createCommand()->getRawSql().' ORDER BY message_id DESC LIMIT '.$pages->offset.','.LIMIT)->queryAll();
               
        //echo $query->createCommand()->getRawSql();
        //echo"<pre>"; print_r($messageResult); exit();
     
        $dataArray = array_merge($dataArray, [
            'messagesListing' => $messageResult,
            'pages' => $pages,
        ]);
        return $this->render('messages', $dataArray);
    }

    /**
     * @ Function Name		: actionIndex
     * @ Function Params	: NA 
     * @ Function Purpose 	: default index function that will be called to display messages
     * @ Function Returns	: render view
     */
    public function actionSentMessages() {
        if (Yii::$app->user->isGuest) {
            if (Yii::$app->controller->action->id != 'index')
                Yii::$app->session->set('afterlogin', Yii::$app->request->url);

            return Yii::$app->user->loginRequired();
        }

        $userId = Yii::$app->user->getId();
        $dataArray = array();
        $query = new Query;
        $query->select('messages.*,usfrom.usrFirstname as fromfn,usfrom.usrLastname as fromln,usto.usrFirstname as tofn,usto.usrLastname as toln')
                ->from('messages')
                ->join('LEFT JOIN', 'user usfrom', 'usfrom.id = messages.user_from')
                ->join('LEFT JOIN', 'user usto', 'usto.id = messages.user_to')
                ->where('is_trashed_by_from_user = 0 AND user_from = ' . $userId . ' ORDER BY message_id DESC');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->setPageSize(LIMIT);
        $query->offset($pages->offset)->limit(LIMIT);
        $messageResult = $query->createCommand()->queryAll();

        $dataArray = array_merge($dataArray, [
            'messagesListing' => $messageResult,
            'pages' => $pages,
        ]);
        return $this->render('sentmessages', $dataArray);
    }

    /**
     * @ Function Name		: actionMymessages
     * @ Function Params	: NA
     * @ Function Purpose 	: default index function that will be called to display messages
     * @ Function Returns	: render view
     */
    public function actionMymessages() {
        return $this->redirect(['messages/index']);
    }

    /**
     * @ Function Name		: actionRemovemessages
     * @ Function Params	: postArr {Array}
     * @ Function Purpose 	: remove message from guide profile
     * @ Function Returns	: redirect
     */
    public function actionRemovemessages() {
		$attributes = Yii::$app->user->identity->getattributes();
        $postArr = Yii::$app->request->post();
        $userId = Yii::$app->user->getId();
        $query = new Query;
        if (isset($postArr['optcheckbox'])) {

				$msgIds = implode(",", $postArr['optcheckbox']);
				foreach($postArr['optcheckbox'] as $val) {
					
					$query->select('user_from,user_to')
							->from('messages')
							->where('message_id =' . $val . ' || thread_id =' . $val)->orderBy('message_id ASC');
					$intial_msg = $query->createCommand()->queryOne();
					
					//print_r($intial_msg); exit();
					if($intial_msg['user_from'] == $userId) {
						Yii::$app->db->createCommand()->update('messages', ['is_trashed_by_from_user' => $userId], 'message_id = ' . $val . ' || thread_id = ' . $val)->execute();						
					}
					
					if($intial_msg['user_to'] == $userId) {
						Yii::$app->db->createCommand()->update('messages', ['is_trashed' => $userId], 'message_id = ' . $val . ' || thread_id = ' . $val)->execute();						
					}

				}
            Yii::$app->session->setFlash('item', Yii::t('yii', 'Selected message(s) deleted successfully.'));

        } else {
            Yii::$app->session->setFlash('item', Yii::t('yii', 'Selected message(s) were not deleted successfully.'));
        }
        $this->redirect(['messages/index']);
    }

    /**
     * @ Function Name		: actionRemovemessages
     * @ Function Params	: postArr {Array}
     * @ Function Purpose 	: remove message from guide profile
     * @ Function Returns	: redirect
     */
    public function actionRemovesentmessages() {
        $postArr = Yii::$app->request->post();
        $userId = Yii::$app->user->getId();
        if (isset($postArr['optcheckbox'])) {
            $msgIds = implode(",", $postArr['optcheckbox']);
            Yii::$app->db->createCommand()->update('messages', ['is_trashed_by_from_user' => 1], 'message_id IN (' . $msgIds . ') AND user_from = ' . $userId)->execute();
            Yii::$app->session->setFlash('item', Yii::t('yii', 'Selected message(s) deleted successfully.'));
        } else {
            Yii::$app->session->setFlash('item', Yii::t('yii', 'Selected message(s) were not deleted successfully.'));
        }
        $this->redirect(['messages/sent-messages']);
    }

    /**
     * @ Function Name		: actionViewmessage
     * @ Function Params	: id {int}
     * @ Function Purpose 	: message detail page
     * @ Function Returns	: render view
     */
    public function actionViewmessage($id = 0) {
        
        if (isset($id) && $id > 0) {
			
            $data = array();
            $userId = Yii::$app->user->getId();
            $messageModel = $this->findModel($id);
            $updateMessage = new Messages();
            $model = $updateMessage->findIdentity($id);

            ###getThreadInfo($threadId)####
            $messageModel = new messages();
            $arr_details = $messageModel->getThreadInfo($id);   
            $threadDetails = $arr_details['threadDetails'];
            $pages 		   = $arr_details['pages'];            
            $this->markReadStatus($id);
            #$messageResult = $this->getMessageInfo($id);

            $messageResult = $this->getMessageInfo($id);
            
            #echo "<Pre>"; print_r($messageResult);die;
            
            
            if (empty($messageResult)) {
                $this->redirect(['messages/index']);
            }
            
            $loggedUserId = Yii::$app->user->getId();
            
            $emailTo = '';
            $userTo = '';
            if($loggedUserId == $messageResult['sender_id'] )
            {
                $emailTo = $messageResult['receiver_email'];
                $userTo = $messageResult['receiver_id'];
            }
            else                
            {
                $emailTo = $messageResult['sender_email'];
                $userTo = $messageResult['sender_id'];
            }
			
			if($model['send_status'] == '1') {
				$emailTo	=	$this->getAdminEmailID();
				$userTo		=	1;
				$model->booking_id	=	01;
			}
			
            //return $this->render('reply', ['emailTo' => $emailTo, 'model' => $model, 'userTo' => $userTo]);

            
            if (empty($threadDetails)) {
                $this->redirect(['messages/index']);
            }
            return $this->render('viewmessage', ['messages' => $threadDetails,'pages'=>$pages,'emailTo' => $emailTo, 'model' => $model, 'userTo' => $userTo]);
            
        } else {
            $this->redirect(['messages/index']);
        }
    }

    /**
     * @ Function Name		: actionViewsentmessage
     * @ Function Params	: id {int}
     * @ Function Purpose 	: message detail page
     * @ Function Returns	: render view
     */
    public function actionViewsentmessage($id = 0) {
        if (isset($id) && $id > 0) {
            $this->markReadStatus($id);
            $dataArray = array();
            $messageResult = $this->getMessageFromInfo($id);
            $dataArray = array_merge($dataArray, [
                'messageInfo' => $messageResult,
            ]);
            if (empty($messageResult)) {
                $this->redirect(['messages/index']);
            }
            return $this->render('viewsentmessage', $dataArray);
        } else {
            $this->redirect(['messages/index']);
        }
    }

    /**
     * @ Function Name		: actionViewmessage
     * @ Function Params	: id {int}
     * @ Function Purpose 	: message detail page
     * @ Function Returns	: render view
     */
    public function actionMessagereply($id = 0) { 
        
        if (isset($id) && $id > 0) {
            $data = array();
            $userId = Yii::$app->user->getId();
            $messageModel = $this->findModel($id);
            $updateMessage = new Messages();
            $model = $updateMessage->findIdentity($id);

            $postMessage = Yii::$app->request->post('Messages');
            if (isset($postMessage) && !empty($postMessage)) {
				if($postMessage['send_status'] == '1') {
					if ($model->load(Yii::$app->request->post()) && $model->replyMessageToAdmin($id)) {
						Yii::$app->session->setFlash('item', Yii::t('yii', 'Your message has been sent successfully.'));
						//return $this->redirect(['index']);
					} else {
						Yii::$app->session->setFlash('item', Yii::t('yii', 'Please enter valid values for all the fields.'));
					}					
				} else {
					if ($model->load(Yii::$app->request->post()) && $model->replyMessage($id)) {
						$this->smsNotification($model->user_to,$model->user_from);
						Yii::$app->session->setFlash('item', Yii::t('yii', 'Your message has been sent successfully.'));
						//return $this->redirect(['index']);
					} else {
						Yii::$app->session->setFlash('item', Yii::t('yii', 'Please enter valid values for all the fields.'));
					}
				}
            }

            $messageResult = $this->getMessageInfo($id);
            
            #echo "<Pre>"; print_r($messageResult);die;
            
            
            if (empty($messageResult)) {
                $this->redirect(['messages/index']);
            }
            
            $loggedUserId = Yii::$app->user->getId();
            
            $emailTo = '';
            $userTo = '';
            if($loggedUserId == $messageResult['sender_id'] )
            {
                $emailTo = $messageResult['receiver_email'];
                $userTo = $messageResult['receiver_id'];
            }
            else                
            {
                $emailTo = $messageResult['sender_email'];
                $userTo = $messageResult['sender_id'];
            }
			
			if($model['send_status'] == '1') {
				$emailTo	=	$this->getAdminEmailID();
				$userTo		=	1;
				$model->booking_id	=	01;
			}
			
			$this->redirect(['messages/viewmessage/'.$id]);
            //return $this->render('reply', ['emailTo' => $emailTo, 'model' => $model, 'userTo' => $userTo]);
        } else {
            $this->redirect(['messages/index']);
        }
    }

    /**
     * GET message details for thread parent message initiator
     * @param type $message_id
     * @return type
     */
    public function getMessageInfo($message_id = 0) {
        ###$userId = Yii::$app->user->getId();
        $query = new Query;
        $query->select('uf.email sender_email, uf.id sender_id, ut.email receiver_email, ut.id receiver_id,')
            ->from('messages')
            ->join('LEFT JOIN', 'user uf', 'uf.id = messages.user_from')
            ->join('LEFT JOIN', 'user ut', 'ut.id = messages.user_to')
            ->where('message_id =' . $message_id);### . ' AND user_to =' . $userId
        return $query->createCommand()->queryOne();
    }

    /**
     * @ Function Name		: getMessageFromInfo
     * @ Function Params	: message_id {int}
     * @ Function Purpose 	: message detail
     * @ Function Returns	: return
     */
    public function getMessageFromInfo($message_id = 0) {
        $userId = Yii::$app->user->getId();
        $query = new Query;
        $query->select('messages.message_id,messages.subject,messages.message,messages.send_status,messages.date_created,us.usrFirstname,us.usrLastname,us.email')
                ->from('messages')
                ->join('LEFT JOIN', 'user us', 'us.id = messages.user_to')
                ->where('message_id =' . $message_id . ' AND user_from =' . $userId);
        return $query->createCommand()->queryOne();
    }

    /**
     * @ Function Name		: getBookingInfo
     * @ Function Params	: booking_id {int} , type=(CUSTOMER/MEMBER)
     * @ Function Purpose 	: booking detail
     * @ Function Returns	: return
     */
    public function getBookingInfo($booking_id = 0) {
        $userId = Yii::$app->user->getId();
        $attributes = Yii::$app->user->identity->getattributes();
        $type = (isset($attributes['usrType']) ? $attributes['usrType'] : '');
        $query = new Query;
        if ($type == MEMBER) {
            $query->select('booking.booking_id,booking.customer_user_id as to_user_id,booking.guyde_user_id as from_user_id,us.usrFirstname,us.usrLastname,us.email')
                    ->from('booking')
                    ->join('LEFT JOIN', 'user us', 'us.id = booking.customer_user_id')
                    ->where('booking_id =' . $booking_id . ' AND guyde_user_id =' . $userId);

            $result = $query->createCommand()->queryOne();
            if (!empty($result))
                return $result;
        }
        $query = new Query;
        $query->select('booking.booking_id,booking.guyde_user_id as to_user_id,booking.customer_user_id as from_user_id,us.usrFirstname,us.usrLastname,us.email')
                ->from('booking')
                ->join('LEFT JOIN', 'user us', 'us.id = booking.guyde_user_id')
                ->where('booking_id =' . $booking_id . ' AND customer_user_id =' . $userId);
        return $query->createCommand()->queryOne();
    }

    /**
     * @ Function Name		: markReadStatus
     * @ Function Params	: message_id {int}
     * @ Function Purpose 	: mark read status
     * @ Function Returns	: return
     */
    public function markReadStatus($message_id = 0) {
        $userId = Yii::$app->user->getId();
		 $attributes = Yii::$app->user->identity->getattributes();

			$query = new Query;
			$query->select('thread_id')
					->from('messages')
					->where('message_id =' . $message_id . ' AND user_to =' . $userId);
			$thread = $query->createCommand()->queryOne();
			if(isset($thread['thread_id']) && $thread['thread_id'] > 0) {
				Yii::$app->db->createCommand()
				->update('messages', ['is_read' => 1], 
					'(message_id IN (' . $thread['thread_id'] . ') || thread_id =  ' . $thread['thread_id'] . ') AND user_to = ' . $userId
				)->execute();
			} else {
				Yii::$app->db->createCommand()
					->update('messages', ['is_read' => 1], 
						'(message_id IN (' . $message_id . ') || thread_id =  ' . $message_id . ') AND user_to = ' . $userId
					)->execute();
			}
    }

    /**
     * @ Function Name		: actionSendmessage
     * @ Function Params	: id {int}
     * @ Function Purpose 	: send new message
     * @ Function Returns	: render view
     */
    public function actionSendmessage($id = 0) {
        if (isset($id) && $id > 0) {
            $data = array();
            $userId = Yii::$app->user->getId();
            $model = new Messages();

            $postMessage = Yii::$app->request->post('Messages');
            if (isset($postMessage) && !empty($postMessage)) {
                if ($model->load(Yii::$app->request->post()) && $model->replyMessage()) {
                    Yii::$app->session->setFlash('item', Yii::t('yii', 'Your message has been sent successfully.'));
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('item', Yii::t('yii', 'Please enter valid values for all the fileds.'));
                }
            }

            $dataArray = array();
            $bookingResult = $this->getBookingInfo($id);
            //echo '<pre>'; print_r($bookingResult); die;
            $dataArray = array_merge($dataArray, [
                'messageInfo' => $bookingResult,
                'model' => $model,
            ]);

            return $this->render('sendmessage', $dataArray);
        } else {
            $this->redirect(['messages/index']);
        }
    }

    /**
     * @ Function Name		: actionSendmessage
     * @ Function Params	: id {int}
     * @ Function Purpose 	: send new message
     * @ Function Returns	: render view
     */
    public function actionContactwithguide($id) {
        $userId = Yii::$app->user->getId();
        // Throw exception if user try to contact him/herself
        if ($userId == $id) {
            throw new \yii\web\ForbiddenHttpException(Yii::t('yii', 'You are not allowed to access this page.'));
            return false;
        }

        $data = array();
        $model = new Messages();

        $postMessage = Yii::$app->request->post('Messages');
        if (isset($postMessage) && !empty($postMessage)) {
            $model->booking_id = 0;
            if ($model->load(Yii::$app->request->post()) && $model->replyMessage($threadId = 0)) {
				$this->smsNotification($model->user_to,$model->user_from);
                Yii::$app->session->setFlash('item', Yii::t('yii', 'Your message has been sent successfully.'));
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('item', Yii::t('yii', 'Please enter valid values for all the fileds.'));
            }
        }

        $dataArray = array();
        $query = new Query;
        $query->select('id,email,usrFirstname,usrLastname')->from('user')->where('id =' . $id);
        $user = $query->createCommand()->queryOne();

        $dataArray = array_merge($dataArray, [
            'member' => $user,
            'model' => $model,
        ]);

        return $this->render('contactwithguide', $dataArray);
    }
    
    /**
     * @ Function Name		: actionBookrequestresponse
     * @ Function Params	: postArr {Array}
     * @ Function Purpose 	: accept/decline booking request
     * @ Function Returns	: redirect
     */
    public function actionBookrequestresponse($id) {
        $postArr = Yii::$app->request->post();
        $userId = Yii::$app->user->getId();
        
        if (isset($postArr['threadID']) && !empty($postArr['bookingResponse'])) {
			Yii::$app->db->createCommand()->update('booking', ['booking_status' => $postArr['bookingResponse']], 'booking_id = '.$postArr['bookingID'].' AND guyde_user_id = ' . $userId)->execute();
			if($postArr['bookingResponse'] == '1') {
				$this->bookingResponseEmail($postArr,true);
				Yii::$app->session->setFlash('item', Yii::t('yii', 'Booking requset has been accepted.'));
			} else if($postArr['bookingResponse'] == '2') {
				$this->bookingResponseEmail($postArr,false);
				Yii::$app->session->setFlash('item', Yii::t('yii', 'Booking requset has been declined.'));
			}
		}
		$this->redirect(['messages/viewmessage/'.$id]);
    }

    /**
     * Displays findModel.
     *
     * @return int
     */
    protected function findModel($id) {
        if (($model = Messages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii', 'The requested page does not exist.'));
        }
    }
    
 	 /**
     * @ Function Name		: bookingResponseEmail
     * @ Function Params	: 
     * @ Function Purpose 	: email template 
     * @ Function Returns	: boolean true/false
     */    
    public function bookingResponseEmail($booking_details,$response){
		$member = \frontend\models\users\Users::findOne($booking_details['user_to']);
		$customer = \frontend\models\users\Users::findOne($booking_details['user_from']);
		$booking = \frontend\models\Booking::findOne($booking_details['bookingID']);
		
		$bookingDate = $booking->booked_from_date;
		$booking_details['booking_destination'] = $booking->booking_destination;

		$datediff = strtotime($booking->booked_to_date) - strtotime($booking->booked_from_date); 
		if($datediff > 0)
			$bookingDate .= ' - '.$booking->booked_to_date;
		
		$this->sendBookingRequsetMessage($booking_details,$response);	
		$this->emailToCustomer($customer,$member,$booking,$bookingDate,$response);
		if($response == '1') {
			$this->emailToMember($customer,$member,$booking_details,$bookingDate,$booking);
		}		
	}
	
    /**
     * @ Function Name		: sendBookingRequsetMessage
     * @ Function Params	: booking details {array}
     * @ Function Purpose 	: send booking request message
     * @ Function Returns	: return
     */
    public function sendBookingRequsetMessage($booking_details = 0,$response) {
        $userId = Yii::$app->user->getId();
		if($response == true) {
			        $message="Booking request has been accepted by Insider .";
		} else {
			        $message="Booking request has been declined by Insider .";
		}
		
		if($userId == $booking_details['user_from']) {
			$uf = $booking_details['user_from'];
			$ut = $booking_details['user_to'];
		} else {
			$uf = $booking_details['user_to'];
			$ut = $booking_details['user_from'];			
		}
		
		
		
        $thread_id = $this->checkTHreadID($ut,$uf);
        Yii::$app->db->createCommand()
            ->insert('messages', ['user_from' => $uf,'user_to' => $ut,'message' => $message,'booking_id' => $booking_details['bookingID'],'status' => '1','booking_request' => '1', 'thread_id' => $thread_id])->execute();
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
     * @ Function Name		: emailToCustomer
     * @ Function Params	: 
     * @ Function Purpose 	: email to customer
     * @ Function Returns	: boolean true/false
     */    
    public function emailToCustomer($customer,$member,$booking_details,$bookingDate,$response) {
		if($response == true) {
			$res	=	'accepted';
			$subject  ="Booking request has been accepted.";
		} else {
			$res	=	'declined';
			$subject  ="Booking request has been declined.";
		}
		$fromEmail = Yii::$app->params['supportEmail'];
		$toEmail 	= $customer['email'];
		$alias='BOOKINGRESPONSE01';
		$emailContent = $this->getEmailContent($alias);
		if(isset($emailContent['message']) && !empty($emailContent['message'])) {
			$clink = '<a href="'.SITE_URL.'" target="_blank">here</a>';
			$msg = '';
			$msg .=  $emailContent['message'];
			$time =  date('d M, Y - h:m A');
			$logo = '<a href=""><img src = "' . SITE_LOGO . '" /></a>';
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

						if(isset($booking_details['no_of_hours']) && $booking_details['no_of_hours'] > 0) {	
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Hours</td>
											<td >'.$booking_details['no_of_hours'].'</td>
										</tr>';
						} else {
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Days</td>
											<td >'. (isset($booking_details['no_of_days']) ? $booking_details['no_of_days'] : '') .'</td>
										</tr>';
						}

			$message .='<tr  bgcolor="#ffffff">
							  <td>Booking Price</td>
							  <td >'.$booking_details['booking_price'].'</td>
							</tr>						
							<tr  bgcolor="#ffffff">
							  <td>Number of Travelers</td>
							  <td >'. (isset($booking_details['no_of_travellers']) ? $booking_details['no_of_travellers'] : 2).'</td>
							</tr>						
						  </table></td>
						</tr>';
			
			//$cname = $customer['usrFirstname'].' '.$customer['usrLastname'];
			//$gname = $member['usrFirstname'].' '.$member['usrLastname'];
			$msg = str_replace("<{username}>", $customer['usrFirstname'],  str_replace("&lt;{username}&gt;", $customer['usrFirstname'], $msg));	
			$msg = str_replace("<{response}>", $res,  str_replace("&lt;{response}&gt;", $res, $msg));
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
			$message  ='';
			$message .='<tr>';
				$message .='<td height="26" style="font-size:15px; font-weight:500; color:#333333;">Dear '.$customer['usrFirstname'].',</td>';
			$message .='</tr>';
			$message .='<tr>';
				$message .='<td style="font-size:13px; color:#585858; line-height:18px; padding-bottom:10px;"> Booking request has been '.$res.'. Please click <a href="'.SITE_URL.'" target="_blank">here</a> to access your account. Booking details are given below:</td>';
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

						if(isset($booking_details['no_of_hours']) && $booking_details['no_of_hours'] > 0) {	
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Hours</td>
											<td >'.$booking_details['no_of_hours'].'</td>
										</tr>';
						} else {
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Days</td>
											<td >'. (isset($booking_details['no_of_days']) ? $booking_details['no_of_days'] : '') .'</td>
										</tr>';
						}

			$message .='<tr  bgcolor="#ffffff">
							  <td>Booking Price</td>
							  <td >'.$booking_details['booking_price'].'</td>
							</tr>						
							<tr  bgcolor="#ffffff">
							  <td>Number of Travelers</td>
							  <td >'. (isset($booking_details['no_of_travellers']) ? $booking_details['no_of_travellers'] : 2).'</td>
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
     * @ Function Name		: emailToMember
     * @ Function Params	: 
     * @ Function Purpose 	: email to member 
     * @ Function Returns	: boolean true/false
     */     
    public function emailToMember($customer,$member,$booking_details,$bookingDate,$booking_details2) {
		$price = $booking_details2['booking_price'] - ($booking_details2['admin_fee'] + $booking_details2['service_fee']);
		$fromEmail = Yii::$app->params['supportEmail'];
		$toEmail 	= $member->email;

		$alias='BOOKINGRESPONSE02';
		$emailContent = $this->getEmailContent($alias);
		if(isset($emailContent['message']) && !empty($emailContent['message'])) {
			$clink = '<a href="'.SITE_URL.'" target="_blank">here</a>';
			$msg = '';
			$msg .=  $emailContent['message'];
			$time =  date('d M, Y - h:m A');
			$logo = '<a href=""><img src = "' . SITE_LOGO . '" /></a>';
			$subject  ="Congratulations! You have been hired.";
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

						if(isset($booking_details2['no_of_hours']) && $booking_details2['no_of_hours'] > 0) {	
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Hours</td>
											<td >'.$booking_details2['no_of_hours'].'</td>
										</tr>';
						} else {
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Days</td>
											<td >'. (isset($booking_details2['no_of_days']) ? $booking_details2['no_of_days'] : '') .'</td>
										</tr>';
						}

			$message .='<tr  bgcolor="#ffffff">
							  <td>Booking Price</td>
							  <td >'.$price.'</td>
							</tr>						
							<tr  bgcolor="#ffffff">
							  <td>Number of Travelers</td>
							  <td >'. (isset($booking_details2['no_of_travellers']) ? $booking_details2['no_of_travellers'] : 2).'</td>
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

						if(isset($booking_details2['no_of_hours']) && $booking_details2['no_of_hours'] > 0) {	
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Hours</td>
											<td >'.$booking_details2['no_of_hours'].'</td>
										</tr>';
						} else {
							$message .='<tr  bgcolor="#ffffff">
											<td>Number of Days</td>
											<td >'. (isset($booking_details2['no_of_days']) ? $booking_details2['no_of_days'] : '') .'</td>
										</tr>';
						}

			$message .='<tr  bgcolor="#ffffff">
							  <td>Booking Price</td>
							  <td >'.$price.'</td>
							</tr>						
							<tr  bgcolor="#ffffff">
							  <td>Number of Travelers</td>
							  <td >'. (isset($booking_details2['no_of_travellers']) ? $booking_details2['no_of_travellers'] : 2).'</td>
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
     * @ Function Name		: smsNotification
     * @ Function Params	: 
     * @ Function Purpose 	: email to member/customer
     * @ Function Returns	: boolean true/false
     */     
    public function smsNotification($userto,$userfrom) {
		$note_user = \frontend\models\users\Users::findOne($userto);
		$fromEmail = Yii::$app->params['supportEmail'];
		$toEmail 	= $note_user['email'];
		$alias='SMSNOTIFICATION01';
		$emailContent = $this->getEmailContent($alias);
		if(isset($emailContent['message']) && !empty($emailContent['message'])) {
			$clink = '<a href="'.SITE_URL.'" target="_blank">here</a>';
			$msg = '';
			$msg .=  $emailContent['message'];
			$time =  date('d M, Y - h:m A');
			$logo = '<a href=""><img src = "' . SITE_LOGO . '" /></a>';
			$subject  ="You have new notifications.";
			$message  ='';
			$message .='<tr>';
			$message .='<td height="15"></td>';
			$message .='</tr>';
			
			$msg = str_replace("<{username}>", $note_user['usrFirstname'],  str_replace("&lt;{username}&gt;", $note_user['usrFirstname'], $msg));	
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
			$subject  ="You have new notifications.";
			$message  ='';
			$message .='<tr>';
				$message .='<td height="26" style="font-size:15px; font-weight:500; color:#333333;">Dear '.$note_user['usrFirstname'].',</td>';
			$message .='</tr>';
			$message .='<tr>';
				$message .='<td style="font-size:13px; color:#585858; line-height:18px; padding-bottom:10px;">You'."'".'ve got a new message! Click <a href="'.SITE_URL.'" target="_blank">here</a> to access your account.</td>';
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
