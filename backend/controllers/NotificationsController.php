<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\properties\AddProperties;
use backend\models\properties\SendMessage;
use backend\models\properties\PropertiesSearch;
use backend\models\properties\UpdateProperties;
use backend\models\properties\Properties;
use backend\models\properties\Documents;
use common\models\Admin;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\db\Query;
##############= FOR FILE UPLOAD =################
use yii\web\UploadedFile;
use backend\models\properties\Uploads;

/**
 * Notifications controller
 */
class NotificationsController extends Controller
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
                        'actions' => ['sendmessage'],
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

	public function actionSendmessage() {
		$post_data = Yii::$app->request->post();
		$model = new SendMessage();
		if($model->load(Yii::$app->request->post()) && $model->validate()) {
			$post_data = Yii::$app->request->post('SendMessage');
			$userdata = Yii::$app->commonmethod->getUsers($post_data['userids']);
			if(isset($post_data['notification_type'][0]) && $post_data['notification_type'][0] == 'SMS') {
			    $message = (isset($post_data['message']) ? $post_data['message'] : "Testing..");
				$this->sendSMSNotification($message);	
			} else {
				$this->emailNotification($userdata,$post_data['message']);
			}
			Yii::$app->session->setFlash('item', 'The notifications have been sent successfully.');
			return $this->redirect(['/'.$post_data['lastrequest']]);			
		}
        return $this->render('sendmessage', [
            'data' => $post_data,
            'model' => $model,
        ]);
	}

    public function sendSMSNotification($message='') {
		$twillio 	= Yii::$app->twillio;
		$message 	= $twillio->getClient()->account->messages->sendMessage(
			'+13852132502',  // From a valid Twilio number
			'+918283808291', // Text this number
			$message
		);
		if(isset($message->sid) && $message->sid != '') {
			Yii::$app->session->setFlash('item', 'The notifications have been sent successfully.');
		}
	}

    public function emailNotification($users='',$text='') {
		$fromEmail = Yii::$app->commonmethod->getAdminEmailID();
		$subject  ="Admin notifications.";
		if(!empty($users)) {
			foreach($users as $user) {
				$toEmail 	= $user->email;
				$message  ='';
				$message .='<tr>';
					$message .='<td height="26" style="font-size:15px; font-weight:500; color:#333333;">Dear '.$user->firstname.',</td>';
				$message .='</tr>';
				$message .='<tr>';
					$message .='<td style="font-size:13px; color:#585858; line-height:18px; padding-bottom:10px;">'.$text.' Please click <a href="'.SITE_URL.'" target="_blank">here</a> to access your account. Details are given below:</td>';
				$message .='</tr>';
				$message .='<tr>';
				$message .='<td height="15"></td>';
				//~ $message .='</tr>  
							//~ <tr><td align="left"><table width="287" border="0" bgcolor="#2c1f14" cellspacing="1" cellpadding="6" style=" color:#585858;">
								//~ <tr  bgcolor="#333333">
								  //~ <td colspan="2" style="border-top:#333333 solid 0px; font-size:14px; font-weight:400; color:#ffffff; text-transform:capitalize;   padding:8px;">Booking Detail</td>
								//~ </tr>
								//~ <tr  bgcolor="#ffffff">
								  //~ <td width="100" >Booking Location</td>
								  //~ <td width="270" >'.$booking_details['booking_destination'].'</td>
								//~ </tr>
								//~ <tr  bgcolor="#ffffff">
								  //~ <td>Booking Date</td>
								  //~ <td >'.$bookingDate.'</td>
								//~ </tr>
							  //~ </table></td>
							//~ </tr>';
				
				Yii::$app->mailer->compose(['html' => 'layouts/mail'],['content' => $message, 'subject' => $subject])
				->setFrom($fromEmail)
				->setTo($toEmail)
				->setSubject($subject)
				->send();
				//return $mail;			
			}
		}
	}
}
