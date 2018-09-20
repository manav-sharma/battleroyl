<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
?>
<div class="x_content">
    <p>All fields are mandatory:</p>
    <?php
		$form = ActiveForm::begin(
						['id' => 'form-createuser',
							'options' => ['class' => 'form-horizontal form-label-left', 'enctype' => 'multipart/form-data'],
							'fieldConfig' => [
								'template' => "<div class=\"item form-group\">\n{label}\n<div class=\"col-md-6 col-sm-6 col-xs-12\">
								{input}<div class=\"col-lg-10\">
								{error}</div></div></div>",
								'labelOptions' => ['class' => 'control-label col-md-3'],
							],
		]);
    ?>

    <?php 
		echo $form->field($modelImageUpload, 'advertisement_image')->fileInput()->label('Advertisement Banner Image <span class="required">*</span>');  

		echo $form->field($model, 'name', ['inputOptions' => [
				'class' => "form-control col-md-7 col-xs-12",
		]])->textInput(['autofocus' => true])->label('Advertisement Name <span class="required">*</span>');

		$services = array("0"=>"Pending","1"=>"Approved","2"=>"Declined");
		echo $form->field($model, 'approved')->dropDownList($services)->label('Admin Approval <span class="required">*</span>');
    ?>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <button type="button" class="btn btn-primary" onclick="window.history.go(-1); return false;">Cancel</button>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'name' => 'AddAds-submit', 'id' => 'AddAds-submit-submit']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
</div>
