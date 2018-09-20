<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('yii','Login');
$this->params['breadcrumbs'][] = $this->title;
?>

<section>
	<?php echo $this->render('//common/searchbox'); ?>
  	<div class="form1">
  		<div class="container">
   			<div class="row">
     			<div class="col-xs-12 col-md-12 col-sm-12">
        			<div class="formcustomer"> 
          				<div class="col-xs-12">
           					<div class="row">
             					<div class="col-xs-12">
	                			<h2><?php echo Yii::t('yii','Login'); ?></h2>
                              <?php if (Yii::$app->session->getFlash('item')): ?>
                                 <div class="alert alert-grey alert-dismissible">
                                       <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                                       </button>
                                       <i class="glyphicon glyphicon-ok"></i><?php echo Yii::$app->session->getFlash('item'); ?>
                                 </div>															
                              <?php endif; ?>
								</div>
              					<?php
                                    	$form = ActiveForm::begin(
                                        [ 	//'action' => 'forum-post/create',
                                        	'id' => 'login-form', 
                                        	'method' => 'post',
                                            'options' => [ 'class' => 'inner'],
                                            'fieldConfig' => [
                                                'template' => "<div class=\"form-group\">\n
                                                                  {label}\n<div class=\"controls\">
                                                                  {input}<div class=\"col-lg-10\">
                                                                  {error}</div></div></div>",
                                                'labelOptions' => [],
                                            ],
                                    	]);
                                   ?>

                               		<div class="fullwidth">
										<div class="col-lg-4 col-md-4 col-sm-4">
											<?= $form->field($model, 'email')->textInput(['maxlength'=>80 , 'autofocus' => true]) ?>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4">
											<?= $form->field($model, 'password')->passwordInput(['maxlength'=>20]) ?>
										</div>
									</div>
					                <div class="fullwidth">
										<div class="col-lg-12 col-md-12 col-sm-12">
											<div class="form-group ">
												<?= Html::a(Yii::t('yii','Forgot Password'), ['site/forgot-password'],['class' => 'anchorText']) ?>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= Html::a(Yii::t('yii','Not registered yet'), ['site/signup'],['class' => 'anchorText']) ?>
											</div>
										</div>
									</div>
					                <div class="fullwidth">
					                  <div class="col-xs-12">
					                    <?= Html::submitButton(Yii::t('yii','Login'), ['class' => 'btn btn-primary orangebtn', 'name' => 'login-button', 'id' => 'login-form']) ?>
					                  </div>
					                </div>
             					 <?php ActiveForm::end(); ?>
           					</div>
          				</div>
       				</div>
      			</div>
    		</div>
  		</div>
  	</div>
</section>
