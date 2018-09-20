<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\db\Query;
use  yii\web\Session;
$this->title = 'Seasons';
$siteimage = Yii::getAlias('@siteimage');
$siteUrl = Yii::getAlias('@basepath');
$banner = Yii::$app->frontendmethods->frontendbannerhome();
if(!empty(Yii::$app->getRequest()->getQueryParam('parentCity'))) {
	$parenCity 		= 	Yii::$app->getRequest()->getQueryParam('parentCity');
} else {
	$parenCity = 0;
}
if(!empty(Yii::$app->getRequest()->getQueryParam('subCity'))) {
	$subCity   		=  	Yii::$app->getRequest()->getQueryParam('subCity');
} else {
	$subCity = 0;
}
$session = Yii::$app->session;
$userid = Yii::$app->user->id;

if(empty($userid)) {
	$session->set('parenCity', $parenCity);
	$session->set('subCity', $subCity);
}
//echo '<pre>'; print_r($_SESSION);


?>
<section class="innerBanner defineFloat">
	<div class="bannerThumb">
		<div class="container">
			<div class="col-xs-12">
				<div class="bannerText">
					<h1 class="whiteText upperText"><?php echo $this->title; ?></h1>
				</div>
			</div>
		</div>
	</div>
</section>


	<section class="contentArea defineFloat" id="colorBg">
		<div class="container">
			<div class="row">
				<?php if(!empty($season)) {  ?>
					<div class="col-xs-12 paddingbot40">
						<h3><?php  echo $season['season_name'];    ?></h3>
						<div class="redText"><span><?php  echo $season['season_year'];    ?></span></div>
						<p><?php  echo $season['season_description'];    ?></p>
					</div>
					<div class="col-md-8 col-sm-8 col-xs-12">
					<div class="auditionBlk defineFloat"> <span>Audition venue </span>
<!--
						<ul>
							<li>Smooth Promotions Nigeria Limited.<br>
							4, Ogundana Street<br>
							Off Allen Avenue, Ikeja<br>
							Lagos, Nigeria</li>
							<li><i class="fa fa-phone" aria-hidden="true"></i> +234 818 811 1501</li>
						</ul>
-->
						<?php  echo $season['season_venue'];    ?>
					</div>
				</div>
					<div class="col-md-offset-1 col-md-3 col-sm-4 col-xs-12">
					<div class="seasonList">
						<?php  if(Yii::$app->user->isGuest){ ?>
							<ul>
								<li><?php echo Html::a(Yii::t('yii', 'View contestants'), ['site/login'],['title'=> 'View contestants']); ?> <i class="fa fa-angle-right" aria-hidden="true"></i> </li>
								<li><?php echo Html::a(Yii::t('yii', 'View Leader Board'), ['site/login'],['title'=> 'View Leader Board']); ?> <i class="fa fa-angle-right" aria-hidden="true"></i> </li>
								<li><?php echo Html::a(Yii::t('yii', 'Archives'), ['site/login'],['title'=> 'Archives']); ?> <i class="fa fa-angle-right" aria-hidden="true"></i> </li>
							</ul>
						<?php }  else {  ?>
							<ul>
								<li><?php echo Html::a(Yii::t('yii', 'View contestants'), ['site/viewcontestant?season_id='.$season['season_id']],['title'=> 'View contestants']); ?> <i class="fa fa-angle-right" aria-hidden="true"></i> </li>
								<li><?php echo Html::a(Yii::t('yii', 'View Leader Board'), ['site/viewleaderboard?season_id='.$season['season_id']],['title'=> 'View Leader Board']); ?> <i class="fa fa-angle-right" aria-hidden="true"></i> </li>
								<li><?php echo Html::a(Yii::t('yii', 'Archives'), ['site/archives?parentCity='.$parenCity .'&subCity='.$subCity],['title'=> 'Archives']); ?> <i class="fa fa-angle-right" aria-hidden="true"></i>  </li>
							</ul>
							
						<?php } ?>		
					</div>
				</div>
				<?php }  else { ?>
					<div class="col-xs-12 paddingbot40">
						<h3>No Season is going on for the selected region!!</h3>
						<div class="col-md-3">
							<div class="seasonList">
								<ul>
									<?php  if(Yii::$app->user->isGuest){ ?>
										<li><?php echo Html::a(Yii::t('yii', 'Archives'), ['site/login'],['title'=> 'Archives']); ?> <i class="fa fa-angle-right" aria-hidden="true"></i> </li>
									<?php } else { ?>	
										<li><?php echo Html::a(Yii::t('yii', 'Archives'), ['site/archives?parentCity='.$parenCity .'&subCity='.$subCity],['title'=> 'Archives']); ?> <i class="fa fa-angle-right" aria-hidden="true"></i>  </li>
									<?php } ?>	
								</ul>	
							</div>
						</div>	
					</div>
				<?php } ?>	
			</div>
		</div>
	</section>
