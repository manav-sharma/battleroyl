<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = 'Logout!';
?>

<section>

		<?= Html::encode($this->title) ?>

     <?php echo $this->render('//common/searchbox'); ?>       
	<div class="container">
   			<div class="row">
     			<div class="col-xs-12 col-md-12 col-sm-12">
        			<div class="formcustomer"> 
          				<div class="col-xs-12">
           					<div class="row">
             					<div class="col-xs-12">
									<h2>Thank You</h2>
								</div>
								<div class="col-xs-12">
									<div class="row">
										<div class="col-xs-12">
											 <p>Logged out Successfully.</p>
											
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
