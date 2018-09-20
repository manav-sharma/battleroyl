<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\db\Query;
$this->title = 'Contact Us';
$siteimage = Yii::getAlias('@siteimage');
$siteUrl = Yii::getAlias('@basepath');
$siteUrl = Yii::getAlias('@basepath');
$contactInfo = Yii::$app->frontendmethods->contactinfo();
//echo '<pre>'; print_r($contactInfo['pageContent'] );
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
			<div class="col-md-6 col-sm-6 col-xs-12 rightPadding">
				<div class="addressBlk">
					<?php if(isset($contactInfo['pageContent']) && !empty($contactInfo['pageContent'])) { ?>
					<h3 class="whiteText">Address</h3>
						<?php echo $contactInfo['pageContent']; ?>
					<?php } ?>
					<div class="social">
						<ul>
							<li><a href="javascript:void(0)" title="facebook"><i class="fa fa-facebook" aria-hidden="true"></i> </a></li>
							<li><a href="javascript:void(0)" title="twiter"><i class="fa fa-twitter" aria-hidden="true"></i> </a></li>
							<li><a href="javascript:void(0)" title="instagram"><i class="fa fa-instagram" aria-hidden="true"></i> </a></li>
							<li><a href="javascript:void(0)" title="youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i> </a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12 leftPadding">
				<div class="formOuter">
					<h3>Have a question or query?</h3>
					<?php if (Yii::$app->session->getFlash('message')): ?>                                    
                                    <div class="alert alert-grey alert-dismissible">
                                       <button type="button" class="close" data-dismiss="alert">
                                          <span aria-hidden="true">&times;</span>
                                       </button>
                                    <i class="glyphicon glyphicon-ok"></i> <?php echo Yii::$app->session->getFlash('message'); ?>
                                    </div>                                           
                                 <?php endif; ?>
								<?php
									$form = ActiveForm::begin(
                                    [
                                        'id' => 'contactUsForm',
                                        'options' => [
                                            'enctype' => 'multipart/form-data',
                                           // 'class' => 'inner',
                                            'tag' => 'span', ####THIS OPTIONS DISABLES THE DIV.FORM_GROUP ENCLOSER TAG FOR FIELDS
                                        ],
                                        'fieldConfig' => [
												 'template' => "
												 {label}\n
												 {input}
													<div class=\"col-xs-12\">
													   <label></label>{error} {hint}
													</div>",
													   ],
													]
											  );
								?> 
						<div class="form-group">
							<?php  echo $form->field($model, 'yourname', ['inputOptions' => [
									'class' => "form-control",
									]])->textInput()->label('Your name *');
							?>
						</div>
						<div class="form-group">
							<?php  echo $form->field($model, 'email', ['inputOptions' => [
									'class' => "form-control",
									]])->textInput()->label('Email address *');
							?>
						</div>
						<div class="form-group">
							<?php  echo $form->field($model, 'phone', ['inputOptions' => [
									'class' => "form-control",
									]])->textInput()->label('Phone *');
							?>
						</div>
						<div class="form-group">
							<?php
									echo $form->field($model, 'message', ['inputOptions' => [
									'class' => "form-control",
									]])->textarea(['rows' => 3])->label('Message *');
							?>	
						</div>
						
						<div class="capcha"> 
							<?php echo $form->field($model, 'reCaptcha')->widget(\yii\recaptcha\ReCaptcha::className(),['siteKey' => SITE_KEY])->label(false); ?> 
						</div>
						<div class="button">
							<?= Html::submitButton('Submit', ['class' => 'btn black', 'name' => 'contactus-Submit', 'id' => 'contactus-submit']) ?>
						</div>
					 <?php ActiveForm::end(); ?>
				</div>
			</div>
		</div>
	</div>
</section>
<script src='https://www.google.com/recaptcha/api.js'></script>
