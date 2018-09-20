<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>

<section>
     <?php echo $this->render('//common/searchbox'); ?>       
	<div class="container">
   			<div class="row">
     			<div class="col-xs-12 col-md-12 col-sm-12">
        			<div class="formcustomer"> 
          				<div class="col-xs-12">
           					<div class="row">
             					<div class="col-xs-12">
									<h2><?= nl2br(Html::encode($message)) ?></h2>
								</div>
								<div class="col-xs-12">
									<div class="row">
										<div class="col-xs-12">
											 <p><?php echo Yii::t('yii','The above error occurred while the Web server was processing your request.');?></p>
											<p><?php echo Yii::t('yii','Please contact us if you think this is a server error. Thank you.');?></p>
										</div>
									</div>
								</div>
           					</div>
          				</div>
       				</div>
      			</div>
    		</div>
  		</div>
  </section>	
