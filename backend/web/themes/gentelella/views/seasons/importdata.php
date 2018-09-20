<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
$CtrlName	=	Yii::$app->controller->id;
$this->title = 'Import Contestant Votes';
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>
                    <?= Html::encode($this->title) ?>
                </h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="x_panel">
                    <div class="x_title">
                        <?php if (Yii::$app->session->getFlash('item')): ?>
                            <div class="alert alert-success alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>    
                            <?php echo Yii::$app->session->getFlash('item'); ?>
                            </div>
                        <?php endif; ?>

                    </div>
					<script type="text/javascript" src="<?php echo Url :: Home(); ?>/themes/gentelella/js/tiny_mce/tinymce.js"></script>
					<script type="text/javascript" src="<?php echo Url :: Home(); ?>/themes/gentelella/js/tiny_mce/addediter.js"></script>
<div class="x_content">
    <p class="mandatory-fields">All fields are mandatory:</p>
    <?php
		$form = ActiveForm::begin(
						['id' => 'form-importfile',
							'options' => ['class' => 'form-horizontal form-label-left', 'enctype' => 'multipart/form-data'],
							'fieldConfig' => [
								'template' => "<div class=\"item form-group\">\n{label}\n<div class=\"col-md-6 col-sm-6 col-xs-12\">
								{input}<div class=\"col-lg-10\">
								{error}</div></div></div>",
								'labelOptions' => ['class' => 'control-label col-md-3'],
							],
		]);
    ?>

  
    <?php echo $form->field($model, 'importfile')->fileInput(['multiple' => false,"accept"=>"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"])->label('Upload Excel File'); ?>    

    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <button type="button" class="btn btn-primary" onclick="window.history.go(-1); return false;">Cancel</button>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'name' => 'Import-submit', 'id' => 'Import-submit']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
</div>


</div>
            </div>
        </div>
    </div>
    <!-- footer content -->
<?php echo $this->render('../includes/footer'); ?>
    <!-- /footer content -->
</div>
