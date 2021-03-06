<?php
/**
 * Paypal.php
 *
 * https://github.com/stdevteam/yii-paypal
 *
 * @author STDev <yii@st-dev.com>
 * @copyright 2013 STDev http://st-dev.com
 * @license released under dual license BSD License and LGP License
 * @package PayPal
 * @version 1.0
 */

namespace frontend\components; 
 
use Yii;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;
use yii\base\Component;

class Paypal extends Component{
    /** 
    # API user: The user that is identified as making the call. you can 
    # also use your own API username that you created on PayPalâ€™s sandbox 
    # or the PayPal live site 
    */ 
    public $apiUsername;
    /** 
    # API_password: The password associated with the API user 
    # If you are using your own API username, enter the API password that 
    # was generated by PayPal below 
    # IMPORTANT - HAVING YOUR API PASSWORD INCLUDED IN THE MANNER IS NOT 
    # SECURE, AND ITS ONLY BEING SHOWN THIS WAY FOR TESTING PURPOSES 
    */ 
    public $apiPassword;
    /** 
    # API_Signature:The Signature associated with the API user. which is generated by paypal. 
    */ 
    public $apiSignature;
    public $apiLive = false;
	/**
	# The url (relative to base url) to return the customer after a successful payment
	*/
    public $returnUrl;
	
	/**
	# The url (relative to base url) to return the customer if he/she cancels the payment
	*/
    public $cancelUrl;

    /**
    # Default currency to use;
     */
    public $currency = 'USD';

    /**
    # Default description to use;
     */
    public $defaultDescription = '';

    /**
    # Default Quantity to use;
     */
    public $defaultQuantity = '1';

    /** 
    # Endpoint: this is the server URL which you have to connect for submitting your API request. 
    */ 
    public $endPoint;
    /** 
    USE_PROXY: Set this variable to TRUE to route all the API requests through proxy. 
    like define('USE_PROXY',TRUE); 
    */ 
    public $useProxy = false;
    public $proxyHost = '127.0.0.1'; 
    public $proxyPort = '808'; 
    /* Define the PayPal URL. This is the URL that the buyer is 
    first sent to to authorize payment with their paypal account 
    change the URL depending if you are testing on the sandbox 
    or going to the live PayPal site 
    For the sandbox, the URL is 
    https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token= 
    For the live site, the URL is 
    https://www.paypal.com/webscr&cmd=_express-checkout&token= 
    */ 
    public $paypalUrl;
    /** 
    # Version: this is the API version in the request. 
    # It is a mandatory parameter for each API request. 
    # The only supported value at this time is 2.3 
    */
    public $version = '98.0';//'3.0';
    
    public $apiUrl;
    public $appId;
    public $headers;
    
    public function init(){
		//Whether we are in sandbox or in live environment
		if((bool)$this->apiLive === true){
            //live
            $this->paypalUrl = 'https://www.paypal.com/webscr&cmd=_express-checkout&useraction=commit&token='; 
            $this->endPoint = 'https://api-3t.paypal.com/nvp';
            
            $this->apiUrl = 'https://svcs.paypal.com/AdaptivePayments/';
        }else{
            //sandbox
            $this->paypalUrl = 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&useraction=commit&token=';
            $this->endPoint = 'https://api-3t.sandbox.paypal.com/nvp';
            
            $this->apiUrl = 'https://svcs.sandbox.paypal.com/AdaptivePayments/';
           
        }
        
      //echo Url::canonical(); die;

        //set return and cancel urls
        //$this->returnUrl = Yii::$app->createUrl($this->returnUrl);
        //$this->cancelUrl = Yii::$app->createAbsoluteUrl($this->cancelUrl);
       
    }
    
    public function __construct(){ 
        $this->init();
    }
    
    public function DoDirectPayment($paymentInfo=array()){ 
        /** 
         * Get required parameters from the web form for the request 
         */ 
        $paymentType =urlencode('Sale'); 
        $firstName =urlencode($paymentInfo['Member']['first_name']); 
        $lastName =urlencode($paymentInfo['Member']['last_name']); 
        $creditCardType =urlencode($paymentInfo['CreditCard']['credit_type']); 
        $creditCardNumber = urlencode($paymentInfo['CreditCard']['card_number']); 
        $expDateMonth =urlencode($paymentInfo['CreditCard']['expiration_month']); 
        $padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT); 
        $expDateYear =urlencode($paymentInfo['CreditCard']['expiration_year']); 
        $cvv2Number = urlencode($paymentInfo['CreditCard']['cv_code']); 
      /*  
        $address1 = urlencode($paymentInfo['Member']['billing_address']); 
        $address2 = urlencode($paymentInfo['Member']['billing_address2']); 
        $country = urlencode($paymentInfo['Member']['billing_country']); 
        $city = urlencode($paymentInfo['Member']['billing_city']); 
        $state =urlencode($paymentInfo['Member']['billing_state']); 
        $zip = urlencode($paymentInfo['Member']['billing_zip']); 
         */
        $amount = urlencode($paymentInfo['Order']['theTotal']); 
        if(isset($paymentInfo['Member']['currency_name']) && !empty($paymentInfo['Member']['currency_name'])) {
			$currencyCode = $paymentInfo['Member']['currency_name'];
		} else {
			$currencyCode = $this->currency;
		}

        $paymentType=urlencode('Sale'); 
         
        $ip=$_SERVER['REMOTE_ADDR']; 
         
        /* Construct the request string that will be sent to PayPal. 
           The variable $nvpstr contains all the variables and is a 
           name value pair string with & as a delimiter */ 
        /*$nvpstr="&PAYMENTACTION=Sale&IPADDRESS=$ip&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".$padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&STREET2=$address2&CITY=$city&STATE=$state".
        "&ZIP=$zip&COUNTRYCODE=$country&CURRENCYCODE=$currencyCode";*/
         
        $nvpstr="&PAYMENTACTION=Sale&IPADDRESS=$ip&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".$padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&CURRENCYCODE=$currencyCode&NOSHIPPING=1";
         
        if(isset($paymentInfo['authorization'])) {
			#Payment authorization with AMT=$0
			 $nvpstr="&PAYMENTACTION=Authorization&IPADDRESS=$ip&AMT=0&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".$padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&CURRENCYCODE=$currencyCode&NOSHIPPING=1";
		}
         
        /* Make the API call to PayPal, using API signature. 
           The API response is stored in an associative array called $resArray */ 
        $resArray=$this->hash_call("doDirectPayment",$nvpstr); 
         
        /* Display the API response back to the browser. 
           If the response from PayPal was a success, display the response parameters' 
           If the response was an error, display the errors received using APIError.php. 
           */ 
         
        return $resArray; 
        //Contains 'TRANSACTIONID,AMT,AVSCODE,CVV2MATCH, Or Error Codes' 
    } 

    public function SetExpressCheckout($paymentInfo=array()){ 
        $amount = urlencode($paymentInfo['Order']['theTotal']);
        //description
        if($paymentInfo['Order']['description']){
            $desc = urlencode($paymentInfo['Order']['description']);
        }else{
            $desc = $this->defaultDescription;
        }
        //quantity
        if($paymentInfo['Order']['quantity']){
            $quantity = urlencode($paymentInfo['Order']['quantity']);
        }else{
            $quantity = $this->defaultQuantity;
        }
        $nvpstr=''; 
        $paymentType=urlencode('Sale'); 
        if($paymentInfo['Authorization']) {
			$nvpstr.= '&PAYMENTREQUEST_0_PAYMENTACTION=Authorization&PAYMENTREQUEST_0_AMT=1&PAYMENTREQUEST_0_CURRENCYCODE=USD';
			$paymentType='authorization';
		
		}
		
        
        if(isset($paymentInfo['Order']['currency_name']) && !empty($paymentInfo['Order']['currency_name'])) {
			$currencyCode = $paymentInfo['Order']['currency_name'];
		} else {
			$currencyCode=urlencode($this->currency);
		}
		
        $number = time();
         
        $returnURL =urlencode($this->returnUrl); 
        $cancelURL =urlencode($this->cancelUrl);


        $nvpstr .='&AMT='.$amount.'&PAYMENTACTION='.$paymentType.'&CURRENCYCODE='.$currencyCode.'&RETURNURL='.$returnURL.'&CANCELURL='.$cancelURL.'&DESC='.$desc.'&QTY='.$quantity.'&NOSHIPPING=1';
        
        if($paymentInfo['RecurringPayment'])
			$nvpstr.='&BILLINGTYPE=RecurringPayments&BILLINGAGREEMENTDESCRIPTION='.urlencode("Monthly subscription for membership");
			
		
        $resArray=$this->hash_call("SetExpressCheckout",$nvpstr); 
        return $resArray; 
    } 
     
    public function GetExpressCheckoutDetails($token){ 
        $nvpstr='&TOKEN='.$token; 
        $resArray=$this->hash_call("GetExpressCheckoutDetails",$nvpstr); 
        return $resArray; 
    } 
     
    public function DoExpressCheckoutPayment($paymentInfo=array()){ 
        $paymentType='Sale'; 
        if(isset($paymentInfo['currency_name']) && !empty($paymentInfo['currency_name'])) {
			$currencyCode = $paymentInfo['currency_name'];
		} else {
			 $currencyCode=$this->currency; 
		}

        $serverName = $_SERVER['SERVER_NAME']; 
        $nvpstr='&TOKEN='.urlencode($paymentInfo['TOKEN']).'&PAYERID='.urlencode($paymentInfo['PAYERID']).'&PAYMENTACTION='.urlencode($paymentType).'&AMT='.urlencode($paymentInfo['ORDERTOTAL']).'&CURRENCYCODE='.urlencode($currencyCode).'&IPADDRESS='.urlencode($serverName); 
        
         if($paymentInfo['Authorization']) {
		
			$nvpstr = '&TOKEN='.urlencode($paymentInfo['TOKEN']).'&PAYERID='.urlencode($paymentInfo['PAYERID']).'&PAYMENTREQUEST_0_PAYMENTACTION=Authorization&PAYMENTREQUEST_0_AMT=1&PAYMENTREQUEST_0_CURRENCYCODE=USD';
			
		}
		
        $resArray=$this->hash_call("DoExpressCheckoutPayment",$nvpstr); 
        return $resArray; 
    } 
     
    public function APIError($errorNo,$errorMsg,$resArray){ 
        $resArray['Error']['Number']=$errorNo; 
        $resArray['Error']['Number']=$errorMsg; 
        return $resArray; 
    } 
    
    public function isCallSucceeded($resArray){
	
        $ack = isset($resArray["ACK"])?strtoupper($resArray["ACK"]):''; 
        //Detect Errors 
        if($ack != "SUCCESS" && $ack != 'SUCCESSWITHWARNING'){ 
            return false;
        }else{
            return true;
        }
    }
     
    public function CreateRecurringPaymentsProfile($PayPalRequestData)
	{
		//'--------------------------------------------------------------
		//' At this point, the buyer has completed authorizing the payment
		//' at PayPal.  The function will call PayPal to obtain the details
		//' of the authorization, incuding any shipping information of the
		//' buyer.  Remember, the authorization is not a completed transaction
		//' at this state - the buyer still needs an additional step to finalize
		//' the transaction
		//'--------------------------------------------------------------
		$token 		= urlencode($PayPalRequestData['TOKEN']);
		$email 		= urlencode($PayPalRequestData['email']);
		$ShippingAddress = isset($PayPalRequestData['ShippingAddress'])?$PayPalRequestData['ShippingAddress']:array();
		
		$nvpstr="";
		if($token !='')
			$nvpstr.="&TOKEN=".$token;
			
		if(!empty($ShippingAddress))
		{
			$shipToName		= urlencode($ShippingAddress['shipToName']);
			$shipToStreet		= urlencode($ShippingAddress['shipToStreet']);
			$shipToCity		= urlencode($ShippingAddress['shipToCity']);
			$shipToState		= urlencode($ShippingAddress['shipToState']);
			$shipToZip		= urlencode($ShippingAddress['shipToZip']);
			$shipToCountry	= urlencode($ShippingAddress['shipToCountry']);
			
			$nvpstr.="&SHIPTONAME=".$shipToName;
			$nvpstr.="&SHIPTOSTREET=".$shipToStreet;
			$nvpstr.="&SHIPTOCITY=".$shipToCity;
			$nvpstr.="&SHIPTOSTATE=".$shipToState;
			$nvpstr.="&SHIPTOZIP=".$shipToZip;
			$nvpstr.="&SHIPTOCOUNTRY=".$shipToCountry;
	   }
	    //'---------------------------------------------------------------------------
		//' Build a second API request to PayPal, using the token as the
		//'  ID to get the details on the payment authorization
		//'---------------------------------------------------------------------------
		
		
		#$nvpstr.="&EMAIL=".$email;
		
		$nvpstr.="&PROFILESTARTDATE=".urlencode($PayPalRequestData['profilestartdate']);
		$nvpstr.="&DESC=".urlencode("Monthly subscription for membership");
		$nvpstr.="&BILLINGPERIOD=".$PayPalRequestData['billingperiod'];
		$nvpstr.="&BILLINGFREQUENCY=".$PayPalRequestData['billingfrequency'];
		$nvpstr.="&AMT=".$PayPalRequestData['amt'];
		$nvpstr.="&CURRENCYCODE=USD";
		$nvpstr.="&IPADDRESS=" . $_SERVER['REMOTE_ADDR'];
		
		$CCDetails = isset($PayPalRequestData['CCDetails']) ? $PayPalRequestData['CCDetails'] : array();
		foreach($CCDetails as $CCDetailsVar => $CCDetailsVal)
		{
			$nvpstr .= $CCDetails != '' ? '&' . strtoupper($CCDetailsVar) . '=' . urlencode($CCDetailsVal) : '';
		}
		
		$PersonalDetails = isset($PayPalRequestData['PersonalDetails']) ? $PayPalRequestData['PersonalDetails'] : array();
		foreach($PersonalDetails as $PersonalDetailsVar => $PersonalDetailsVal)
		{
			$nvpstr .= $PersonalDetailsVal != '' ? '&' . strtoupper($PersonalDetailsVar) . '=' . urlencode($PersonalDetailsVal) : '';
		}
		
		//'---------------------------------------------------------------------------
		//' Make the API call and store the results in an array.  
		//'	If the call was a success, show the authorization details, and provide
		//' 	an action to complete the payment.  
		//'	If failed, show the error
		//'---------------------------------------------------------------------------
		$resArray=$this->hash_call("CreateRecurringPaymentsProfile",$nvpstr);
		
		return $resArray;
	}
		
    public function UpdateRecurringPaymentsProfile($PayPalRequestData)
	{
		//'--------------------------------------------------------------
		//' At this point, the buyer has completed authorizing the payment
		//' at PayPal.  The function will call PayPal to obtain the details
		//' of the authorization, incuding any shipping information of the
		//' buyer.  Remember, the authorization is not a completed transaction
		//' at this state - the buyer still needs an additional step to finalize
		//' the transaction
		//'--------------------------------------------------------------
		$token 		= urlencode($PayPalRequestData['TOKEN']);
		$email 		= urlencode($PayPalRequestData['email']);
		
		$nvpstr="";
		if($token !='')
			$nvpstr.="&TOKEN=".$token;
		
		$nvpstr.= isset($PayPalRequestData['profileid']) ? "&PROFILEID=".$PayPalRequestData['profileid'] : ''; 	
		
	    //'---------------------------------------------------------------------------
		//' Build a second API request to PayPal, using the token as the
		//'  ID to get the details on the payment authorization
		//'---------------------------------------------------------------------------
		
		
		#$nvpstr.="&EMAIL=".$email;
		
		$nvpstr.="&PROFILESTARTDATE=".urlencode($PayPalRequestData['profilestartdate']);
		$nvpstr.="&DESC=".urlencode("Monthly subscription for membership");
		$nvpstr.="&BILLINGPERIOD=".$PayPalRequestData['billingperiod'];
		$nvpstr.="&BILLINGFREQUENCY=".$PayPalRequestData['billingfrequency'];
		$nvpstr.="&AMT=".$PayPalRequestData['amt'];
		$nvpstr.="&CURRENCYCODE=USD";
		$nvpstr.="&IPADDRESS=" . $_SERVER['REMOTE_ADDR'];
		
		$CCDetails = isset($PayPalRequestData['CCDetails']) ? $PayPalRequestData['CCDetails'] : array();
		foreach($CCDetails as $CCDetailsVar => $CCDetailsVal)
		{
			$nvpstr .= $CCDetails != '' ? '&' . strtoupper($CCDetailsVar) . '=' . urlencode($CCDetailsVal) : '';
		}
		
		$PersonalDetails = isset($PayPalRequestData['PersonalDetails']) ? $PayPalRequestData['PersonalDetails'] : array();
		foreach($PersonalDetails as $PersonalDetailsVar => $PersonalDetailsVal)
		{
			$nvpstr .= $PersonalDetailsVal != '' ? '&' . strtoupper($PersonalDetailsVar) . '=' . urlencode($PersonalDetailsVal) : '';
		}
	
		
		//'---------------------------------------------------------------------------
		//' Make the API call and store the results in an array.  
		//'	If the call was a success, show the authorization details, and provide
		//' 	an action to complete the payment.  
		//'	If failed, show the error
		//'---------------------------------------------------------------------------
		$resArray=$this->hash_call("UpdateRecurringPaymentsProfile",$nvpstr);
		
		return $resArray;
	}
	
	/**
	 * Update the status of a previously created recurring payments profile.
	 *
	 * @access	public
	 * @param	array	call config data
	 * @return	array
	 */
	function ManageRecurringPaymentsProfileStatus($DataArray)
	{
		$nvpstr = '&METHOD=ManageRecurringPaymentsProfileStatus';
		
		$MRPPSFields = isset($DataArray['MRPPSFields']) ? $DataArray['MRPPSFields'] : array();
		foreach($MRPPSFields as $MRPPSFieldsVar => $MRPPSFieldsVal)
		{
			$nvpstr .= $MRPPSFieldsVal != '' ? '&' . strtoupper($MRPPSFieldsVar) . '=' . urlencode($MRPPSFieldsVal) : '';
		}
		
		$resArray=$this->hash_call("UpdateRecurringPaymentsProfile",$nvpstr);
		
		return $resArray;
	}
	
	
    public function hash_call($methodName,$nvpStr){
         
        $API_UserName = $this->apiUsername; 
        $API_Password = $this->apiPassword; 
        $API_Signature = $this->apiSignature; 
		$API_Endpoint = $this->endPoint;
        $version = $this->version; 
        
        //setting the curl parameters. 
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL,$API_Endpoint); 
        curl_setopt($ch, CURLOPT_VERBOSE, 1); 
     
        //turning off the server and peer verification(TrustManager Concept). 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
     
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
        curl_setopt($ch, CURLOPT_POST, 1); 
        //if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled. 
        //Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php  
         
        if($this->useProxy){ 
            curl_setopt ($ch, CURLOPT_PROXY, $this->proxyHost.":".$this->proxyPort);  
        }
     
        //NVPRequest for submitting to server 
		$nvpreq="METHOD=".urlencode($methodName)."&VERSION=".urlencode($version)."&PWD=".urlencode($API_Password)."&USER=".urlencode($API_UserName)."&SIGNATURE=".urlencode($API_Signature).$nvpStr;

        //setting the nvpreq as POST FIELD to curl 
        curl_setopt($ch,CURLOPT_POSTFIELDS,$nvpreq); 
     
        //getting response from server 
        $response = curl_exec($ch); 
     
        //convrting NVPResponse to an Associative Array 
        $nvpResArray=$this->deformatNVP($response); 
        $nvpReqArray=$this->deformatNVP($nvpreq); 
     
        if (curl_errno($ch)){ 
            $nvpResArray = $this->APIError(curl_errno($ch),curl_error($ch),$nvpResArray); 
        }else{  
            curl_close($ch); 
        }
     
        return $nvpResArray; 
    } 
     
    /** This function will take NVPString and convert it to an Associative Array and it will decode the response.
      * It is usefull to search for a particular key and displaying arrays. 
      * @nvpstr is NVPString. 
      * @nvpArray is Associative Array. 
      */    
    public function deformatNVP($nvpstr){ 
     
        $intial=0; 
         $nvpArray = array(); 
     
     
        while(strlen($nvpstr)){ 
            //postion of Key 
            $keypos= strpos($nvpstr,'='); 
            //position of value 
            $valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr); 
     
            /*getting the Key and Value values and storing in a Associative Array*/ 
            $keyval=substr($nvpstr,$intial,$keypos); 
            $valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1); 
            //decoding the respose 
            $nvpArray[urldecode($keyval)] =urldecode( $valval); 
            $nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr)); 
         } 
        return $nvpArray; 
    }

    /**
     * This function helps to refund the transaction by payerId and transactionId
     * TransactionId returned by {@see DoExpressCheckoutPayment}
     * @link https://developer.paypal.com/docs/classic/api/merchant/RefundTransaction_API_Operation_NVP/
     *
     * @param array $paymentInfo
     * @return array
     */
    public function RefundTransaction($paymentInfo=array())
    {
        $currencyCode=$this->currency;
        $nvpstr='&PAYERID='.urlencode($paymentInfo['PAYERID']).'&TRANSACTIONID='.urlencode($paymentInfo['TRANSACTIONID']).'&CURRENCYCODE='.urlencode($currencyCode).'&REFUNDTYPE='.urlencode('Full');
        $resArray=$this->hash_call("RefundTransaction",$nvpstr);
        return $resArray;
    }
    
      
    public function SetAdaptivePayment($paymentInfo=array()){ 
		//Whether we are in sandbox or in live environment
		if((bool)$this->apiLive === true){
            //live
            $this->paypalUrl = 'https://www.paypal.com/webscr&cmd=_ap-payment&paykey='; 
          
        }else{
            //sandbox
            $this->paypalUrl = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_ap-payment&paykey=';
         
        }
       
		$returnURL = $paymentInfo['returnUrl']; 
        $cancelURL = $paymentInfo['cancelUrl'];
       
       // create the pay request
		$createPacket = array(
			"actionType" =>"PAY",
			"currencyCode" => $this->currency,
			"receiverList" => array(
				"receiver" => $paymentInfo['receivers']
			),
			"returnUrl" => $returnURL,
			"cancelUrl" => $cancelURL,
			"requestEnvelope" => array(
				"errorLanguage" => "en_US",
				"detailLevel" => "ReturnAll",
			),
		);
		if(isset($paymentInfo['senderEmail']))
			$createPacket["senderEmail"] = $paymentInfo['senderEmail'];
         
        $response = $this->_paypalSend($createPacket,"Pay");
		return $response;
    }
   
	public function getAdaptivePaymentDetails($paykey){
	   
		$createPacket = array(
			"payKey" =>$paykey,
			"requestEnvelope" => array(
				"errorLanguage" => "en_US",
				"detailLevel" => "ReturnAll",
			),
		);
         
        $response = $this->_paypalSend($createPacket,"PaymentDetails");
		return $response;
		 
	}
    
    public function _paypalSend($data,$call){
		$this->headers = array(
			"X-PAYPAL-SECURITY-USERID: ".$this->apiUsername,
			"X-PAYPAL-SECURITY-PASSWORD: ".$this->apiPassword,
			"X-PAYPAL-SECURITY-SIGNATURE: ".$this->apiSignature,
			"X-PAYPAL-REQUEST-DATA-FORMAT: JSON",
			"X-PAYPAL-RESPONSE-DATA-FORMAT: JSON",
			"X-PAYPAL-APPLICATION-ID: ".$this->appId,
		);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->apiUrl.$call);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		$response = json_decode(curl_exec($ch),true);
		return $response;

	} 
    
    
    
}
