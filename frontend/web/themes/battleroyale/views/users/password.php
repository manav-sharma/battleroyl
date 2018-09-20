<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\db\Query;

$this->title = 'Change Password';
$siteimage = Yii::getAlias('@siteimage');
$siteUrl = Yii::getAlias('@basepath');

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
				<?php echo  $this->render('left-menu'); ?>
			</div>
			<div class="col-md-6 col-sm-8 col-xs-12">
				<div class="formOuter profilOeuter">
					<?php if (Yii::$app->session->getFlash('item')): ?>
						  <div class="col-xs-12">
							 <div class="alert alert-grey alert-dismissible">
								   <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
								   </button>
								   <i class="glyphicon glyphicon-ok"></i><?php echo Yii::$app->session->getFlash('item'); ?>
							 </div>
						  </div>																	
                    <?php endif; ?>
                    <?php
						$form = ActiveForm::begin(
						  [ 'id' => 'changePassword-form',
						  
						  'options' => [
						  'enctype' => 'multipart/form-data',
						  'tag' => 'span', ####THIS OPTIONS DISABLES THE DIV.FORM_GROUP ENCLOSER TAG FOR FIELDS
						  ],
						  'fieldConfig' => [
						  'template' => "<div class=\"\">\n
							 <div class=\"form-group\">\n
							 {label}\n
								<div class=\"val\">\n
								   <div class=\"controls\">
								   {input}
									  <div class=\"col-lg-12\">
									  <label></label>{error} {hint}
									  </div>
								   </div>
								   </div>
								</div>
							 </div>",
						  'labelOptions' => ['class' => ''],
						  'options' => [
						  'tag' => 'span', ####THIS OPTIONS DISABLES THE DIV.FORM_GROUP ENCLOSER TAG FOR FIELDS
						  'class' => '', ####DISABLE THE DEFAULT FORM_GROUP CLASS
						  ],
						  ],
						  ]
						);
					?>
						<div class="form-group">
							<?php
								echo $form->field($model, 'password', ['inputOptions' => ['class'=>'form-control','placeholder'=>'New Password'
								]])->passwordInput()->label('New Password <span class="required">*</span>');
							?>
<!--
							<label for="exampleInputEmail1">New Password *</label>
							<input type="email" class="form-control" id="exampleInputEmail1" placeholder="New Password">
-->
						</div>
						<div class="form-group">
							<?php
								echo $form->field($model, 'repeat_password', ['inputOptions' => ['class'=>'form-control','placeholder'=>'Confirm New Password'
								]])->passwordInput()->label('Confirm New Password<span class="required">*</span>');
							?>
<!--
							<label for="exampleInputEmail1">Confirm New Password*</label>
							<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Confirm new password">
-->
						</div>
						<div class="button"> <button class="btn btn-primary" name="changepassword">submit</button> </div>
					<?php ActiveForm::end(); ?> 
				</div>
			</div>
		</div>
	</div>
</section>
