<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
$CtrlName	=	Yii::$app->controller->id;
$mName = 'UpdateGroupImages';
$this->title = 'Add Group Images';
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
						['id' => 'form-groupimages',
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

    <?php echo $form->field($modelImageUpload, 'group_image[]')->fileInput(['multiple' => true,"accept"=>"image/*"])->label('Image uploads'); 
    echo'<span id="result" class="client_image">';	
			if(isset($mediaArr['group_image'])) {
				foreach($mediaArr['group_image'] as $img) {
					echo "<span class='".$img->image_id."'><img src='".SITE_URL."common/uploads/groupimages/".$img->group_image."' width='60' height='60' /> <span id='".$img->image_id."' class='mediaKey glyphicon glyphicon-trash'></span> </span>";
				}
			}
		echo'</span>';
    
    ?>    

    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <button type="button" class="btn btn-primary" onclick="window.history.go(-1); return false;">Cancel</button>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'name' => 'AddBanner-submit', 'id' => 'AddBanner-submit']) ?>
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
<!-- /page content -->

<!-- daterangepicker -->
<script src="<?php echo Url::Home(); ?>themes/gentelella/js/uploadmulti_group.js"></script>

<script type="text/javascript">
    $(document).ready(function () {

        /*########### delete media files of propertes ###########*/
			$('.mediaKey').on('click', function(e){
				e.preventDefault();
				var media_id = this.id;
				var post = {'update':{'status':media_id}};	
				if(media_id && media_id != '') {
					$.ajax({
							url:'<?php echo Url::home().$CtrlName; ?>/deletepmedia/'+media_id,
							type:'post',
							data:post,
							success:function(response){
									$("."+media_id).remove();
								}
						});
				}
			});	
    });

</script>
