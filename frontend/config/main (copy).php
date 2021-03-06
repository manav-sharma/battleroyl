<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'), 
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'defaultRoute' => 'site/home',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'sourceLanguage' => 'en',
    'components' => [
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'fileMap' => [
                        'app' => 'yii.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_frontendUser',
            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'session' => [
            'name' => 'PHPFRONTSESSID',
            'savePath' => sys_get_temp_dir(),
        ],
        'request' => [
            'cookieValidationKey' => '[!@3e2df!#4$erg%4*$fd2&]',
            'csrfParam' => '_frontendCSRF',
        ],
        ######THESE CONFIGS ARE FOR LOGIN####ENDS#################
        'urlManager' => [
            'class' => 'yii\localeurls\UrlManager',
            'languages' => ['en', 'fr', 'en-US'],
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'search'=>'search/search-guide',
                ###ALLOW hyphen - sperated param values############################
                '<controller:\w+>/<action:\w+>/<id:[\w\?(\-\w)]+>' => '<controller>/<action>',
                
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller>/<action>/<id:\w+>' => '<controller>/<action>',                
            ],
        ],
        'view' => [
            'theme' => [
                'basePath' => '@frontend/web/themes/myguyde',
                'baseUrl' => '@frontend/web/themes/myguyde',
                'pathMap' => [
                    '@frontend/views' => '@frontend/web/themes/myguyde/views/',
                ],
            ],
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'authUrl' => 'https://www.facebook.com/dialog/oauth?display=popup',
                    'clientId' => '1786203434949580',
                    'clientSecret' => 'e95133afa1634eb0bf26009f8403540c',
                ],
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => '92034358582-iqin8vhphk17qo9mbp6g36db5n6hsn2n.apps.googleusercontent.com',
                    'clientSecret' => 'NYqjrPWZkq-EzUMElBHRqxHR',
                ],                
            ],
        ],
        'Paypal' => [
            'class'=>'frontend\components\Paypal',
            'apiUsername' => 'rajni-facilitator_api1.webworldexpertsindia.com',
            'apiPassword' => '1406092188',
            'apiSignature' => 'AiPC9BjkCyDFQXbSkoZcgqH3hpacAUwXDjY1j4PXXQi90988owea5iI4',
            'apiLive' => false,
            'appId' => 'APP-80W284485P519543T',

            'returnUrl' => 'http://localhost/projects/myguyde/development/payment/confirm', 
            'cancelUrl' => 'http://localhost/projects/myguyde/development/payment/cancel', 
            'currency' => 'USD',
        ],
        'twillio' => [
            'class' => 'yii\twillio\Twillio',
            'sid' 	=> 'ACbc471c6120ac2a1e4752ca04b730e449',
            'token' => 'eb231f7fba72a2d3db911a0284947497',
        ],       
		  
    ],
     ########ACCESS CONTROL RULES TO FORCE LOGIN STARTS###########################################################
    'as beforeRequest' => [
            'class' => \yii\filters\AccessControl::className(),
        'rules' => [
            [
                'actions' => [
                    'site', 'signup', 'login', 'error', 'aboutus', 'contactus', 'faq', 'home',
                    'page', 'getimages', 'forgot-password', 'reset-password', 'terms-and-conditions',
                    'filter', 'guide-profile', 'authGP', 'verifyemail', 'search-guide', 'contact-us','become-insider','states','updatecities','customer-feedback-notification','member-feedback-notification','cancel-booking-request','booking-reminders','verify-phone-number'
                ],
                'allow' => true,
            ],
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
    ],
    'params' => $params,
];
