<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

if(Yii::$app->controller->action->id == 'update') {
	$mName = 'UpdateContestant';
} else {
	$mName = 'AddContestant';
}
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
    <?php echo'<input type="hidden" name="'.$mName.'[client_side_removed_images]" id="removed_images" value="" />'; ?>

    <?php echo $form->field($modelImageUpload, 'contestant_image[]')->fileInput(['multiple' => true,"accept"=>"image/*"])->label('Image uploads'); 
   // echo '<pre>'; print_r($mediaArr['contestant_image']);
    echo'<span id="result" class="client_image">';	
			if(isset($mediaArr['contestant_image'])) {
				foreach($mediaArr['contestant_image'] as $img) {
					echo "<span class='".$img->contestant_detail_id."'><img src='".SITE_URL."common/uploads/contestant/".$img->contestant_image."' width='60' height='60' /> <span id='".$img->contestant_detail_id."' class='mediaKey glyphicon glyphicon-trash'></span> </span>";
				}
			}
		echo'</span>';
    
    ?>    
    <?php
		echo $form->field($model, 'contestant_name', ['inputOptions' => [
				'placeholder' => 'Contestant Name',
				'class' => "form-control col-md-7 col-xs-12",
		]])->textInput()->label('Name <span class="required">*</span>');
    ?>
    <?php
		echo $form->field($model, 'contestant_description', ['inputOptions' => [
				'placeholder' => 'Contestant Description',
				'class' => "form-control col-md-7 col-xs-12",
		]])->textarea(['rows' => 5])->label('Description <span class="required">*</span>');
    ?>
    
    <?php
		echo $form->field($model, 'contestant_votes', ['inputOptions' => [
				'placeholder' => 'Votes',
				'class' => "form-control col-md-7 col-xs-12",
		]])->textInput()->label('Contestant Votes <span class="required">*</span>');
    ?>
    
    
    <?php
		echo $form->field($model, 'result')->dropdownList([0 => 'Participant', 1 => 'Winner',2 => '1st Runner up',3 => '2nd Runner up'],['prompt'=>'Select Participant Result Staus'])->label('Participant Result <span class="required">*</span>'); 
	?>
    
    
    <?php
		echo $form->field($model, 'status')->dropdownList([1 => 'Active', 2 => 'Inactive'],['prompt'=>'Select Contestant Staus'])->label('Contestant Status <span class="required">*</span>'); 
	?>
	
	<?php
	    $seasons= ArrayHelper::map(\backend\models\seasons\Seasons::find()->all(), 'season_id','season_name');
	
		echo $form->field($model, 'season_id')->dropDownList($seasons, ['prompt'=>'Select Season ', 'id'=>'seasonID'])->label('Select Season <span class="required">*</span>');	
	?>
    
    <?php
		echo $form->field($model, 'contestant_youtubelink', ['inputOptions' => [
				'placeholder' => 'Enter Youtubelinks https://www.youtube.com/watch?v=9xwazD5SyVg,https://www.youtube.com/watch?v=ScMzIvxBSi4',
				'class' => "form-control col-md-7 col-xs-12",
		]])->textarea(['rows' => 5])->label('Contestant Youtube Links <span class="required">*</span>');
    ?>
    
    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <button type="button" class="btn btn-primary" onclick="window.history.go(-1); return false;">Cancel</button>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'name' => 'AddBanner-submit', 'id' => 'AddBanner-submit']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
</div>
