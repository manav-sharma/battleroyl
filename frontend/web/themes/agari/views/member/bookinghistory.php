<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use common\models\Country;
use common\models\State;
use common\models\City;
use frontend\models\Interests;

use yii\widgets\Pjax;
###PAGINATION CLASS
use yii\widgets\LinkPager;
use yii\data\Pagination;
use yii\db\Query;

$this->title = Yii::t('yii','Booking history');
$this->params['breadcrumbs'][] = $this->title;

$query = new Query;
$query->select('admin_fee')->from('admin');
$commission = $query->createCommand()->queryOne();

?>
<section>
<?php echo $this->render('//common/searchbox'); ?>
  <div class="searchresult">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-4 col-xs-12">
			<?php echo $this->render('../common/sidebar'); ?>
        </div>
	   <?php
			$form = ActiveForm::begin(
				[ 
					'id' => 'booking-form',
					'action' => ['member/cancel-booking'],
					'options' => [
						'enctype' => 'multipart/form-data',
						'tag' => 'span', ####THIS OPTIONS DISABLES THE DIV.FORM_GROUP ENCLOSER TAG FOR FIELDS
					],
					'fieldConfig' => [
						'template' => "{input}",
						'labelOptions' => ['class' => ''],
						'options' => [
							'tag' => 'span', ####THIS OPTIONS DISABLES THE DIV.FORM_GROUP ENCLOSER TAG FOR FIELDS
							'class' => '', ####DISABLE THE DEFAULT FORM_GROUP CLASS
						],
					],
				]
			);
		?>
		
		
		 <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
		 <input type="hidden" name="canBookingID" id="canBookingID" value="" />
		 <?php ActiveForm::end(); ?>
        <div class="col-xs-12 col-sm-8 col-md-9">
          <div class="paymenthistory">
            <div class="tabbingBlock cont">
              <ul class="nav nav-tabs responsive" role="tablist" id="myTab" >
                
				<li role="presentation"><a data-toggle="tab" role="tab" aria-controls="home" href="#home"><?php echo Yii::t('yii','received Payment');?></a></li>
                <li role="presentation"><a data-toggle="tab" role="tab" aria-controls="profile" href="#profile"><?php echo Yii::t('yii','pending Payment');?></a></li>
				<li role="presentation" id="first"><a data-toggle="tab" role="tab" aria-controls="home" href="#home1"><?php echo Yii::t('yii','My Booking');?></a></li>                
              </ul>
              <div class="tab-content responsive">
                <div id="home1" class="tab-pane   active" role="tabpanel">
                  <div class="table-responsive">
				<?php
				Pjax::begin(['id' => 'Pjax_SearchResults', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET']]);
				?>					  
					<?php if(isset($bookingResultAll) && !empty($bookingResultAll)) { ?>  
                    <table class="table">
                      <thead>
                        <tr>
						  <th><?php echo Yii::t('yii','Reference number');?></th>	
                          <th><?php echo Yii::t('yii','Insider Name');?></th>
                          <th><?php echo Yii::t('yii','Location');?></th>
                          <th><?php echo Yii::t('yii','Amount');?></th>
                          <th><?php echo Yii::t('yii','Travelers');?></th>
                          <th><?php echo Yii::t('yii','Booking Date');?></th>                          
                          <th><?php echo Yii::t('yii','Contact');?></th>
                          <th><?php echo Yii::t('yii','Feedback');?></th>
                          <th><?php echo Yii::t('yii','Status');?></th>
                          <th><?php echo Yii::t('yii','Action');?></th>
                        </tr>
                      </thead>
                      <tbody>
					<?php foreach( $bookingResultAll as $bookVal )  { 
							$bookingDate = $bookVal['booked_from_date'];
							$datediff = strtotime($bookVal['booked_to_date']) - strtotime($bookVal['booked_from_date']); 
							if($datediff > 0)
								$bookingDate .= ' <br/> '.$bookVal['booked_to_date'];						
					?>
                        <tr>
							<td><?= (isset($bookVal['reference_number']) && $bookVal['reference_number'] != 0 ? $bookVal['reference_number'] : '') ?></td>
						  <td><?= substr((isset($bookVal['guydeFN']) ? $bookVal['guydeFN'] : '')." ".(isset($bookVal['guydeLN']) ? $bookVal['guydeLN'] : ''),0,30) ?>
								<p><?php echo Html::a('<i aria-hidden="true" class="fa fa-download"></i> '.Yii::t('yii','View summary').'',['booking/download-booking-info', 'id' => $bookVal['booking_id']],['class' => 'sendmsg']); ?></p>				  
						  </td>
						  <td><?= (isset($bookVal['booking_destination']) ? substr($bookVal['booking_destination'],0,30) : '') ?></td>
                          <td><span class="green"><?= (isset($bookVal['booking_price']) ? Yii::$app->formatter->asCurrency($bookVal['booking_price']) : '') ?></span></td>
                          <td><?= (isset($bookVal['no_of_travellers']) ? $bookVal['no_of_travellers'] : '') ?></td>
                          <td><?= (isset($bookingDate) ? $bookingDate : '') ?></td>
						  <td>
							  <?php 
							   if($bookVal['booking_status'] == '1') {
									echo Html::a('<i aria-hidden="true" class="fa fa-envelope-o"></i> '.Yii::t('yii','Send message').'',['messages/sendmessage', 'id' => $bookVal['booking_id']],['class' => 'sendmsg','title'=>'Send Message']); 
							   } else {
								   echo '<i aria-hidden="true" class="fa fa-envelope-o"></i> '.Yii::t('yii','Send message');
							   }
							  ?>
						  </td>
						  <td>
						   <?php
						   if($bookVal['booking_status'] == '1') {
								$feedbackModel = \frontend\models\FeedbackRating::findOne(['booking_id' => $bookVal['booking_id']]);
								$complete_booking_date  = strtotime($bookVal['booked_to_date']);
								$current_date 	 		= strtotime(date("Y-m-d"));								
								if ($feedbackModel === null) {
									if($current_date > $complete_booking_date) {
										echo Html::a('<i aria-hidden="true" class="fa fa-commenting-o"></i> '.Yii::t('yii','Feedback').'',['feedback/post-feedback', 'id' => $bookVal['booking_id']],['class' => 'sendmsg','title'=>'Post Feedback']);
									} else {
										echo '<i aria-hidden="true" class="fa fa-commenting-o"></i> '.Yii::t('yii','Feedback');
									} 
								} else {
									echo '<span class="green">'.Yii::t('yii','Feedback Sent').'</span>';	
								}
							} else {
								echo '<i aria-hidden="true" class="fa fa-commenting-o"></i> '.Yii::t('yii','Feedback');
							}
						   ?>
						  </td>
						  <td>
							<?php
								if($bookVal['booking_status'] == '1') {
									echo "Accepted";
								} else if($bookVal['booking_status'] == '2') {
									echo "Declined";
								} else if($bookVal['booking_status'] == '3') {
									echo "Cancelled";
								} else {
									echo "Pending";
								}
							?>						
							
						  </td>
						  <td>
						  <?php
								if($bookVal['booking_status'] != '2' && $bookVal['booking_status'] != '3' && date("Y-m-d") < $bookVal['booked_from_date']) {
									echo '<a href="javascript:void()" id="'.$bookVal['booking_id'].'" class="cancelBTN">Cancel</a>';
								}
						  ?>
						  </td>						 
                        </tr>
					 <?php } ?>
                      </tbody>
                    </table>
                   
                    <?php } else { ?>                  
                     <table class="table">
						<tbody>
							<tr>
								<td colspan="5" align="center"><?php echo Yii::t('yii','No Booking yet');?></td>
							</tr>
                        </tbody>
                      </table>
                      <?php } ?>         
				<nav class="paginationdesign">
				<?php 
					#################= pagination =#################
					echo yii\widgets\LinkPager::widget([
						'pagination' => $pagesA,
						'prevPageLabel' => '<i class="fa fa-angle-left" aria-hidden="true"></i>',
						'nextPageLabel' => '<i class="fa fa-angle-right" aria-hidden="true"></i>',
						'activePageCssClass' => 'active',
						'disabledPageCssClass' => 'disabled',
						'prevPageCssClass' => 'enable',
						'nextPageCssClass' => 'enable',
						'hideOnSinglePage' => true
					]);
				?>                       
                </nav>     
                <?php Pjax::end(); ?>
                  </div>
                  <p class="scrolltable"><?php echo Yii::t('yii','Scroll to see the table.');?></p>
                </div>
				<div id="home" class="tab-pane " role="tabpanel">
                  <div class="table-responsive">
				<?php
				Pjax::begin(['id' => 'Pjax_SearchResults1', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET']]);
				?>					  
					<?php if(isset($bookingResultRecieved) && !empty($bookingResultRecieved)) { ?>
                    <table class="table">
                      <thead>
                        <tr>
						  <th><?php echo Yii::t('yii','Reference number');?></th>
                          <th><?php echo Yii::t('yii','Name');?></th>
                          <th><?php echo Yii::t('yii','Location');?></th>
                          <th><?php echo Yii::t('yii','Payment information');?></th>
                          <th><?php echo Yii::t('yii','Amount');?></th>
                          <th><?php echo Yii::t('yii','Travelers');?></th>
                          <th><?php echo Yii::t('yii','Booking Date');?></th>                           
                          <th><?php echo Yii::t('yii','Contact');?></th>
                        </tr>
                      </thead>
                      <tbody>
						<?php foreach( $bookingResultRecieved as $bookVal ) { 
								$bookingDate = $bookVal['booked_from_date'];
								$datediff = strtotime($bookVal['booked_to_date']) - strtotime($bookVal['booked_from_date']); 
								if($datediff > 0)
									$bookingDate .= ' <br/> '.$bookVal['booked_to_date'];							
						?>
                        <tr>
						  <td><?= (isset($bookVal['reference_number']) && $bookVal['reference_number'] != 0 ? $bookVal['reference_number'] : '') ?></td>
                          <td><?= substr((isset($bookVal['customerFN']) ? $bookVal['customerFN'] : '')." ".(isset($bookVal['customerLN']) ? $bookVal['customerLN'] : ''),0,30) ?>
<p><?php echo Html::a('<i aria-hidden="true" class="fa fa-download"></i> '.Yii::t('yii','View summary').'',['booking/download-booking-info', 'id' => $bookVal['booking_id']],['class' => 'sendmsg']); ?></p>                      
                          </td>
                          <td><?= (isset($bookVal['booking_destination']) ? substr($bookVal['booking_destination'],0,30) : '') ?></td>
                          <td><?php echo ((isset($commission['admin_fee']) && $commission['admin_fee'] > 0 )? floatval($commission['admin_fee']) : '1.00').'% '.' '.Yii::t('yii','have been charged for payment process fees.');?></td>
                          <td><span class="green"><?= Yii::$app->formatter->asCurrency($bookVal['booking_price']-($bookVal['admin_fee']+$bookVal['service_fee'])) ?></span></td>
                          <td><?= (isset($bookVal['no_of_travellers']) ? $bookVal['no_of_travellers'] : '') ?></td>
                          <td><?= (isset($bookingDate) ? $bookingDate : '') ?></td>
                                                    
                          <td>
							  <?php echo Html::a('<i aria-hidden="true" class="fa fa-envelope-o"></i> '.Yii::t('yii','Send message').'',['messages/sendmessage', 'id' => $bookVal['booking_id']],['class' => 'sendmsg']); ?>
                          </td>
                        </tr>
						<?php } ?>
                      </tbody>
                    </table>
                    
                    <?php } else { ?>                  
                     <table class="table">
						<tbody>
							<tr>
								<td colspan="5" align="center"><?php echo Yii::t('yii','No Payments Received yet');?></td>
							</tr>
                        </tbody>
                      </table>
                      <?php } ?>          
				<nav class="paginationdesign">
				<?php 
					#################= pagination =#################
					echo yii\widgets\LinkPager::widget([
						'pagination' => $pagesR,
						'prevPageLabel' => '<i class="fa fa-angle-left" aria-hidden="true"></i>',
						'nextPageLabel' => '<i class="fa fa-angle-right" aria-hidden="true"></i>',
						'activePageCssClass' => 'active',
						'disabledPageCssClass' => 'disabled',
						'prevPageCssClass' => 'enable',
						'nextPageCssClass' => 'enable',
						'hideOnSinglePage' => true
					]);
				?>                       
                </nav>     
                <?php Pjax::end(); ?>                    
                  </div>
                  <p class="scrolltable"><?php echo Yii::t('yii','Scroll to see the table.');?></p>
                </div>
                <div id="profile" class="tab-pane" role="tabpanel">
                  <div class="table-responsive">
				<?php
				Pjax::begin(['id' => 'Pjax_SearchResults2', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET']]);
				?>
					<?php if(isset($bookingResultPending) && !empty($bookingResultPending)) { ?>
                    <table class="table">
                      <thead>
                        <tr>
                          <th><?php echo Yii::t('yii','Reference number');?></th>
                          <th><?php echo Yii::t('yii','Name');?></th>
                          <th><?php echo Yii::t('yii','Location');?></th>
                          <th><?php echo Yii::t('yii','Payment information');?></th>
                          <th><?php echo Yii::t('yii','Amount');?></th>
                          <th><?php echo Yii::t('yii','Travelers');?></th>
                          <th><?php echo Yii::t('yii','Booking Date');?></th>                                                 
                          <th><?php echo Yii::t('yii','Contact');?></th>
                          <th><?php echo Yii::t('yii','Status');?></th>
                          <th><?php echo Yii::t('yii','Action');?></th>
                        </tr>
                      </thead>
                      <tbody>
						<?php foreach( $bookingResultPending as $bookVal ) { 
								$bookingDate = $bookVal['booked_from_date'];
								$datediff = strtotime($bookVal['booked_to_date']) - strtotime($bookVal['booked_from_date']); 
								if($datediff > 0)
									$bookingDate .= ' <br/> '.$bookVal['booked_to_date'];							
						?>
							<tr>
							  <td><?= (isset($bookVal['reference_number']) && $bookVal['reference_number'] != 0 ? $bookVal['reference_number'] : '') ?></td>
							  <td><?= substr((isset($bookVal['customerFN']) ? $bookVal['customerFN'] : '')." ".(isset($bookVal['customerLN']) ? $bookVal['customerLN'] : ''),0,30) ?>
							  <p><?php echo Html::a('<i aria-hidden="true" class="fa fa-download"></i> '.Yii::t('yii','View summary').'',['booking/download-booking-info', 'id' => $bookVal['booking_id']],['class' => 'sendmsg']); ?></p>						  
							  </td>
							  <td><?= (isset($bookVal['booking_destination']) ? substr($bookVal['booking_destination'],0,30) : '') ?></td>
							  <td><?php echo ((isset($commission['admin_fee']) && $commission['admin_fee'] > 0 )? floatval($commission['admin_fee']) : '1.00').'% '.' '.Yii::t('yii','have been charged for payment process fees.');?></td>
							  <td><span class="green"><?= Yii::$app->formatter->asCurrency($bookVal['booking_price']-($bookVal['admin_fee']+$bookVal['service_fee']));   ?></span></td>
							  <td><?= (isset($bookVal['no_of_travellers']) ? $bookVal['no_of_travellers'] : '') ?></td>
							  <td><?= (isset($bookingDate) ? $bookingDate : '') ?></td>
							  <td>
								<?php 
								  if($bookVal['booking_status'] == 3) {
									  echo "Not Allowed"; 
								  } else {
									echo Html::a('<i aria-hidden="true" class="fa fa-envelope-o"></i> '.Yii::t('yii','Send message').'',['messages/sendmessage', 'id' => $bookVal['booking_id']],['class' => 'sendmsg']); 
								  }
								?>
							  </td>
							  <td>
								<?php
									if($bookVal['booking_status'] == 3) {
										 echo "Cancelled";
									} else if($bookVal['booking_status'] == 2) {
										echo 'Declined';
									} else if($bookVal['booking_status'] == 1) {
										echo 'Accepted';	
									} else {
										echo"Pending";
									}
								?>
							  </td>
							  <td>
								<?php
									if($bookVal['booking_status'] == '1' && date("Y-m-d") < $bookVal['booked_from_date']) {
										echo '<a href="javascript:void()" id="'.$bookVal['booking_id'].'" class="cancelBTN">Cancel</a>';
									}
								?>							  
							  </td>							  
							</tr>
						<?php } ?>
                        </tbody>
                    </table>
                    
                    <?php } else { ?>                  
                     <table class="table">
						<tbody>
							<tr>
								<td colspan="5" align="center"><?php echo Yii::t('yii','No Pending Payments');?></td>
							</tr>
                        </tbody>
                      </table>
                      <?php } ?>           
				<nav class="paginationdesign">
				<?php 
					#################= pagination =#################
					echo yii\widgets\LinkPager::widget([
						'pagination' => $pagesP,
						'prevPageLabel' => '<i class="fa fa-angle-left" aria-hidden="true"></i>',
						'nextPageLabel' => '<i class="fa fa-angle-right" aria-hidden="true"></i>',
						'activePageCssClass' => 'active',
						'disabledPageCssClass' => 'disabled',
						'prevPageCssClass' => 'enable',
						'nextPageCssClass' => 'enable',
						'hideOnSinglePage' => true
					]);
				?>                       
                </nav>
                <?php Pjax::end(); ?>
                  </div>
                  <p class="scrolltable"><?php echo Yii::t('yii','Scroll to see the table.');?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
	<script language="javascript">
			$('.cancelBTN').click(function() {

				var booking_id = $(this).attr('id');
				$("#canBookingID").val(booking_id);
				if(!confirm('Are you sure to cancel booking request?')) {
					return false;
				}
				document.getElementById("booking-form").submit();
				return true;

			});
	</script>
</section>
