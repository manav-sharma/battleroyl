<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\helpers\Url;
use frontend\models\users\Users;
use frontend\models\Account;
use yii\db\Query;

class AccountController extends Controller {

    private $limit = 10;

	public function beforeAction($action) {
		return true;
	}

     /**
     * @ Function Name		: actionSettings
     * @ Function Params	: @id- item id - member/user id
     * @ Function Purpose 	: function to book member.
     * @ Function Returns	: render view
     */
    public function actionSettings1() {
        $attributes = Yii::$app->user->identity->getattributes();
        if(isset($attributes['usrType']) && $attributes['usrType'] == CUSTOMER) {
                throw new \yii\web\ForbiddenHttpException(Yii::t('yii','You are not allowed to access this page.'));
                return false;			
        }
        $id = Yii::$app->user->getId();		
        $dataArray = array();
        $guideDetails 	 = Users::findOne($id);
        if($guideDetails === null) {
                throw new NotFoundHttpException(Yii::t('yii','Page not found.'));
                return false;
        }
        $accountDetails  = Yii::$app->request->post('Account');
	if(isset($accountDetails) && !empty($accountDetails)) {
			
            if($accountDetails['account_type'] == PAYPAL_METHOD) {
                if($accountDetails['paypal_email_address'] == "") {
                        Yii::$app->session->setFlash('item', Yii::t('yii', 'Please enter valid values for all the fields!'));
                        return $this->redirect(['account/settings']);	
                }
		if($accountDetails['accept_currency'] == "") {
                    Yii::$app->session->setFlash('item', Yii::t('yii', 'Please enter valid values for all the fields!'));
                    return $this->redirect(['account/settings']);	
		}				
            } else {
                if($accountDetails['account_holder_name'] == "") {
                    Yii::$app->session->setFlash('item', Yii::t('yii', 'Please enter valid values for all the fields!'));
                    return $this->redirect(['account/settings']);	
                }
                if($accountDetails['bank_name'] == "") {
                    Yii::$app->session->setFlash('item', Yii::t('yii', 'Please enter valid values for all the fields!'));
                    return $this->redirect(['account/settings']);	
                }
                if($accountDetails['IBAN'] == "") {
                    Yii::$app->session->setFlash('item', Yii::t('yii', 'Please enter valid values for all the fields!'));
                    return $this->redirect(['account/settings']);	
                }
                if($accountDetails['account_number'] == "") {
                        Yii::$app->session->setFlash('item', Yii::t('yii', 'Please enter valid values for all the fields!'));
                        return $this->redirect(['account/settings']);	
                }
                if($accountDetails['region'] == "") {
                        Yii::$app->session->setFlash('item', Yii::t('yii', 'Please enter valid values for all the fields!'));
                        return $this->redirect(['account/settings']);	
                }
                if($accountDetails['bank_name'] == "") {
                        Yii::$app->session->setFlash('item', Yii::t('yii', 'Please enter valid values for all the fields!'));
                        return $this->redirect(['account/settings']);	
                }																								
            }
			
	####################################################
        $query	 = new Query;
        $query->select('COUNT(id) as cnt')->from('accountsetting')->where('guyde_user_id = '.$id);
        $validCount = $query->createCommand()->queryOne();
        if(isset($validCount['cnt']) && $validCount['cnt'] == 0) {
            if($accountDetails['account_type'] == PAYPAL_METHOD) {
                        $arr =	[
                                'paypal_email_address' => $accountDetails['paypal_email_address'],
                                'accept_currency' => (isset($accountDetails['accept_currency']) && $accountDetails['accept_currency'] != "" ? $accountDetails['accept_currency'] : "USD"),
                                'account_type' => $accountDetails['account_type'],
                                'guyde_user_id' => $id,
                                'datetime' => date("Y-m-d H:i:s"),
                        ];
            } else {
                $arr =	[
                        'account_holder_name' => $accountDetails['account_holder_name'],
                        'IBAN' => $accountDetails['IBAN'],
                        'bank_name' => $accountDetails['bank_name'],
                        'branch_code' => $accountDetails['branch_code'],
                        'account_number' => $accountDetails['account_number'],
                        'account_type' => $accountDetails['account_type'],
                        'region' => $accountDetails['region'],
                        'guyde_user_id' => $id,
                        'datetime' => date("Y-m-d H:i:s"),
                ];
            }
                $query->createCommand()->insert('accountsetting', $arr)->execute();
                Yii::$app->session->setFlash('item', Yii::t('yii', 'Your account information has been updated successfully.'));
            } else {
                if($accountDetails['account_type'] == PAYPAL_METHOD)                {
                        $arr =	[
                                'paypal_email_address' => $accountDetails['paypal_email_address'],
                                'accept_currency' => (isset($accountDetails['accept_currency']) && $accountDetails['accept_currency'] != "" ? $accountDetails['accept_currency'] : "USD"),
                                'account_type' => $accountDetails['account_type'],
                                'guyde_user_id' => $id,
                                'datetime' => date("Y-m-d H:i:s"),
                        ];
                } else {
                    $arr =	[
                            'account_holder_name' => $accountDetails['account_holder_name'],
                            'IBAN' => $accountDetails['IBAN'],
                            'bank_name' => $accountDetails['bank_name'],
                            'branch_code' => $accountDetails['branch_code'],
                            'account_number' => $accountDetails['account_number'],
                            'account_type' => $accountDetails['account_type'],
                            'region' => $accountDetails['region'],
                            'guyde_user_id' => $id,
                            'datetime' => date("Y-m-d H:i:s"),
                    ];
		}
				Yii::$app->db->createCommand()->update('accountsetting', $arr, 'guyde_user_id = '.$id)->execute();
				Yii::$app->session->setFlash('item', Yii::t('yii', 'Your account information has been updated successfully.'));
			}
		}
		
		$query	 = new Query;
		$query->select('*')->from('accountsetting')->where('guyde_user_id = '.$id);
		$accountInfo = $query->createCommand()->queryOne();		
		$model = $accountInfo;

		$model = new Account;
		$model['paypal_email_address'] = (isset($accountInfo['paypal_email_address']) ? $accountInfo['paypal_email_address'] : '');
		$model['account_holder_name'] = (isset($accountInfo['account_holder_name']) ? $accountInfo['account_holder_name'] : '');
		$model['bank_name'] = (isset($accountInfo['bank_name']) ? $accountInfo['bank_name'] : '');
		$model['IBAN'] = (isset($accountInfo['IBAN']) ? $accountInfo['IBAN'] : '');
		$model['branch_code'] = (isset($accountInfo['branch_code']) ? $accountInfo['branch_code'] : '');
		$model['account_number'] = (isset($accountInfo['account_number']) ? $accountInfo['account_number'] : '');
		$model['accept_currency'] = (isset($accountInfo['accept_currency']) ? $accountInfo['accept_currency'] : '');
		$model['account_type'] = (isset($accountInfo['account_type']) ? $accountInfo['account_type'] : '');
		$model['region'] = (isset($accountInfo['region']) ? $accountInfo['region'] : '');
		return $this->render('account-settings', [
           'model' => $model,
        ]);
	}
    
    /**
     * @ Function Name		: actionSettings
     * @ Function Params	: @id- item id - member/user id
     * @ Function Purpose 	: function to book member.
     * @ Function Returns	: render view
    */
    public function actionSettings() {
        $attributes = Yii::$app->user->identity->getattributes();
        if(isset($attributes['usrType']) && $attributes['usrType'] == CUSTOMER) {
                throw new \yii\web\ForbiddenHttpException(Yii::t('yii','You are not allowed to access this page.'));
                return false;			
        }
        $id = Yii::$app->user->getId();		
        $dataArray = array();
        $guideDetails 	 = Users::findOne($id);
        if($guideDetails === null) {
                throw new NotFoundHttpException(Yii::t('yii','Page not found.'));
                return false;
        }
        
        if (($model = Account::findOne(['guyde_user_id'=>$id])) === null)   {
            $model = new Account();
            $model->guyde_user_id = $id;
        }
        //$accountDetails  = Yii::$app->request->post('Account');
        $request = Yii::$app->request;
        $post = $request->post();
        //echo '<pre>'; print_r($request->post()); die;
        if(isset($post['Account']['region']) && $post['Account']['region'] == 'OUTSIDE_EUROPE')
            $post['Account']['IBAN'] = 'Test123';
        
        if($model->load($post)):
            //$model->scenario = 'PAYPAL';
            if($model->validate()){
                if(isset($model->region) && $model->region == 'OUTSIDE_EUROPE') { 
                    unset($model->IBAN);
                }
                
                $model->save(false);
               
                Yii::$app->session->setFlash('item', Yii::t('yii', 'Your account information has been updated successfully.'));
            }
       
	endif;
	
	return $this->render('account-settings', [
           'model' => $model,
        ]);
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
        
        
    protected function findModel($id) {
        if (($model = Account::findOne(['guyde_user_id'=>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    	
}	
