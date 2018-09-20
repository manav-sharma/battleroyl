<?php
use yii\helpers\Html;

use yii\bootstrap\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use common\models\Country;
use common\models\State;
use common\models\City;

use yii\widgets\Pjax;
###PAGINATION CLASS
use yii\widgets\LinkPager;
use yii\data\Pagination;
$this->title = Yii::t('yii','Payment History');
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
		<?php if (Yii::$app->session->getFlash('item')): ?>
			
			 <div class="alert alert-grey alert-dismissible">
				   <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
				   </button>
				   <i class="glyphicon glyphicon-ok"></i><?php echo Yii::$app->session->getFlash('item'); ?>
			 </div>
																	
		<?php endif; ?>

	   <?php
			$form = ActiveForm::begin(
				[ 
					'id' => 'booking-form',
					'action' => ['customer/cancel-booking'],
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

			  
          <div class="paymenthistory">
				<?php
				Pjax::begin(['id' => 'Pjax_SearchResults', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET']]);
				?>	  
            <div class="tabbingBlock cont">
              <ul class="nav nav-tabs responsive" role="tablist" id="myTab" >
                <li role="presentation" id="first"><a data-toggle="tab" role="tab" aria-controls="home" href="#home"><?php echo Yii::t('yii','Booking History');?></a></li>
              </ul>
              <div class="tab-content responsive">
                <div id="home" class="tab-pane   active" role="tabpanel">
                  <div class="table-responsive">
							  
					<?php if(isset($bookingResult) && !empty($bookingResult)) { ?>  					  
                    <table class="table">
                      <thead>
                        <tr>
                          <th><?php echo Yii::t('yii','Date');?></th>
                          <th><?php echo Yii::t('yii','Insider Name');?></th>
                          <th><?php echo Yii::t('yii','Location');?></th>
                          <th><?php echo Yii::t('yii','Amount');?></th>
                          <th><?php echo Yii::t('yii','Travelers');?></th>
                          <th><?php echo Yii::t('yii','Booking Date');?></th>
                          <th><?php echo Yii::t('yii','Contact');?></th>
                          <th><?php echo Yii::t('yii','Feedback');?></th>
                          <th><?php echo Yii::t('yii','Booking Status');?></th>
                        </tr>
                      </thead>
                      <tbody>
					<?php foreach( $bookingResult as $bookVal )  { ?>
                        <tr>
                          <td><?= (isset($bookVal['booked_on_date']) ? date("d-m-Y",strtotime($bookVal['booked_on_date'])) : '') ?></td>
						  <td><?= substr((isset($bookVal['guydeFN']) ? $bookVal['guydeFN'] : '')." ".(isset($bookVal['guydeLN']) ? $bookVal['guydeLN'] : ''),0,30) ?></td>
						  <td><?= (isset($bookVal['booking_destination']) ? substr($bookVal['booking_destination'],0,30) : '') ?></td>
                          <td><span class="green"><?= (isset($bookVal['booking_price']) ? Yii::$app->params['currencySymbol'].$bookVal['booking_price'] : '') ?></span></td>
                          <td><?= (isset($bookVal['no_of_travellers']) ? $bookVal['no_of_travellers'] : '') ?></td>
                          <td><?= (isset($bookVal['booked_from_date']) ? $bookVal['booked_from_date'] : '') ?></td>
						  <td>
							  <?php echo Html::a('<i aria-hidden="true" class="fa fa-envelope-o"></i> '.Yii::t('yii','Send message').'',['messages/sendmessage', 'id' => $bookVal['booking_id']],['class' => 'sendmsg','title'=>'Send Message']); ?>
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
								}else{
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
									echo '<a href="javascript:void()" id="'.$bookVal['booking_id'].'" class="cancelBTN">Cancel</a>';
									//echo "Pending";
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
                  </div>
                  <p class="scrolltable"><?php echo Yii::t('yii','Scroll to see the table.');?></p>
                </div>
              </div>
            </div>
			<nav class="paginationdesign">
				<?php 
					#################= pagination =#################
					echo yii\widgets\LinkPager::widget([
						'pagination' => $pages,
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
        </div>
      </div>
    </div>
  </div>
	<script language="javascript">
			$('.cancelBTN').click(function() {

				var booking_id = $(this).attr('id');
				//alert(booking_id);
				$("#canBookingID").val(booking_id);
				if(!confirm('Are you sure to cancel booking request?')) {
					return false;
				}
				document.getElementById("booking-form").submit();
				return true;

			});
	</script>  
</section>
