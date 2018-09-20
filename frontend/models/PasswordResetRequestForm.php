<?php
namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'message' => Yii::t('yii','There is no user with such email.')
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        $user = User::findOne([
           'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
        }

        if (!$user->save()) {
            return false;
        }

        $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
        $fromEmail = Yii::$app->params['adminEmail'];
        $subject = 'Password reset for MyGuyde';
		$message  ='';
		$message .='<tr>';
			$message .='<td height="26" style="font-size:15px; font-weight:500; color:#333333;">Dear user,</td>';
		$message .='</tr>';
		$message .='<tr>';
			$message .='<td style="font-size:13px; color:#585858; line-height:18px; padding-bottom:10px;">To reset your password click on the link: <a href="'.$resetLink.'">Reset Password</a>.</td>';
		$message .='</tr>';
		$message .='<tr>';
			$message .='<td height="5"></td>';
		$message .='</tr>';
		$message .='<tr>';
			$message .='<td height="15"></td>';
		$message .='</tr>';
		echo $message; die;
        $mail = Yii::$app->mailer->compose(['html' => 'layouts/mail'], ['content' => $message, 'subject' => $subject])
        ->setFrom($fromEmail)
        ->setTo($this->email)
        ->setSubject($subject)
        ->send();     
        return $mail;
    }
}
