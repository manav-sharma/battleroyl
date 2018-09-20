<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use common\components\languageSwitcher;
use yii\db\Query;

AppAsset::register($this);

$asset 		= frontend\assets\AppAsset::register($this);
$baseUrl 	= $asset->baseUrl;
$actionId 	= Yii::$app->controller->action->id;
$CtrlName	= Yii::$app->controller->id;
$request 	= Yii::$app->request;
$param 		= $request->get('id');
$page='';
$siteimage = Yii::getAlias('@siteimage');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="<?= Yii::$app->charset ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <link rel="shortcut icon" href="<?php echo Yii::getAlias('@webThemeUrl/images'); ?>/favicon.ico"/>
        <title>Agari :: <?= Html::encode($this->title) ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--[if lt IE 9]>
        <script src="<?php echo Yii::getAlias('@webThemeUrl/images'); ?>js/html5shiv.js"></script>
        <script src="<?php echo Yii::getAlias('@webThemeUrl/images'); ?>js/respond.js"></script>
        <![endif]-->
        <?php $userLOGIN = Yii::$app->user->getId(); ?>
        <script>
            var siteUrl = "<?php echo Yii::getAlias('@basepath'); ?>";
            var baseUrl = "<?php echo Yii::getAlias('@basepath'); ?>";
            var language = "<?php echo (isset(Yii::$app->language) ? Yii::$app->language : 'en') ?>";
            var userLogIn = "<?php echo (isset($userLOGIN) && $userLOGIN > 0 ? 1 : 0) ?>";
        </script>
		<?php $this->head() ?> 
    </head>
	<body>
    <?php $this->beginBody() ?>
		<div id="outer">
		  <header>
			<div class="topGreenBar">
			  <div class="container">
				<div class="row">
				  <div class="col-md-2 col-sm-9 col-xs-9">
					<div class="language">
					  <ul>
						<li class="active"><a href="javascript:void(0)"><?php echo Yii::t('yii', 'En'); ?></a></li>
						<li><a href="javascript:void(0)"><?php echo Yii::t('yii', 'Ar'); ?></a></li>
					  </ul>
					</div>
					<div class="topSel">
					  <select>
						<option><?php echo Yii::t('yii', 'SAR'); ?></option>
						<option><?php echo Yii::t('yii', 'SAR01'); ?></option>
						<option><?php echo Yii::t('yii', 'SAR02'); ?></option>
					  </select>
					</div>
				  </div>
				  <div class="col-md-10 col-sm-3 col-xs-3">
					<div class="menutop"><i class="fa fa-bars" aria-hidden="true"></i></div>
					<div class="sideTopBar">
					  <div class="topMenu">
						<?php
							$hm=$ct=$ab=$cr=$ad=$lg=$rg='';                                               
							if($CtrlName == 'member' 	&& $actionId == 'index') { $hm = 'active'; }
							if($CtrlName == 'messages'  && $actionId == 'index') { $ct = 'active'; }
							if($CtrlName == 'member' 	&& $actionId == 'bookinghistory') { $ab = 'active'; }
							if($CtrlName == 'member' 	&& $actionId == 'ratings') { $cr = 'active'; }
							if($CtrlName == 'member' 	&& $actionId == 'settings') { $ad = 'active'; }
							if($CtrlName == 'site' 		&& $actionId == 'login') { $lg = 'active'; }
							if($CtrlName == 'site' 		&& $actionId == 'register') { $rg = 'active'; }
						?>
						<ul>
						  <li class="<?php echo $hm; ?>"><?php echo Html::a(Yii::t('yii', 'Home'), ['site/index'],['title'=> 'home']); ?></li>
						  <li class="<?php echo $ct; ?>"><?php echo Html::a(Yii::t('yii', 'Contact Us'), ['site/contactus'],['title'=> 'Contact Us']); ?></li>
						  <li class="<?php echo $ab; ?>"><?php echo Html::a(Yii::t('yii', 'About Us'), ['site/aboutus'],['title'=> 'About Us']); ?></a></li>
						  <li class="<?php echo $cr; ?>"><?php echo Html::a(Yii::t('yii', 'Career'), ['career/index'],['title'=> 'Career']); ?></li>
						  <li class="<?php echo $ad; ?>"><?php echo Html::a(Yii::t('yii', 'Advertise in Our Site'), ['advertisements/index'],['title'=> 'Advertise in Our Site']); ?></li>
						</ul>
					  </div>
					  <div class="loginBlock">
						<?php echo Html::a(Yii::t('yii', 'Login'), ['site/login'],['title'=> 'login','class'=>'login '.$lg]); ?>
						<?php echo Html::a(Yii::t('yii', 'Register'), ['site/register'],['title'=> 'Register','class'=>'register '.$rg]); ?>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			</div>
			<div class="header">
			  <div class="container">
				<div class="row">
				  <div class="col-xs-12">
					<div class="logoAdd">
					  <div class="logo"><a href="<?php echo Url::home().'site/home'; ?>" title="<?php echo Yii::t('yii', 'Agari'); ?>"><img src="<?php echo $siteimage;?>/logo.png" alt=""></a></div>
					  <div class="addBlock"><img src="<?php echo $siteimage;?>/add.jpg" alt=""></div>
					</div>
				  </div>
				</div>
				<div class="row">
				  <div class="col-md-4 col-sm-5 col-xs-12">
					<div class="socialIcons">
					  <ul>
						<li><a class="facebook" href="javascript:void(0)"><i class="fa fa-facebook-square" aria-hidden="true"></i></a><span>|</span></li>
						<li><a class="twitter" href="javascript:void(0)"><i class="fa fa-twitter-square" aria-hidden="true"></i></a><span>|</span></li>
						<li><a class="google" href="javascript:void(0)"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a><span>|</span></li>
						<li><a class="android" href="javascript:void(0)"><i class="fa fa-android" aria-hidden="true"></i></a><span>|</span></li>
						<li><a class="apple" href="javascript:void(0)"><i class="fa fa-apple" aria-hidden="true"></i></a><span>|</span></li>
						<li><a class="linkedin" href="javascript:void(0)"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
					  </ul>
					</div>
				  </div>
				  <div class="col-md-8 col-sm-7 col-xs-12">
					<div class="rightlinks innersmallMenu">
						<?php echo Html::a(Yii::t('yii', 'Add business Opportunity'), ['businessopportunity/add'],['title'=> 'Add business Opportunity']); ?>
						<?php echo Html::a(Yii::t('yii', 'Looking for partners'), ['partners/add'],['title'=> 'Looking for partners']); ?>
						<?php echo Html::a(Yii::t('yii', 'Add Your Property'), ['properties/add'],['title'=> 'Add Your Property']); ?>
					</div>
				  </div>
				</div>
				<div class="row">
				  <div class="col-xs-12">
					<nav class="navbar navbar-default">
					  <div class="navbar-header">
						<p class="menu"><?php echo Yii::t('yii', 'Menu'); ?></p>
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> <span class="sr-only"><?php echo Yii::t('yii', 'Toggle navigation'); ?></span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
					  </div>
					  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
						  <li class="<?php echo ($CtrlName == 'properties' && $actionId == 'add') ? 'active' : ''; ?>">
							<?php echo Html::a(Yii::t('yii', 'Property for Sale'), ['properties/add'],['title'=> 'Property for Sale']); ?>
							<span>|</span>
						  </li>
						  <li class="<?php echo ($CtrlName == 'properties' && $actionId == 'rent') ? 'active' : ''; ?>">
							<?php echo Html::a(Yii::t('yii', 'Property for Rent'), ['properties/add'],['title'=> 'Property for Rent']); ?>
							<span>|</span>
						   </li>
						  <li class="<?php echo ($CtrlName == 'properties' && $actionId == 'investment') ? 'active' : ''; ?>">
							<?php echo Html::a(Yii::t('yii', 'Property for Investment'), ['properties/add'],['title'=> 'Property for Investment']); ?>
							<span>|</span>
						  </li>
						  <li class="<?php echo ($CtrlName == 'properties' && $actionId == 'exchange') ? 'active' : ''; ?>">
							<?php echo Html::a(Yii::t('yii', 'Property for Exchange'), ['properties/add'],['title'=> 'Property for Exchange']); ?>
							<span>|</span>
						  </li>
						  <li class="<?php echo ($CtrlName == 'projects' && $actionId == 'newprojects') ? 'active' : ''; ?>">
							<?php echo Html::a(Yii::t('yii', 'New Projects'), ['properties/add'],['title'=> 'New Projects']); ?>
							<span>|</span></li>
						   <li class="<?php echo ($CtrlName == 'properties' && $actionId == 'ejaroffers') ? 'active' : ''; ?>">
							<?php echo Html::a(Yii::t('yii', 'Ejar Offers'), ['properties/add'],['title'=> 'Ejar Offers']); ?>
							<span>|</span>
						   </li>
						  <li class="<?php echo ($CtrlName == 'properties' && $actionId == 'agentoffers') ? 'active' : ''; ?>">
							<?php echo Html::a(Yii::t('yii', 'Agent Offers'), ['properties/add'],['title'=> 'Agent Offers']); ?>
						  </li>
						</ul>
					  </div>
					</nav>
				  </div>
				</div>
			  </div>
			</div>
		  </header>

        <?php echo $content; ?>

		  <footer>
			<div class="footerOuter">
			  <div class="container">
				<div class="row">
				  <div class="col-md-4 col-sm-4 col-xs-12">
					<?php
						$rse=$rsm=$rsd='';
						$rse = ($CtrlName == 'realestate' && $actionId == 'realestateanalytics') ? 'active' : '';
						$rsm = ($CtrlName == 'realestate' && $actionId == 'realestatemarket') ? 'active' : '';
						$rsd = ($CtrlName == 'realestate' && $actionId == 'realestatedevelopers') ? 'active' : '';
					?>			  
					<ul class="footerListing">
					  <li>
						  <?php echo Html::a(Yii::t('yii', 'Real Estate Analytics'), ['properties/add'],['title'=> 'Real Estate Analytics','class'=>$rse]); ?>
					  </li>
					  <li>
						  <?php echo Html::a(Yii::t('yii', 'Real Estate Market'), ['properties/add'],['title'=> 'Real Estate Market','class'=>$rsm]); ?>
					  <li>
						  <?php echo Html::a(Yii::t('yii', 'Real Estate Developers'), ['properties/add'],['title'=> 'Real Estate Developers','class'=>$rsd]); ?>
					  </li>
					</ul>
				  </div>
				  <div class="col-md-4 col-sm-4 col-xs-12">
					<?php
						$rsb=$rscc=$rsca='';
						$rsb 	= ($CtrlName == 'realestate' && $actionId == 'realestateanalytics') ? 'active' : '';
						$rscc 	= ($CtrlName == 'realestate' && $actionId == 'realestatemarket') ? 'active' : '';
						$rsca 	= ($CtrlName == 'realestate' && $actionId == 'realestatedevelopers') ? 'active' : '';
					?>					  
					<ul class="footerListing">
					  <li>
						  <?php echo Html::a(Yii::t('yii', 'Real Estate Brokers'), ['properties/add'],['title'=> 'Real Estate Brokers','class'=>$rsb]); ?>
					  </li>
					  <li>
						  <?php echo Html::a(Yii::t('yii', 'Real Estate Construction Companies'), ['properties/add'],['title'=> 'Real Estate Construction Companies','class'=>$rscc]); ?>
					  </li>
					  <li>
						  <?php echo Html::a(Yii::t('yii', 'Real Estate Consultants & Architects'), ['properties/add'],['title'=> 'Real Estate Consultants & Architects','class'=>$rsca]); ?>
					  </li>
					</ul>
				  </div>
				  <div class="col-md-4 col-sm-4 col-xs-12">
					<?php
						$rsa=$rsbo=$rspn='';
						$rsa 	= ($CtrlName == 'realestate' && $actionId == 'realestateanalytics') ? 'active' : '';
						$rsbo 	= ($CtrlName == 'realestate' && $actionId == 'realestatemarket') ? 'active' : '';
						$rspn 	= ($CtrlName == 'realestate' && $actionId == 'realestatedevelopers') ? 'active' : '';
					?>					  
					<ul class="footerListing">
					  <li>
						  <?php echo Html::a(Yii::t('yii', 'Real Estate Agents'), ['properties/add'],['title'=> 'Real Estate Agents','class'=>$rsa]); ?>
					  </li>
					  <li>
						  <?php echo Html::a(Yii::t('yii', 'Real Estate Business Opportunities'), ['properties/add'],['title'=> 'Real Estate Business Opportunities','class'=>$rsbo]); ?>
					  </li>
					  <li>
						  <?php echo Html::a(Yii::t('yii', 'Real Estate Partners Needed'), ['properties/add'],['title'=> 'Real Estate Partners Needed','class'=>$rspn]); ?>
					  </li>
					</ul>
				  </div>
				</div>
			  </div>
			</div>
			<div class="copyrightBlock">
			  <div class="container">
				<div class="row">
				  <div class="col-md-4 col-sm-4 col-xs-12">
					<p><?php echo Yii::t('yii', 'Copyright'); ?> © <?= date('Y') ?>. <?php echo Yii::t('yii', 'All Rights Reserved'); ?>.</p>
				  </div>
				  <div class="col-md-8 col-sm-8 col-xs-12">
					<ul class="footerMenu">
						<li class="<?php echo ($CtrlName == 'cms' && $actionId == 'terms') ? 'active' : ''; ?>"><?php echo Html::a(Yii::t('yii',"Terms &amp; Privacy"), Url::home() . 'cms/page/terms', ['title' => Yii::t('yii', "Terms &amp; Privacy")]); ?>
						<span>|</span></li>
						<li class="<?php echo ($CtrlName == 'testimonials' && $actionId == 'testimonials') ? 'active' : ''; ?>"><?php echo Html::a(Yii::t('yii',"Testimonials"), Url::home() . 'testimonials', ['title' => Yii::t('yii', "Testimonials")]); ?>
						<span>|</span></li>
						<li class="<?php echo ($CtrlName == 'downloadupload' && $actionId == 'downloadupload') ? 'active' : ''; ?>"><?php echo Html::a(Yii::t('yii',"Downloads &amp; Uploads"), Url::home() . 'downloadupload', ['title' => Yii::t('yii', "Downloads &amp; Uploads")]); ?></li>
					</ul>
				  </div>
				</div>
			  </div>
			</div>
		  </footer>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
