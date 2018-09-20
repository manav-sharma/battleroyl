<?php
################################= MYGUYDE PROJECT SET ALIAS =################################
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

Yii::setAlias('@basepath', 'http://' . $_SERVER['HTTP_HOST'] . '/projects/battleroyale/development/');
Yii::setAlias('@siteimage', 'http://' . $_SERVER['HTTP_HOST'] . '/projects/battleroyale/development/frontend/web/themes/battleroyale/images/');

#####################################= DEFINE CONSTANT =#####################################
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/projects/battleroyale/development/');
define('NO_IMAGE', SITE_URL."common/images/noimage.png");
define('NOIMAGE107x114', SITE_URL."common/images/Noimage107x114.png&text=NO+IMAGE");
define('UPLOAD_IMAGE', SITE_URL."common/uploads/images/");
define('dummy_image_male', SITE_URL."common/images/dummy_male.jpg");
define('dummy_image_female', SITE_URL."common/images/face-placeholder-woman.png");
define('SITE_LOGO', SITE_URL."common/images/logo.png");
define('PROFILE_IMAGE_PATH', SITE_URL."common/uploads/profile/");
define('CONTESTANT_IMAGE_PATH', SITE_URL."common/uploads/contestant/");
define('GROUP_IMAGE_PATH', SITE_URL."common/uploads/groupimages/");
define('DOCUMENT_DOWNLOAD_PATH', SITE_URL."common/uploads/documents/");
define('BANNER_IMAGE_PATH', SITE_URL."common/uploads/banner/");
define('POSTS_IMAGE_PATH', SITE_URL."common/uploads/posts/");
define('CONTENT_IMAGE_PATH', SITE_URL."common/uploads/contentimage/");
define('USER_DOCUMENT_PATH', SITE_URL."common/uploads/documents/");
defined('YII_BASEURL')  or define('YII_BASEURL', 'http://' . $_SERVER['HTTP_HOST']);
defined('ADMIN_EMAIL_ADDRESS')  or define('ADMIN_EMAIL_ADDRESS', 'testadmin@testmail.com');
defined('SITE_KEY') 		or define('SITE_KEY',   '6Lcy0EkUAAAAAEbYKAggVZJcZwULv6jERJQ9D0md');
define('SITE_NAME', 'Battle Royale');

#########################= User Types =############################
defined('CUSTOMER') or define('CUSTOMER', 'Customer');
defined('MEMBER') or define('MEMBER', 'Member');

defined('MALE') or define('MALE', 'Male');
defined('FEMALE') or define('FEMALE', 'Female');

########################= Social Sites =###########################
defined('GPLUS') or define('GPLUS', 'GPLUS');
defined('FACEBOOK') or define('FACEBOOK', 'FB');
defined('EMAIL') or define('EMAIL', 'EMAIL');

########################= User Status (Active,Inactive,Pending) =###########################
defined('PENDING') or define('PENDING',  '0');
defined('ACTIVE') or define('ACTIVE',   '1');
defined('INACTIVE') or define('INACTIVE', '2');


defined('LIMIT') or define('LIMIT', 15);
defined('PAGE_LIMIT') or define('PAGE_LIMIT', 5);
defined('MESSAGE_DATE_FORMAT') or define('MESSAGE_DATE_FORMAT',"d M, Y");
defined('DATETIME_FORMAT') or define('DATETIME_FORMAT',"Y-m-d H:i:s");

defined('PAYPAL_METHOD') or define('PAYPAL_METHOD', 'PAYPAL');
defined('BANK_TRANSFER') or define('BANK_TRANSFER', 'BANK');

defined('UP_INTEREST') or define('UP_INTEREST', 'You are allowed up to 5 interests.');
defined('UP_LANGUAGE') or define('UP_LANGUAGE', 'You are allowed up to 5 languages.');
