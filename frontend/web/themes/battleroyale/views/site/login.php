<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Country;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
$siteimage = Yii::getAlias('@siteimage');
?>
<section class="innerBanner defineFloat">
	<div class="bannerThumb">
		<div class="container">
			<div class="col-xs-12">
				<div class="bannerText">
					<h1 class="whiteText upperText">Login</h1>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="contentArea defineFloat" id="colorBg">
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-sm-8 col-xs-12">
				<div class="formOuter profilOeuter">
					<?php if (Yii::$app->session->getFlash('item')): ?>
						<div class="alert alert-grey alert-dismissible">
							   <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
							   </button>
							   <i class="glyphicon glyphicon-ok"></i><?php echo Yii::$app->session->getFlash('item'); ?>
						</div>															
                    <?php endif; ?>
                    <?php
						$form = ActiveForm::begin(
						[ 	//'action' => 'forum-post/create',
							'id' => 'login-form', 
							'method' => 'post',
							'options' => [ 'class' => 'inner'],
							'fieldConfig' => [
								'template' => "<div class=\"form-group\">\n
												  {label}\n<div class=\"controls\">
												  {input}<div class=\"col-xs-12\">
												  <label></label>{error}</div></div></div>",
								'labelOptions' => [],
							],
						]);
                    ?>
						<div class="form-group">
							<?= $form->field($model, 'email')->textInput(['maxlength'=>80 , 'autofocus' => true]) ?>
						</div>
						<div class="form-group">
							<?= $form->field($model, 'password')->passwordInput(['maxlength'=>20]) ?>
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1"></label>
							<?= Html::a(Yii::t('yii','Forgot Password?'), ['site/forgot-password']) ?>
						</div>
						
						<div class="button"> <?= Html::submitButton(Yii::t('yii','Login'), ['class' => 'btn btn-primary', 'name' => 'Submit', 'id' => 'login-form']) ?> </div>
					<?php ActiveForm::end(); ?>
				</div>
			</div>
		</div>
	</div>
</section>
