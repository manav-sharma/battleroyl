<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use backend\models\comments\UpdateComments;
$updateComments = new UpdateComments();
$postitle = $updateComments->postName($model->post_id);
$userName = $updateComments->userName($model->user_id);
$fulname = $userName['firstname'].' '.$userName['lastname'];
?>
<script type="text/javascript" src="<?php echo Url :: Home(); ?>/themes/gentelella/js/tiny_mce/tinymce.js"></script>
<script type="text/javascript" src="<?php echo Url :: Home(); ?>/themes/gentelella/js/tiny_mce/addediter.js"></script>
<div class="x_content">
<!--
    <p class="mandatory-fields">All fields are mandatory:</p>
-->
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
		echo $form->field($model, 'user_id', ['inputOptions' => [
				'placeholder' => 'Username',
				'class' => "form-control col-md-7 col-xs-12",
				'readOnly'=>true,
				'value' => $fulname, 
		]])->textInput()->label('Username');
    ?>
    <?php
		echo $form->field($model, 'post_id', ['inputOptions' => [
				'placeholder' => 'Postname',
				'readOnly'=>true,
				'class' => "form-control col-md-7 col-xs-12",
				'value' => $postitle['name'], 
		]])->textInput()->label('Postname');
    ?>
    <?php
		echo $form->field($model, 'comment_description', ['inputOptions' => [
				'placeholder' => 'Comment Description',
				'class' => "form-control col-md-7 col-xs-12",
		]])->textarea(['rows' => 5,'autofocus' => true])->label('Comment Description <span class="required">*</span>');
    ?>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <button type="button" class="btn btn-primary" onclick="window.history.go(-1); return false;">Cancel</button>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'name' => 'AddBanner-submit', 'id' => 'AddBanner-submit']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
</div>
