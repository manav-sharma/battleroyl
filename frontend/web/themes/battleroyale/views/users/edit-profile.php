<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\db\Query;

$this->title = 'Edit Profile';
$siteimage = Yii::getAlias('@siteimage');
$siteUrl = Yii::getAlias('@basepath');
//~ if(Yii::$app->user->isGuest){
	//~ echo 'User is not logged!';
//~ } else {
	//~ echo 'User is loggedIN!';
//~ }
//echo '<pre>'; print_r($model);
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
				<?php 
					echo $this->render('left-menu');
				?>
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
						  [ 'id' => 'editProfile-form',
						  
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
								echo $form->field($model, 'firstname', ['inputOptions' => ['class'=>'form-control'
								]])->textInput()->label('First Name <span class="required">*</span>');
							?>
						</div>
						<div class="form-group">
							<?php
								echo $form->field($model, 'lastname', ['inputOptions' => ['class'=>'form-control'
								]])->textInput()->label('Last Name <span class="required">*</span>');
							?>
						</div>
						<div class="form-group">
							<?php
								echo $form->field($model, 'email', ['inputOptions' => ['class'=>'form-control','readonly' => 'true'
								]])->textInput()->label('Email address <span class="required">*</span>');
							?>
						</div>
						<div class="form-group">
							<?php
								echo $form->field($model, 'phone', ['inputOptions' => ['class'=>'form-control'
								]])->textInput()->label('Phone no.');
							?>
						</div>
						<div class="form-group">
							<?php
								echo $form->field($model, 'address', ['inputOptions' => ['class'=>'form-control'
								]])->textInput()->label('Address');
							?>
						</div>
						<div class="fileBox">
							<div class="form-group">
								<label for="exampleInputFile">Change profile pic</label>
								<?php if(!empty($model->profile_image)) { ?>
									<div class="fileThumb">
										<img class="img-responsive" src="<?php  echo PROFILE_IMAGE_PATH.'/'.$model->profile_image; ?>" height="60" width="60" alt="">
									</div>
								<?php } ?>	
								<?php echo $form->field($modelImageUpload, 'profile_image')->fileInput()->label(false);?>
							</div>
						</div>
						<div class="button"> 
							<?php //Html::submitButton('submit', ['class' => 'btn btn-primary', 'name' => 'submit', 'id' => 'UpdateUser-submit']) ?>
							<button class="btn btn-primary">submit</button>
							</div>
					<?php ActiveForm::end(); ?> 
				</div>
			</div>
		</div>
	</div>
</section>
