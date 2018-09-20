<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use common\models\Country;
use common\models\State;
use common\models\City;

$this->title = Yii::t('yii', 'Change Password');
$this->params['breadcrumbs'][] = $this->title;
?>
<section>
    <?php echo $this->render('//common/searchbox'); ?>
    <div class="searchresult">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <?php echo $this->render('//common/sidebar'); ?>
                </div>
                <div class="col-xs-12 col-sm-8 col-md-9">
                    <div class="message">
                        <?php if (Yii::$app->session->getFlash('item')): ?>
                            <div class="col-xs-12">
                                <div class="alert alert-grey alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                                    </button>
                                    <i class="glyphicon glyphicon-ok"></i><?php echo Yii::$app->session->getFlash('item'); ?>
                                </div>
                            </div>																	
                        <?php endif; ?>

                        <?php
                        $form = ActiveForm::begin(
                            [ 'id' => 'changePassword-form',
                                'options' => [
                                    'class' => 'inner',
                                    'tag' => 'span', ####THIS OPTIONS DISABLES THE DIV.FORM_GROUP ENCLOSER TAG FOR FIELDS
                                ],
                                'fieldConfig' => [
                                    'template' => "<div class=\"col-lg-4 col-md-4 col-sm-4\">\n
                                        <div class=\"form-group\">\n
                                        {label}\n
                                           <div class=\"val\">\n
                                              <div class=\"controls\">
                                              {input}
                                                 <div class=\"error-text\">
                                                 {error} {hint}
                                                 </div>
                                              </div>
                                              </div>
                                           </div>
                                        </div>",
                                    'labelOptions' => ['class' => ''],
                                    'options' => [
                                        'tag' => 'span', ####THIS OPTIONS DISABLES THE DIV.FORM_GROUP ENCLOSER TAG FOR FIELDS
                                        'class' => '', ####DISABLE THE DEFAULT FORM_GROUP CLASS
                                    ],
                                ],
                            ]
                        );
                        ?>

                        <div class="fullwidth">
                            <?php
                            echo $form->field($model, 'password')->passwordInput(['maxlength' => 20, 'autofocus' => true]);
                            ?>
                            <?php
                            echo $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 20, 'autofocus' => true]);
                            ?>		   
                        </div>

                        				

                        <div class="fullwidth">
                            <div class="col-xs-12">
                                <button class="btn btn-primary orangebtn" type="submit"><?php echo Yii::t('yii', 'Save'); ?></button>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</section>