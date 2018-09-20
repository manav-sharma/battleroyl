<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

if(Yii::$app->controller->action->id == 'update') {
	$model->reference_number= $model->reference_number;
} else {
	$model->reference_number = mt_rand(100000, 999999);
}
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
		echo $form->field($model, 'auction')->checkbox(['Yes' => '<span>Whether an auction or not</span>']);
					  
		echo $form->field($modelImageUpload['modelImgA'], 'upload_documents[]')->fileInput(['multiple' => true])->label('Upload documents');
		if(isset($mediaArr['documents'])) {
			foreach($mediaArr['documents'] as $doc) {
				echo "<span class='".$doc->id."'>".$doc->name." <span id='".$doc->id."' class='mediaKey glyphicon glyphicon-trash'></span> </span>";
			}
		}

		echo $form->field($modelImageUpload['modelImgB'], 'upload_video')->fileInput()->label('Upload video');
		if(isset($mediaArr['video']['name'])) {
				echo "<span class='".$mediaArr['video']['id']."'><video width='200' height='120' controls><source src='".SITE_URL."common/uploads/properties/".$mediaArr['video']['name']."' type='video/mov'>Your browser</video> <span id='".$mediaArr['video']['id']."' class='mediaKey glyphicon glyphicon-trash'></span></span>";
		}

		echo $form->field($modelImageUpload['modelImgC'], 'upload_viewvideo')->fileInput()->label('Upload 360 video');
		if(isset($mediaArr['viewvideo']['name'])) {
				echo "<span class='".$mediaArr['viewvideo']['id']."'><video width='200' height='120' controls><source src='".SITE_URL."common/uploads/properties/".$mediaArr['viewvideo']['name']."' type='video/mov'>Your browser</video> <span id='".$mediaArr['viewvideo']['id']."' class='mediaKey glyphicon glyphicon-trash'></span></span>";
		}

		echo $form->field($modelImageUpload['modelImgD'], 'upload_images[]')->fileInput(['multiple' => true])->label('Upload Images');
		if(isset($mediaArr['images'])) {
			foreach($mediaArr['images'] as $img) {
				echo "<span class='".$img->id."'><img src='".SITE_URL."common/uploads/properties/".$img->name."' width='60' height='60' /> <span id='".$img->id."' class='mediaKey glyphicon glyphicon-trash'></span> </span>";
			}
		}

		echo $form->field($modelImageUpload['modelImgE'], 'upload_dview_video')->fileInput()->label('Upload 3D Video'); 
		if(isset($mediaArr['dview_video']['name'])) {
				echo "<span class='".$mediaArr['dview_video']['id']."'><video width='200' height='120' controls><source src='".SITE_URL."common/uploads/properties/".$mediaArr['viewvideo']['name']."' type='video/mov'>Your browser</video> <span id='".$mediaArr['dview_video']['id']."' class='mediaKey glyphicon glyphicon-trash'></span></span>";
		}

		echo $form->field($model, 'name', ['inputOptions' => [
				'placeholder' => 'name',
				'class' => "form-control col-md-7 col-xs-12",
		]])->textInput(['autofocus' => true])->label('Name <span class="required">*</span>');
		echo $form->field($model, 'reference_number', ['inputOptions' => [
				'placeholder' => 'reference number',
				'class' => "form-control col-md-7 col-xs-12",
				 'readOnly'=>true,
		]])->textInput(['autofocus' => true])->label('Reference Number <span class="required">*</span>');
			 $ptypes = Yii::$app->commonmethod->propertyTypes();
		echo $form->field($model, 'property_type')->dropDownList($ptypes,['prompt'=>'Property Type'])->label('Property type <span class="required">*</span>');		

			 $pfor = Yii::$app->commonmethod->propertyFor();
		echo $form->field($model, 'property_for')->dropDownList($pfor,['prompt'=>'Select Property'])->label('Property for <span class="required">*</span>');

			 $countries = Yii::$app->commonmethod->countries();
		echo $form->field($model, 'country')->dropDownList($countries,['prompt'=>'Select Country'])->label('Country <span class="required">*</span>');

			 $states = Yii::$app->commonmethod->regions();
		echo $form->field($model, 'region')->dropDownList($states,['prompt'=>'Select Region'])->label('Region <span class="required">*</span>');

			 $cities = Yii::$app->commonmethod->cities();
		echo $form->field($model, 'city')->dropDownList($cities,['prompt'=>'Select City'])->label('City <span class="required">*</span>');

			 $myear = Yii::$app->commonmethod->propertyBuildYear();
		echo $form->field($model, 'build_year')->dropDownList($myear,['prompt'=>'Select Year'])->label('Build year <span class="required">*</span>');

		echo $form->field($model, 'area_from', ['inputOptions' => [
				'placeholder' => 'area from',
				'class' => "form-control col-md-7 col-xs-12",
		]])->textInput(['autofocus' => true])->label('Area From <span class="required">*</span>');

		//~ echo $form->field($model, 'area_to', ['inputOptions' => [
				//~ 'placeholder' => 'area to',
				//~ 'class' => "form-control col-md-7 col-xs-12",
		//~ ]])->textInput(['autofocus' => true])->label('Area To <span class="required">*</span>');

			 $rooms = Yii::$app->commonmethod->propertyRooms();
		echo $form->field($model, 'rooms_min')->dropDownList($rooms,['prompt'=>'Select Rooms From'])->label('Min rooms <span class="required">*</span>');
		echo $form->field($model, 'rooms_max')->dropDownList($rooms,['prompt'=>'Select Rooms To'])->label('Max rooms <span class="required">*</span>');

			 $floors = Yii::$app->commonmethod->propertyFloors();
		echo $form->field($model, 'floors_min')->dropDownList($floors,['prompt'=>'Select Floors From'])->label('Min floors <span class="required">*</span>');
		echo $form->field($model, 'floors_max')->dropDownList($floors,['prompt'=>'Select Floors To'])->label('Max floors <span class="required">*</span>');

			 $prices = Yii::$app->commonmethod->propertyPrices();
		echo $form->field($model, 'price_min')->dropDownList($prices,['prompt'=>'Select Min Price'])->label('Min price <span class="required">*</span>');
		echo $form->field($model, 'price_max')->dropDownList($prices,['prompt'=>'Select Max Price'])->label('Max price <span class="required">*</span>');

		echo $form->field($model, 'specification', ['inputOptions' => [
				'placeholder' => 'specification',
				'class' => "form-control col-md-7 col-xs-12",
		]])->textInput(['autofocus' => true])->label('Specification <span class="required">*</span>');
		
			 $prights = Yii::$app->commonmethod->propertyRights();
		echo $form->field($model, 'property_right')->dropDownList($prights,['prompt'=>'Select Property Right'])->label('Property Right <span class="required">*</span>');
				
    ?>      
    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <button type="button" class="btn btn-primary" onclick="window.history.go(-1); return false;">Cancel</button>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'name' => 'AddBanner-submit', 'id' => 'AddBanner-submit']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
</div>
