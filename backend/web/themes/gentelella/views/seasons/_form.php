<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

//echo '<pre>'; print_r($model);

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

      
    <?php
		echo $form->field($model, 'season_name', ['inputOptions' => [
				'placeholder' => 'Season Name',
				'class' => "form-control col-md-7 col-xs-12",
		]])->textInput()->label('Season Name <span class="required">*</span>');
    ?>
    
    <?php
        $currentYear = date('Y');
		echo $form->field($model, 'season_year', ['inputOptions' => [
				'placeholder' => 'Season Year',
				'class' => "form-control col-md-7 col-xs-12",
		]])->textInput(['readonly' => true, 'value' => $currentYear])->label('Season Year <span class="required">*</span>');
    ?>
    
    
    <?php
    $parentCity = ArrayHelper::map(\common\models\Maincity::find()->all(), 'main_city_id','main_city_name');
   
    echo $form->field($model, 'seasonMainCity_Id')->dropDownList($parentCity, ['prompt'=>'Select Parent City', 'id'=>'parentCityID'])->label('Select Parent City <span class="required">*</span>');
    ?>
    
    <?php   
    $subCity = ArrayHelper::map(common\models\Subcity::find()->where(['=','main_city_id', $model->seasonMainCity_Id])->all(), 'sub_city_id', 'sub_city_name');
    
	echo $form->field($model, 'seasonSubCity_Id')->dropDownList($subCity, ['prompt'=>'Select Sub City', 'id'=>'subCityId'])->label('Select Sub City ');
    ?>
    <?php  
		echo $form->field($model, 'cityHiddenValue')->hiddenInput(['value'=> '1'])->label(false);
    ?>

    <?php
		echo $form->field($model, 'season_venue', ['inputOptions' => [
				'class' => "form-control col-md-7 col-xs-12",
			]])->textarea(['rows' => 6])->label('Season Venue  <span class="required">*</span>');
	?>							

    <?php
		echo $form->field($model, 'status')->dropdownList([0 => 'Inactive', 1 => 'Open',2 => 'Close',],['prompt'=>'Select Season Staus'])->label('Season Status <span class="required">*</span>'); 
	?>
    <?php
		echo $form->field($model, 'season_description', ['inputOptions' => [
				'placeholder' => 'Season Description',
				'class' => "form-control col-md-7 col-xs-12",
		]])->textarea(['rows' => 5])->label('Season Description <span class="required">*</span>');
    ?>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <button type="button" class="btn btn-primary" onclick="window.history.go(-1); return false;">Cancel</button>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'name' => 'AddBanner-submit', 'id' => 'AddBanner-submit']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
</div>


<script>
$(document).ready(function(){
   $('#parentCityID').on('change',function(){
        $("#subCityId").find("option:gt(0)").remove();
        var parentID = $(this).val();
        if(parentID != '') {
			$("#subCityId").find("option:first").text("Loading...");
			$.ajax({
					type:'POST',
					url:'<?php echo Url::to(['seasons/getsubcities'], true); ?>',
					data:'id='+parentID,
					success:function(json){
					   $("#subCityId").find("option:first").text("Select Sub City");
						for (var i = 0; i < json.length; i++) {
							$("<option/>").attr("value", json[i].sub_city_id).text(json[i].sub_city_name).appendTo($("#subCityId"));
						}
						if(json != ''){
							$("#addseasons-cityhiddenvalue").val("2");
						} else {
							$("#addseasons-cityhiddenvalue").val("1");
						}
					}
			});
		}	
    });
});
</script>

