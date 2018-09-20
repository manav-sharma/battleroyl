<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\db\Query;

$this->title = 'Registration';
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
			<div class="col-md-10 col-sm-8 col-xs-12">
				<div class="formOuter profilOeuter">
					<?php
						$form = ActiveForm::begin(
							[ 'id' => 'frmAddUser',
							'options' => [
							'enctype' => 'multipart/form-data',
							'tag' => 'span', ####THIS OPTIONS DISABLES THE DIV.FORM_GROUP ENCLOSER TAG FOR FIELDS
							],
							'fieldConfig' => [
							'template' => "
							{label}\n
							{input}
							<div class=\"col-xs-12\">
							<label></label>{error} {hint}
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
					<?php if (Yii::$app->session->getFlash('item')): ?>
						<div class="col-xs-12">
							<div class="warning alert">
								<span class="pos">
									<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
									<?php echo Yii::$app->session->getFlash('item'); ?>
								</span>
							</div>
						</div>													
					<?php endif; ?>
						<div class="form-group">
							<?php  echo $form->field($model, 'firstname', ['inputOptions' => [
									'class' => "form-control",
									]])->textInput()->label('First name *');
							?>
						</div>
						<div class="form-group">
							<?php  echo $form->field($model, 'lastname', ['inputOptions' => [
									'class' => "form-control",
									]])->textInput()->label('Last name *');
							?>
						</div>
						
						<div class="form-group">
							<?php  echo $form->field($model, 'email', ['inputOptions' => [
									'class' => "form-control",
									]])->textInput()->label('Email address *');
							?>
						</div>
						
						<div class="form-group">
							<?php 	 echo $form->field($model, 'password', ['inputOptions' => [
									'class' => "form-control",
									]])->passwordInput(['maxlength' => 10])->label('Password *');
							?>
						</div>
						
						<div class="form-group">
							<?php 	 echo $form->field($model, 'repeat_password', ['inputOptions' => [
									'class' => "form-control",
									]])->passwordInput(['maxlength' => 10])->label('Confirm Password *');
							?>
						</div>
						<div class="button"> 
							<?php //Html::submitButton('submit', ['class' => 'btn btn-primary', 'name' => 'submit', 'id' => 'AddUser-submit']) ?>
							<button class="btn btn-primary">submit</button>

						</div>
					<?php ActiveForm::end(); ?>
				</div>
			</div>
		</div>
	</div>
</section>
