<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('yii','Reset Password');
$this->params['breadcrumbs'][] = $this->title;
?>
<section>
        <div class="mainheading ">
        <?php echo $this->render('topbar'); ?>
        <div class="bordertopwhite">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <div class="headinginner"><?php echo $this->title; ?></div>
                    </div>
               </div>
           </div>
        </div>
    </div>
    <div class="form1">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-12 col-sm-12">
                    <div class="formcustomer"> 
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-12">
                                <h2><?php echo $this->title; ?></h2>
								  <?php if (Yii::$app->session->getFlash('item')): ?>
									 <div class="alert alert-grey alert-dismissible">
										   <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
										   </button>
										   <i class="glyphicon glyphicon-ok"></i><?php echo Yii::$app->session->getFlash('item'); ?>
									 </div>																
								  <?php endif; ?>
                                <?php $form = ActiveForm::begin(['id' => 'reset-password-form','options' => [
									'class' => 'inner', 
									]]); ?>
                                    <div class="fullwidth">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group ">
                                                <div class="val">
                                                    <div class="controls">
                                                    <?= $form->field($model, 'password')->passwordInput(['maxlength'=>20 , 'autofocus' => true]) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                <div class="fullwidth">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group ">
                                                <div class="val">
                                                    <div class="controls">
                                                    <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength'=>20 , 'autofocus' => true]) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="fullwidth">
                                        <div class="col-xs-12">
                                            <?= Html::submitButton(Yii::t('yii','Save'), ['class' => 'btn btn-primary orangebtn']) ?>
                                        </div>
                                    </div>
                                <?php ActiveForm::end(); ?></form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
