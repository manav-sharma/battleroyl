<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$this->title = 'Send Notification';
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

		echo '<input type="hidden" name="SendMessage[lastrequest]" value="'.$data['lastrequest'].'" />';

		echo '<input type="hidden" name="SendMessage[userids]" value="'.$data['userids'].'" />';

		echo $form->field($model, 'notification_type')->checkboxList(['EMAIL'=>'Email', 'SMS' => 'Sms'])->label('Notification type <span class="required">*</span>');
		
		$userdata = Yii::$app->commonmethod->getUsername($data['userids']);
		echo $form->field($model, 'username', ['inputOptions' => [
				'placeholder' => 'name',
				'value'=> $userdata,
				'class' => "form-control col-md-7 col-xs-12",
		]])->textInput(['autofocus' => true,'readonly'=>true])->label('Name <span class="required">*</span>');

		echo $form->field($model, 'message', ['inputOptions' => [
				'placeholder' => 'message',
				'class' => "form-control col-md-7 col-xs-12",
		]])->textarea(['rows' => 5,'autofocus' => true])->label('Message <span class="required">*</span>');				
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
<script>
	$(document).ready(function () {
		$(':checkbox').on('change',function(){
			 var th = $(this), name = th.prop('name'); 
			 if(th.is(':checked')) {
				 $(':checkbox[name="'  + name + '"]').not($(this)).prop('checked',false);   
			  }
		});		
	});
</script>
