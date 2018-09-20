<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
?>
<div class="x_content">
    <p class="mandatory-fields">All fields are mandatory:</p>
    <?php
    if(Yii::$app->controller->action->id == 'update')
        $modelName = 'UpdateUser';
    else
        $modelName = 'AddUser';

		####################################################= user registration form =####################################################
		$form = ActiveForm::begin(
			['id' => 'form-createuser',
				'options' => ['class' => 'form-horizontal form-label-left', 'enctype' => 'multipart/form-data'],
				'fieldConfig' => [
					'template' => "<div class=\"item form-group\">\n
									{label}\n
									<div class=\"col-md-6 col-sm-6 col-xs-12\">
										{input}
										<div class=\"col-lg-10\">
										{error}
										</div>
									</div>
								</div>",
					'labelOptions' => ['class' => 'control-label col-md-3'],
				],
		]);
		
		################################################## user registration form fields =#################################################
		echo $form->field($modelImageUpload, 'profile_image')->fileInput()->label('Profile Image');

		echo $form->field($model, 'firstname', ['inputOptions' => [
			'placeholder' => 'First name',
			'class' => "form-control col-md-7 col-xs-12",
		]])->textInput(['maxlength' => 60, 'autofocus' => true])->label('First Name <span class="required">*</span>');

		echo $form->field($model, 'lastname', ['inputOptions' => [
			'placeholder' => 'Last name',
			'class' => "form-control col-md-7 col-xs-12",
		]])->textInput(['maxlength' => 60, 'autofocus' => true])->label('Last Name <span class="required">*</span>');

		echo $form->field($model, 'email', [
		'enableAjaxValidation' => true,
		'inputOptions' => [
			'placeholder' => 'Email',
			'class' => "form-control col-md-7 col-xs-12",
			'type' => "email",
		]])->textInput(['maxlength' => 100, 'autofocus' => true])->label('Email <span class="required">*</span>');
				
		echo $form->field($model, 'phone', ['inputOptions' => [
			'placeholder' => 'Phone',
			'class' => "form-control col-md-7 col-xs-12",
		]])->textInput(['maxlength' => 15, 'autofocus' => true])->label('Phone <span class="required">*</span>');
		
		
		echo $form->field($model, 'address', ['inputOptions' => [
				'placeholder' => 'Address',
				'class' => "form-control col-md-7 col-xs-12",
		]])->textarea(['rows' => 5,'autofocus' => true])->label('Address <span class="required">*</span>');
		
		
		echo $form->field($model, 'password', ['inputOptions' => [
			'placeholder' => 'Password',
			'data-validate-length-range' => "6,8",
			'class' => "form-control col-md-7 col-xs-12",
		]])->passwordInput(['maxlength' => 10])->label('Password <span class="required">*</span>');

		echo $form->field($model, 'repeat_password', ['inputOptions' => [
			'placeholder' => 'Confirm Password',
			'class' => "form-control col-md-7 col-xs-12",
		]])->passwordInput(['maxlength' => 10])->label('Confirm Password <span class="required">*</span>');

    ?>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <button type="button" class="btn btn-primary" onclick="javascript:window.location.href = '<?php echo Url::home(); ?>'">Cancel</button>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'name' => 'AddUser-submit', 'id' => 'AddUser-submit']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>
</div>
