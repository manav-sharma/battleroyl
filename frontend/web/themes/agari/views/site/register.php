<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Country;

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
$siteimage = Yii::getAlias('@siteimage');
?>
<section class="headinginner">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="centertext">
					<h1><?php echo $this->title; ?></h1>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="content">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-sm-12 col-md-offset-2 col-xs-12"> 
				<div class="standardForm">
				<?php
					$form = ActiveForm::begin(
						[ 'id' => 'frmAddUser',
						'options' => [
						'enctype' => 'multipart/form-data',
						'tag' => 'span', ####THIS OPTIONS DISABLES THE DIV.FORM_GROUP ENCLOSER TAG FOR FIELDS
						],
						'fieldConfig' => [
						'template' => "<div class=\"col-md-6\">\n
						{label}\n
						{input}
						<div class=\"col-lg-10\">
						{error} {hint}
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
				<div class="fullWidth">
					<div class="col-md-6">
						<img src="<?php echo $siteimage; ?>/facebook-signin.jpg">
					</div>
					<div class="col-md-6">
						<img src="<?php echo $siteimage; ?>/linked-signin.jpg">
					</div>
				</div>
				<div class="fullWidth">
					<div class="col-md-6">
						<img src="<?php echo $siteimage; ?>/twitter-signin.jpg">
					</div>
					<div class="col-md-6">
						<img src="<?php echo $siteimage; ?>/google-signin.jpg">
					</div>
				</div>
				<div class="fullWidth">
				<?php
					echo $form->field($model, 'firstname', ['inputOptions' => [
					'class' => "inputText",
					]])->textInput(['maxlength' => 40, 'autofocus' => true])->label('Name');
					echo $form->field($model, 'email', ['inputOptions' => [
					'class' => "inputText",
					]])->textInput(['maxlength' => 100, 'autofocus' => true])->label('Email');					
				?>  
				</div>
				<div class="fullWidth">
				<?php
					echo $form->field($model, 'password', ['inputOptions' => [
					'class' => "inputText",
					]])->passwordInput(['maxlength' => 10])->label('Password');

					echo $form->field($model, 'repeat_password', ['inputOptions' => [
					'class' => "inputText",
					]])->passwordInput(['maxlength' => 10])->label('Confirm Password');			
				?>  				   
				</div>
				<div class="fullWidth">
				<?php
					echo $form->field($model, 'phone', ['inputOptions' => [
					'class' => "inputText",
					]])->textInput(['maxlength' => 15, 'autofocus' => true])->label('Phone');
					$countries = Yii::$app->commonmethod->countries();
					echo $form->field($model, 'country',['inputOptions' => [
					'class' => "inputText",
					]])->dropDownList($countries,['prompt'=>'Select Country']);		
				?>
				</div>
				<div class="fullWidth">    
				<?php
					$states = Yii::$app->commonmethod->regions();
					echo $form->field($model, 'region',['inputOptions' => [
					'class' => "inputText",
					]])->dropDownList($states,['prompt'=>'Select Region']);

					$cities = Yii::$app->commonmethod->cities();
					echo $form->field($model, 'city',['inputOptions' => [
					'class' => "inputText",
					]])->dropDownList($cities,['prompt'=>'Select City']);	
				?>    				             
				</div>
				<div class="fullWidth"> 
				<?php
					$nationality = Yii::$app->commonmethod->countries();
					echo $form->field($model, 'nationality',['inputOptions' => [
					'class' => "inputText",
					]])->dropDownList($nationality,['prompt'=>'Select Nationality']);

					echo $form->field($model, 'residency_status', ['inputOptions' => [
					'class' => "inputText",
					]])->textInput(['maxlength' => 100])->label('Iqamah/Residency Status');
				?>   					             
				</div>
				<div class="fullWidth">
					<div class="col-xs-12">
						<label>Registration type</label>
						<div class="radioOuter">
							<?php
								$membershiplist = Yii::$app->frontendmethods->membershipPlans();
								$i=0;
								foreach($membershiplist as $plan) {
									$chk='';
									if($i==0)
										$chk='checked';
							?>
								<div class="radio">
									<input type="radio" name="AddUserForm[membership]" value="<?= $plan['id'] ?>" <?= $chk ?> />
									<span><?= $plan['name'] ?></span>
								</div>
							<?php 
								$i++; 
								} 
							?>
						</div>
					</div>
				</div>
				<div class="fullWidth">              
				<?php
					$usertype = Yii::$app->commonmethod->userTypes();
					echo $form->field($model, 'user_type', ['inputOptions' => [
					'class' => "inputText",
					]])->dropDownList($usertype,['prompt'=>'User Type']);
				?>  
				</div>
				<div class="fullWidth">
					<div class="col-xs-12">
						<div class="captcha"><img src="images/captcha.png" alt=""></div>
					</div>
				</div>
				<div class="fullWidth">
					<div class="col-xs-12">
						<?= Html::submitButton('Sign UP', ['class' => 'submit', 'name' => 'submit', 'id' => 'AddUser-submit']) ?>
					</div>
				</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
		<div class="col-md-2 col-sm-2 col-xs-2"></div>
		</div>
	</div>
</section>
