<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;  
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$this->title = 'Advertisements';
$this->params['breadcrumbs'][] = $this->title;
?>
	<div class="right_col" role="main">
		<div class="">
			<div class="page-title">
				<div class="title_left">
					<h3><?= Html::encode($this->title) ?></h3>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
						<?php if(Yii::$app->session->getFlash('item')):?>
							<div class="alert alert-success alert-dismissible fade in" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
							</button>    
								<?php echo Yii::$app->session->getFlash('item'); ?>
							</div>
						<?php endif; ?>
							<p>									
								<?= Html::button('Apply Filter', ['class' => 'btn btn-primary','id'=>'btnfilterApply','style'=>'float:right']) ?>
								<?= Html::button('Reset Filter', ['class' => 'btn btn-primary','id'=>'resetFilter','style'=>'float:right']) ?>
								<?= Html::button('Send Notification', ['class' => 'btn btn-primary','id'=>'send-message','style'=>'float:right']) ?>
								</br>
							</p>
							<?php Pjax::begin(['id' => 'Pjax_usersfilter', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET']]); ?>
							<?= GridView::widget([
								'id'=>'grid-container',
								'dataProvider' => $dataProvider,
								'filterModel' => $searchModel,
								'columns' => [
									['class' => 'yii\grid\SerialColumn'],
										[
										    'class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function($model) {
												return ['value' => $model->user_id,'class'=>'msgChk'];
											},
										],										
									    [
											'attribute' => 'name',
											'label' => 'Name',
											'encodeLabel' => false,
										],
										[
											'attribute' => 'user',
											'label' => 'Username',
											'value'=> function($dataProvider) {
												return (isset($dataProvider->user->firstname) ? $dataProvider->user->firstname : ''). ' '. (isset($dataProvider->user->lastname) ? $dataProvider->user->lastname : '');
											},
										],
										[
											'attribute' => 'email',
											'label' => 'Email',
											'value'=>'email.email'
										],
										[
											'attribute' => 'phone',
											'label' => 'Mobile',
											'value'=>'phone.phone'
										],										
										[
											'attribute' 	=> 'date_created',
											'label' 		=> 'Date Created',
											'filterOptions' => ['id' => 'tdDateCreated'],
											'format' 		=> 'datetime',
										],		
										[
											'attribute' => 'end_date',
											'label' => 'Expiry date',
											'filterOptions' => ['id' => 'tdDateExpired'],
											"value" => function($dataProvider) {
												$currentDate= Date("Y-m-d");
												$yellowDate = Date('Y-m-d', strtotime("+15 days"));
													if($currentDate > $dataProvider->end_date) {
														return "<span style='color:red;'>".$dataProvider->end_date."</span>";
													} else if($dataProvider->end_date > $currentDate && $dataProvider->end_date < $yellowDate) {
														return "<span style='color:#1a82c3;'>".$dataProvider->end_date."</span>";
													} else {
														return "<span style='color:green;'>".$dataProvider->end_date."</span>";
													}
												},
												"format"=>"html",
										],
										[
										'attribute' => 'status',
											'value' =>function($dataProvider) { if($dataProvider->status=='1') { return 'Active'; } else { return 'Inactive'; } },
											'filter' => Html::activeDropDownList($searchModel, 'status', array('1' => 'Active', '2' => 'Inactive'),['class'=>'form-control','prompt' => 'Status']),
										],
										[
											'class' => 'yii\grid\ActionColumn',
											'header' => 'Actions',	
											'template' => '{view} {approved} {delete} {status}',
												'buttons' => [
													'status' => function ($url,$dataProvider) {
														
											return Html::dropDownList('action',$dataProvider->status,['1'=>'Active','2'=>'Inactive','3' => 'Send Notification'],['class'=>'dropdown','title' => 'Change Status','onchange' =>'updateAdvertisementStatus(this,'.$dataProvider->id.','.$dataProvider->user_id.')']);
													},
                                    'approved' => function ($url, $dataProvider) {
                                            return Html::a('<i class="fa fa-upload"></i>', Url::home() . 'advertisements/update/' . $dataProvider->id, ['title' => 'Upload Advertisement Image']);
                                    },
												],
										],
								],
							]);
							?>
							<div class="col-md-3 col-sm-3 col-xs-6 page_limit_layout">
								<select id="propertiessearch-pagesize" name="PropertiesSearch[pagesize]" class="form-control">
									<option value="5">5</option>
									<option value="30" <?php echo (isset($_GET['p']) && $_GET['p'] == 30) ? 'selected' : ''; ?>>30</option>
									<option value="50" <?php echo (isset($_GET['p']) && $_GET['p'] == 50) ? 'selected' : ''; ?>>50</option>
									<option value="100" <?php echo (isset($_GET['p']) && $_GET['p'] == 100) ? 'selected' : ''; ?>>100</option>
								</select>
							</div>							
							<script>
								$(document).ready(function () {
									$('#tdDateCreated input').prop('readonly', true);
									$('#tdDateCreated input').daterangepicker({
										singleDatePicker: true,
										calender_style: "picker_4",                                
										format: 'YYYY-MM-DD'
									});
									
									$('#tdDateCreated input').on('apply.daterangepicker', function(ev, picker) {    
										$("#grid-container").yiiGridView("applyFilter");                            
									});

									$('#tdDateExpired input').prop('readonly', true);
									$('#tdDateExpired input').daterangepicker({
										singleDatePicker: true,
										calender_style: "picker_4",                                
										format: 'YYYY-MM-DD'
									});
									
									$('#tdDateExpired input').on('apply.daterangepicker', function(ev, picker) {    
										$("#grid-container").yiiGridView("applyFilter");                            
									});	

									/*#### pagination limit ####*/
									$( "#propertiessearch-pagesize" ).change(function() {
										changePageLimit();
									});									
								});
							</script>								
							<?php Pjax::end(); ?>
							<?php
								$form = ActiveForm::begin(['id' => 'form-sendmessage','action'=>Url::home().'notifications/sendmessage']);			
								echo '<input type="hidden" name="userids" id="sendchkbox" value="" />';
								echo '<input type="hidden" name="lastrequest" value="advertisements" />';
								ActiveForm::end();
							?>							
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php echo $this->render('../includes/footer'); ?>
	</div>
