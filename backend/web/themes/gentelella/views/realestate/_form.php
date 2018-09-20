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
        $modelName = 'UpdateRealestate';
    else
        $modelName = 'AddRealestateForm';    
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

    <?php echo $form->field($modelDocumentUpload, 'filename')->fileInput()->label('File upload'); ?>
    <div class="form-group field-updatemember-<?php echo strtolower($modelName); ?>">
        <div class="item form-group">

            <label for="updatemember-<?php echo strtolower($modelName); ?>" class="control-label col-md-3">Category Name</label>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                $categories = backend\models\documentcategory\Documentcategory::find()->where(['status' => '1'])->select(['name', 'id'])->indexBy('id')->column();
                $selectBox = '<select name="'. $modelName .'[cat_id]" class="form-control" id="'. strtolower($modelName) .'-cat_id">';
                $selectBox .= "<option value=''>Select Category</option>";
                foreach ($categories as $key => $category) {
                    if(in_array($key, (array)$model->cat_id) )
                        $selectBox .= "<option selected value='$key'>$category</option>";
                    else
                        $selectBox .= "<option value='$key'>$category</option>";
                }
                $selectBox .= "</select>";
                echo $selectBox;
				?>
                <div class="col-lg-10">
                    <p class="help-block help-block-error"></p>
                </div>
            </div>
        </div>
    </div>        
    <?php
		echo $form->field($model, 'title', ['inputOptions' => [
				'placeholder' => 'Title',
				'class' => "form-control col-md-7 col-xs-12",
		]])->textInput(['autofocus' => true])->label('Title <span class="required">*</span>');
    ?>
    <?php
		echo $form->field($model, 'description', ['inputOptions' => [
				'placeholder' => 'Description',
				'class' => "form-control col-md-7 col-xs-12",
		]])->textarea(['rows' => 5,'autofocus' => true])->label('Description <span class="required">*</span>');
    ?>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <button type="button" class="btn btn-primary" onclick="window.history.go(-1); return false;">Cancel</button>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'name' => 'AddBanner-submit', 'id' => 'AddBanner-submit']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
</div>
