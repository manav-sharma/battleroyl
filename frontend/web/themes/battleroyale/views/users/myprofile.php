<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\db\Query;

$this->title = 'My Profile';
$siteimage = Yii::getAlias('@siteimage');
$siteUrl = Yii::getAlias('@basepath');
//~ if(Yii::$app->user->isGuest){
	//~ echo 'User is not logged!';
//~ } else {
	//~ echo 'User is loggedIN!';
//~ }
 
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
			<div class="col-md-3 col-sm-4 col-xs-12">
				<?php echo $this->render('left-menu'); ?>
			</div>
			<div class="col-md-9 col-sm-8 col-xs-12">
				<div class="row">
					<div class="col-md-9 col-sm-8 col-xs-12">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6">
								<div class="outerBlk">
									<p>First name</p>
									<span><?php echo $model->firstname;  ?></span>
								</div>
								<div class="outerBlk">
									<p>Email address</p>
									<span><?php echo $model->email;  ?></span> 
								</div>
								<?php if(!empty($model->address)) {  ?>
									<div class="outerBlk">
										<p>Address</p>
										<span><?php echo $model->address;  ?></span> 
									</div>
								<?php } ?>	
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<div class="outerBlk">
									<p>Last name</p>
									<span><?php echo $model->lastname;  ?></span> 
								</div>
								<?php if(!empty($model->phone)) {  ?>
									<div class="outerBlk">
										<p>Phone</p>
										<span><?php echo $model->phone;  ?></span> 
									</div>
								<?php } ?>	
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-4 col-xs-12">
						<div class="backBlk">
							<div class="button">
								<a href="<?php echo $siteUrl; ?>/users/settings">edit profile <i class="fa fa-pencil" aria-hidden="true"></i></a> 
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
