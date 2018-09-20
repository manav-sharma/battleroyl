<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('yii','Make Payment');
$this->params['breadcrumbs'][] = $this->title;

$booking_details = Yii::$app->session->get('booking_details');
$price = $booking_details['booking_price'];
$currency = (isset($booking_details['currency_sign']) ? $booking_details['currency_sign'] : '$');
$loggedUser = Yii::$app->user->identity;
?>
<section class="contentOuter">
	<?php echo $this->render('//common/searchbox'); ?>  
    <div class="container innerpages">
        <div class="row formcustomer">
            <div class="col-xs-12">
				<h2><?=$this->title?></h2>
			 <?php if (Yii::$app->session->getFlash('error_mesg')) { ?>
			  <div class="col-xs-12">  <div class="alert alert-grey alert-dismissible">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
					<i class="glyphicon glyphicon-ok"></i> 
					<?php echo Yii::$app->session->getFlash('error_mesg'); ?>
				</div> </div>
			<?php } ?>
           
              
                <div class="col-xs-12">

                    <div class="row">
                       
                        <?php
                        $form = ActiveForm::begin(
                                        [ 'id' => 'paypal-form', 'method' => 'post',
                                            'options' => ['class' => 'inner'],
                                            'fieldConfig' => [
                                                'template' => "<div class=\"form-group\">\n
													{label}\n<div class=\"controls\">
													{input}<div class=\"col-lg-10\">
													{error}</div></div></div>",
                                                'labelOptions' => [],
                                            ],
                                ]);
                        ?>
                            
                        <?php
							$items = array(
								'Visa' => 'Visa',
								'MasterCard' => 'Master Card',
								'Discover' => 'Discover',
								'Amex' => 'American Express',
							);
							$items_mm = array();
							$items_yy = array();
							for ($i = 1; $i <= 9; $i++) {
								$items_mm['0' . $i] = '0' . $i;
							}
							$items_mm['10'] = 10;
							$items_mm['11'] = 11;
							$items_mm['12'] = 12;

							$start_year = date('Y');
							for ($i = 0; $i <= 15; $i++) {
								$yy = $start_year + $i;
								$items_yy[$yy] = $yy;
							}
                        ?>

                        <div class="fullwidth"> 
							<div class="col-lg-4 col-md-4 col-sm-4">	
                                <?= $form->field($model, 'fname_oncard')->textInput(['maxlength' => '16']) ?>
                            </div>	                                           
                            <div class="col-lg-4 col-md-4 col-sm-4">
							<?=
								$form->field($model, 'cc_type')->dropDownList(
									$items, // Flat array ('id'=>'label')
									['prompt' => 'Select Card Type']    // options
							)
							?>
                            </div>	
                            <div class="col-lg-4 col-md-4 col-sm-4">	
                                <?= $form->field($model, 'cc_number')->textInput(['maxlength' => '16','autocomplete'=>'off']) ?>
                            </div>	
                           
                        </div>	
                        <div class="fullwidth">  
							 <div class="col-lg-4 col-md-4 col-sm-4">	
                                <?= $form->field($model, 'cvv')->passwordInput(['maxlength' => '16','autocomplete'=>'off']) ?>
                            </div>	   
                            <div class="col-lg-4 col-md-4 col-sm-4">	
                                <?=
                                $form->field($model, 'exp_month')->dropDownList(
                                        $items_mm, // Flat array ('id'=>'label')
                                        ['prompt' => 'Select Expiry Month']    // options
                                )
                                ?>
                            </div> 
                            <div class="col-lg-4 col-md-4 col-sm-4">	
                                <?=
                                $form->field($model, 'exp_year')->dropDownList(
                                        $items_yy, // Flat array ('id'=>'label')
                                        ['prompt' => 'Select Expiry Year']    // options
                                )
                                ?>
                            </div>
                           
                      </div>
                      
                       <div class="fullwidth"> 
						  <div class="col-lg-4 col-md-4 col-sm-4">	
                                <img src="<?php echo Url::home(); ?>frontend/web/themes/	myguyde/images/vmadlogo.png"/>
                          </div>	    
						  <div class="col-lg-4 col-md-4 col-sm-4">	
                                
                          </div>	    
						 
						  <div class="col-lg-4 col-md-4 col-sm-4" style="text-align:right;">
							 <h4 style="float:left;padding: 13px 0px;">Total Due: <?php echo $currency; ?><span class="payPrice"><?php echo $price; ?></span> </h4>
							 <?= Html::submitButton('Submit', ['class' => 'btn btn-primary orangebtn', 'name' => 'paynow-button', 'id' => 'paynow-button']) ?>
								 <p class="secureserver">secure server <img src="<?php echo Url::home(); ?>frontend/web/themes/myguyde/images/locksmall.png"/></p>
						</div>	
						
                       </div>
                       
                    
                        <div class="fullwidth">
							
							<div class="col-lg-4 col-md-4 col-sm-4"> 
							<img src="<?php echo Url::home(); ?>frontend/web/themes/myguyde/images/Seal_Symantec_Trans.png" style="height: 92px;">
							</div>
							
                        </div>
                        <?php ActiveForm::end(); ?>
              
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>
  
