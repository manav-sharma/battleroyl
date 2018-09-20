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
        <title>Battle Royale :: <?= Html::encode($this->title) ?></title>
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
		<?php	$this->head(); 
			    $FunName  =	Yii::$app->controller->action->id;
		?> 
    </head>
	
    <?php $this->beginBody() ?>
  
    <?php  if($actionId != 'landing') {  ?>
<body>
<header>
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="borderBottom">
					<div class="row">
						<div class="col-md-3 col-sm-3 col-xs-12 pull-right">
							<?php  if(Yii::$app->user->isGuest){ ?>
								<div class="ragisterButton"> 
									<?php echo Html::a(Yii::t('yii', 'Register Now'), ['site/register'],['title'=> 'register']); ?> 
								</div>
							<?php }  else { ?>	
								<?php $attributes = Yii::$app->user->identity->getattributes(); 
									  $name = $attributes['firstname'].' '.$attributes['lastname'];
								?>
								<div class="topDropdown">
								<div class="notificationsArea">
									<div class="cleintimg">
									<?php if(!empty($attributes['profile_image'])) { ?>
										<img class="" height="54" width="54" src="<?php  echo PROFILE_IMAGE_PATH.'/'.$attributes['profile_image']; ?>" alt=""> 
									<?php }  else { ?>	
										<img class="" src="<?php echo NOIMAGE107x114; ?>" alt=""> 
									<?php } ?>	
									</div>
								</div>
								<div class="dropdown">
									<button class="btn btnTransparent dropdown-toggle" type="button" data-toggle="dropdown"> Welcome <?php echo $name; ?>! <i class="fa fa-angle-down" aria-hidden="true"></i></button>
									<ul class="dropdown-menu">
										<li><?php echo Html::a(Yii::t('yii', 'My Profile'), ['users/myprofile'],['title'=> 'My Profile']); ?></li>
										<li><?php echo Html::a(Yii::t('yii', 'Logout'), ['site/logout'],['title'=> 'Logout']); ?></li>
									</ul>
								</div>
							</div>
							<?php } ?>	
						</div>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<nav class="navbar navbar-default"> 
								<div class="navbar-header">
									<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
								</div>
								<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
									<ul class="nav navbar-nav">
										<?php 
											$cs=$hp=$faq=$lg=$std=$priz=$vot=$abut='';
											if($CtrlName == 'site' 		&& $actionId == 'contact-us') { $cs  = 'active'; } 
											if($CtrlName == 'site' 		&& $actionId == 'home') 	 { $hp  = 'active'; } 
											if($CtrlName == 'site' 		&& $actionId == 'faq') 	     { $faq = 'active'; }
											if($CtrlName == 'site' 		&& $actionId == 'login') 	 { $lg  = 'active'; }
											if($CtrlName == 'users' 	&& $actionId == 'standings') { $std = 'active'; }
											if($CtrlName == 'cms' && $actionId == 'page' && $param == 'prizes') { $priz = 'active'; }
											if($CtrlName == 'cms' && $actionId == 'page' && $param == 'vote') { $vot = 'active'; }
											if($CtrlName == 'cms' && $actionId == 'page' && $param == 'about') { $abut = 'active'; }
										?>
										
										<li class="<?php echo $hp; ?>">
											<?php echo Html::a(Yii::t('yii', 'Home'), ['site/home'],['title'=> 'Home']); ?>
										</li>
										
										<li class="<?php echo $std; ?>">
											<?php  if(Yii::$app->user->isGuest){ ?>
												<?php echo Html::a(Yii::t('yii', 'Standings'), ['site/login'],['title'=> 'Standings']); ?>
											<?php } else { ?>	
												<?php echo Html::a(Yii::t('yii', 'Standings'), ['site/standings?parentCity=1&subCity=1'],['title'=> 'Standings']); ?>
											<?php } ?>		
										</li>
										
										<li class="<?php echo $priz; ?>">
											<?php echo Html::a(Yii::t('yii', 'Prizes'), ['cms/page/prizes'],['title'=> 'Prizes']); ?>
										</li>
										
										<li class="<?php echo $vot; ?>">
											<?php echo Html::a(Yii::t('yii', 'Vote'), ['cms/page/vote'],['title'=> 'Vote']); ?>
										</li>
										
										<li class="<?php echo $abut; ?>">
											<?php echo Html::a(Yii::t('yii', 'About Us'), ['cms/page/about'],['title'=> 'About Us']); ?>
										</li>
										<li class="<?php echo $faq; ?>">
											<?php echo Html::a(Yii::t('yii', 'FAQ'), ['site/faq'],['title'=> 'FAQ']); ?>
										</li>
										<li class="<?php echo $cs; ?>">
											<?php echo Html::a(Yii::t('yii', 'Contact Us'), ['site/contact-us'],['title'=> 'Contact Us']); ?>
										</li>
										<?php  if(Yii::$app->user->isGuest){ ?>
											<li class="<?php echo $lg; ?>">
												<?php echo Html::a(Yii::t('yii', 'Login'), ['site/login'],['title'=> 'Login']); ?>
											</li>
										<?php } ?>	
									</ul>
								</div>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>


		<?php } ?>	
        <?php echo $content; ?>
		<?php  if($actionId != 'landing') { ?>

<footer> 
	<div class="container">
		<div class="footer-2">
			<div class="row">
				<?php  	$mapData = Yii::$app->frontendmethods->mapInfo();  
						if( $mapData ) {
				?>
					<div class="col-md-4 col-sm-4 col-xs-12 pull-right">
						<div class="footer-right">
							<?php echo  $mapData['pageContent'];  ?>
						</div>
					</div>
				<?php } ?>	
				<div class="col-md-8 col-sm-8 col-xs-12">
					<div class="footer-left">
						<div class="row">
							<?php  	$footerContactInfo = Yii::$app->frontendmethods->footerContactInfo();  
									if( $footerContactInfo ) {
							?>
								<div class="col-md-6 col-sm-6 col-xs-6 full">
									<div class="footer-contact">
										<h4>Contact Us</h4>
											<?php echo  $footerContactInfo['pageContent'];  ?>
									</div>
								</div>
							<?php 	 }   ?>
							<div class="col-md-6 col-sm-6 col-xs-6 full">
								<div class="footer-contact">
									<h4>Locate Us</h4>
									<p>Smooth Promotions Nigeria Limited.<br>
									4, Ogundana Street<br>
									Off Allen Avenue, Ikeja<br>
									Lagos, Nigeria</p>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="footer-nav-main">
									<div class="footer-nav">
										<ul>
											<li class="<?php echo $hp; ?>">
												<?php echo Html::a(Yii::t('yii', 'Home'), ['site/home'],['title'=> 'Home']); ?>
											</li>
											<li class="<?php echo $std; ?>">
											<?php  if(Yii::$app->user->isGuest){ ?>
												<?php echo Html::a(Yii::t('yii', 'Standings'), ['site/login'],['title'=> 'Standings']); ?>
											<?php } else { ?>	
												<?php echo Html::a(Yii::t('yii', 'Standings'), ['site/standings?parentCity=1&subCity=1'],['title'=> 'Standings']); ?>
											<?php } ?>		
											</li>
											<li class="<?php echo $priz; ?>">
												<?php echo Html::a(Yii::t('yii', 'Prizes'), ['cms/page/prizes'],['title'=> 'Prizes']); ?>
											</li>
										
											<li class="<?php echo $vot; ?>">
												<?php echo Html::a(Yii::t('yii', 'Vote'), ['cms/page/vote'],['title'=> 'Vote']); ?>
											</li>
										
											<li class="<?php echo $abut; ?>">
												<?php echo Html::a(Yii::t('yii', 'About Us'), ['cms/page/about'],['title'=> 'About Us']); ?>
											</li>
											<li class="<?php echo $faq; ?>">
												<?php echo Html::a(Yii::t('yii', 'FAQ'), ['site/faq'],['title'=> 'FAQ']); ?>
											</li>
											<li class="<?php echo $cs; ?>">
												<?php echo Html::a(Yii::t('yii', 'Contact Us'), ['site/contact-us'],['title'=> 'Contact Us']); ?>
											</li>
										</ul>
									</div>
									<div class="social-nav">
										<ul>
											<li class="facebookfooter"><a href="javascript:void(0)" title="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
											<li class="twiterfooter"><a href="javascript:void(0)" title="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
											<li class="instagramfooter"><a href="javascript:void(0)" title="instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
											<li class="youtubefooter"><a href="javascript:void(0)" title="youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="footer-bottom">
									<p>© Copyright 2017. All rights reserved.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<!-- END FOOTER --> 
<script> 
$( ".choose-city-inner p.subCitiesCheck" ).click(function() {
	var confirmClass = $(this).hasClass("active");
	if (confirmClass == true) {
		$(this).removeClass("active");
	} else {
			$(this).addClass("active");
	}
	$(this).parent().find( "ul" ).slideToggle( "slow", function() {
  });
});	
	
	
	
//~ $( ".choose-city-inner p.Lagos" ).click(function() {
	//~ alert('p');
	//~ var confirmClass = $(this).hasClass("active");
	//~ if (confirmClass == true) {
		//~ $(this).removeClass("active");
	//~ } else {
			//~ $(this).addClass("active");
	//~ }
	//~ 
  //~ $( ".choose-city-inner ul.Lagos-ul" ).slideToggle( "slow", function() {
    //~ // Animation complete.
  //~ });
//~ });
</script> 
<script> 
$( ".choose-city-inner p.Ibadan" ).click(function() {
	var confirmClass = $(this).hasClass("active");
	if (confirmClass == true) {
		$(this).removeClass("active");
	} else {
			$(this).addClass("active");
	}
  $( ".choose-city-inner ul.Ibadan-ul" ).slideToggle( "slow", function() {
    // Animation complete.
  });
});
</script> 
<script> 
$( ".choose-city-inner p.Benin" ).click(function() {
	var confirmClass = $(this).hasClass("active");
	if (confirmClass == true) {
		$(this).removeClass("active");
	} else {
			$(this).addClass("active");
	}
  $( ".choose-city-inner ul.Benin-ul" ).slideToggle( "slow", function() {
    // Animation complete.
  });
});
</script> 
<script> 
$( ".choose-city-inner p.Harcourt" ).click(function() {
	var confirmClass = $(this).hasClass("active");
	if (confirmClass == true) {
		$(this).removeClass("active");
	} else {
			$(this).addClass("active");
	}
  $( ".choose-city-inner ul.Harcourt-ul" ).slideToggle( "slow", function() {
    // Animation complete.
  });
});
</script> 
<script> 
$( ".choose-city-inner p.Jos" ).click(function() {
	var confirmClass = $(this).hasClass("active");
	if (confirmClass == true) {
		$(this).removeClass("active");
	} else {
			$(this).addClass("active");
	}
  $( ".choose-city-inner ul.Jos-ul" ).slideToggle( "slow", function() {
    // Animation complete.
  });
});
</script> 
<script> 
$( ".choose-city-inner p.Abuja" ).click(function() {
  $( ".choose-city-inner ul.Abuja-ul" ).slideToggle( "slow", function() {
    // Animation complete.
  });
});
</script> 
<script> 
$( ".choose-city-inner p.Enugu" ).click(function() {
	var confirmClass = $(this).hasClass("active");
	if (confirmClass == true) {
		$(this).removeClass("active");
	} else {
			$(this).addClass("active");
	}
  $( ".choose-city-inner ul.Enugu-ul" ).slideToggle( "slow", function() {
    // Animation complete.
  });
});
</script> 
<script> 
$( ".choose-city-inner p.Calabar" ).click(function() {
	var confirmClass = $(this).hasClass("active");
	if (confirmClass == true) {
		$(this).removeClass("active");
	} else {
			$(this).addClass("active");
	}
  $( ".choose-city-inner ul.Calabar-ul" ).slideToggle( "slow", function() {
    // Animation complete.
  });
});
</script>
<?php } ?>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
