<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
?>
<script type="text/javascript" src="<?php echo Url :: Home(); ?>/themes/gentelella/js/tiny_mce/tinymce.js"></script>
<script type="text/javascript" src="<?php echo Url :: Home(); ?>/themes/gentelella/js/tiny_mce/addediter.js"></script>
<div class="x_content">
    <p class="mandatory-fields">All fields are mandatory:</p>
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

    <?php //echo $form->field($modelImageUpload, 'image')->fileInput()->label('Image upload'); ?>    
    <?php
		echo $form->field($model, 'video_name', ['inputOptions' => [
				'placeholder' => 'Video Name',
				'class' => "form-control col-md-7 col-xs-12",
		]])->textInput()->label('Video Name<span class="required">*</span>');
    ?>
    <?php
		echo $form->field($model, 'youtubevideolink', ['inputOptions' => [
				'placeholder' => 'Youtube video link',
				'class' => "form-control col-md-7 col-xs-12",
		]])->textarea(['rows' => 5])->label('Youtube Video Link <span class="required">*</span>');
    ?>
    
    <?php
		echo $form->field($model, 'status')->dropdownList([1 => 'Active', 2 => 'Inactive'],['prompt'=>'Select Video Staus'])->label('Video Status <span class="required">*</span>'); 
	?>
    
    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <button type="button" class="btn btn-primary" onclick="window.history.go(-1); return false;">Cancel</button>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'name' => 'AddBanner-submit', 'id' => 'AddBanner-submit']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
</div>
