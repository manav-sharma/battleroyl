<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

if(Yii::$app->controller->action->id == 'update') {
	$mName = 'UpdateProperties';
	$model->reference_number= $model->reference_number;
} else {
	$mName = 'AddProperties';
	$model->reference_number = mt_rand(100000, 999999);
}
?>
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
		echo'<input type="hidden" id="removed_images_contr" value="0" />';
		echo'<input type="hidden" id="removed_documents_contr" value="0" />';
		echo'<input type="hidden" name="'.$mName.'[client_side_removed_images]" id="removed_images" value="" />';
		echo'<input type="hidden" name="'.$mName.'[client_side_removed_documents]" id="removed_documents" value="" />';
		echo'<span class="auction">';
			echo $form->field($model, 'auction')->checkbox(['Yes' => '<span>Whether an auction or not</span>'])->label('<span>Whether an auction or not</span>');
		echo'</span>';

		echo $form->field($modelImageUpload['modelImgD'], 'upload_images[]',[
				'template' => "<div class=\"item form-group\">\n{label}\n<div class=\"col-md-3 col-sm-3 col-xs-6\">{input}<div class=\"col-lg-10\">{error}</div></div><div class=\"col-md-3 col-sm-3 col-xs-6\">Press control to choose multiple images</div></div>"
			])->fileInput(['multiple' => true,"accept"=>"image/*"])->label('Upload Images');
		echo'<span id="result" class="client_image">';	
			if(isset($mediaArr['images'])) {
				foreach($mediaArr['images'] as $img) {
					echo "<span class='".$img->id."'><img src='".SITE_URL."common/uploads/properties/".$img->name."' width='60' height='60' /> <span id='".$img->id."' class='mediaKey glyphicon glyphicon-trash'></span> </span>";
				}
			}
		echo'</span>';
		
		echo $form->field($modelImageUpload['modelImgA'], 'upload_documents[]',[
				'template' => "<div class=\"item form-group\">\n{label}\n<div class=\"col-md-3 col-sm-3 col-xs-6\">{input}<div class=\"col-lg-10\">{error}</div></div><div class=\"col-md-3 col-sm-3 col-xs-6\">Press control to choose multiple documents</div></div>"
			])->fileInput(['multiple' => true,"accept"=>".doc, .docx, .txt, .ppt, .csv, .xls"])->label('Upload documents');
		echo'<span id="resultdoc" class="client_image">';
		if(isset($mediaArr['documents'])) {
			foreach($mediaArr['documents'] as $doc) {
				echo "<span class='".$doc->id."'>".$doc->name." <span id='".$doc->id."' class='mediaKey glyphicon glyphicon-trash'></span> </span>";
			}
		}
		echo'</span>';
		echo $form->field($modelImageUpload['modelImgB'], 'upload_video',[
				'template' => "<div class=\"item form-group\">\n{label}\n<div class=\"col-md-3 col-sm-3 col-xs-6\">{input}<div class=\"col-lg-10\">{error}</div></div><div class=\"col-md-3 col-sm-3 col-xs-6\">Maximum allowed size is 2MB</div></div>"
			])->fileInput(["accept"=>".mp4"])->label('Upload video');
		if(isset($mediaArr['video']['name'])) {
				echo "<span class='".$mediaArr['video']['id']."'><video width='200' height='120' controls><source src='".SITE_URL."common/uploads/properties/".$mediaArr['video']['name']."' type='video/mov'>Your browser</video> <span id='".$mediaArr['video']['id']."' class='mediaKey glyphicon glyphicon-trash'></span></span>";
		}

		echo $form->field($modelImageUpload['modelImgC'], 'upload_viewvideo',[
				'template' => "<div class=\"item form-group\">\n{label}\n<div class=\"col-md-3 col-sm-3 col-xs-6\">{input}<div class=\"col-lg-10\">{error}</div></div><div class=\"col-md-3 col-sm-3 col-xs-6\">Maximum allowed size is 5MB</div></div>"
			])->fileInput(["accept"=>".mp4"])->label('Upload 360 video');
		if(isset($mediaArr['viewvideo']['name'])) {
				echo "<span class='".$mediaArr['viewvideo']['id']."'><video width='200' height='120' controls><source src='".SITE_URL."common/uploads/properties/".$mediaArr['viewvideo']['name']."' type='video/mov'>Your browser</video> <span id='".$mediaArr['viewvideo']['id']."' class='mediaKey glyphicon glyphicon-trash'></span></span>";
		}

		echo $form->field($modelImageUpload['modelImgE'], 'upload_dview_video',[
				'template' => "<div class=\"item form-group\">\n{label}\n<div class=\"col-md-3 col-sm-3 col-xs-6\">{input}<div class=\"col-lg-10\">{error}</div></div><div class=\"col-md-3 col-sm-3 col-xs-6\">Maximum allowed size is 5MB</div></div>"
			])->fileInput(["accept"=>".mp4"])->label('Upload 3D Video'); 
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

		echo $form->field($model, 'address', ['inputOptions' => [
				'placeholder' => 'address',
				'class' => "form-control col-md-7 col-xs-12",
		]])->textInput(['autofocus' => true])->label('Address <span class="required">*</span>');

			 $countries = Yii::$app->commonmethod->countries();
		echo $form->field($model, 'country')->dropDownList($countries,['prompt'=>'Select Country'])->label('Country <span class="required">*</span>');

			 $states = Yii::$app->commonmethod->regions();
		echo $form->field($model, 'region')->dropDownList($states,['prompt'=>'Select Region'])->label('Region <span class="required">*</span>');

			 $cities = Yii::$app->commonmethod->cities();
		echo $form->field($model, 'city')->dropDownList($cities,['prompt'=>'Select City'])->label('City <span class="required">*</span>');

			 $myear = Yii::$app->commonmethod->propertyBuildYear();
		echo $form->field($model, 'build_year')->dropDownList($myear,['prompt'=>'Select Year'])->label('Build year <span class="required">*</span>');

		echo $form->field($model, 'area', ['inputOptions' => [
				'placeholder' => 'area',
				'class' => "form-control col-md-7 col-xs-12",
		]])->textInput(['autofocus' => true])->label('Area (sq m2) <span class="required">*</span>');

			 $rooms = Yii::$app->commonmethod->propertyRooms();
		echo $form->field($model, 'rooms')->dropDownList($rooms,['prompt'=>'Select Rooms'])->label('Rooms <span class="required">*</span>');

			 $floors = Yii::$app->commonmethod->propertyFloors();
		echo $form->field($model, 'floors')->dropDownList($floors,['prompt'=>'Select Floors'])->label('Floors <span class="required">*</span>');

//			 $prices = Yii::$app->commonmethod->propertyPrices();
//		echo $form->field($model, 'price')->dropDownList($prices,['prompt'=>'Select Price'])->label('Price <span class="required">*</span>');

		echo $form->field($model, 'price', ['inputOptions' => [
				'placeholder' => 'price',
				'class' => "form-control col-md-7 col-xs-12",
		]])->textInput(['autofocus' => true])->label('Price <span class="required">*</span>');		

		echo $form->field($model, 'specification', ['inputOptions' => [
				'placeholder' => 'specification',
				'class' => "form-control col-md-7 col-xs-12",
		]])->textarea(['rows' => 5,'autofocus' => true])->label('Specification <span class="required">*</span>');
		
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
