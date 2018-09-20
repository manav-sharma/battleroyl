<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;  
use yii\helpers\ArrayHelper;

$this->title = 'Homepagevideos';
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
								<?= Html::a('<i class="fa fa-plus"></i> Add Homepagevideo', ['create'], ['class' => 'btn btn-success']) ?>
								<?= Html::button('Apply Filter', ['class' => 'btn btn-primary','id'=>'btnfilterApply','style'=>'float:right']) ?>
								<?= Html::button('Reset Filter', ['class' => 'btn btn-primary','id'=>'resetFilter','style'=>'float:right']) ?>
							</p>
							<?php Pjax::begin(['id' => 'Pjax_usersfilter', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET']]); ?>
							<?= GridView::widget([
								'id'=>'grid-container',
								'dataProvider' => $dataProvider,
								'filterModel' => $searchModel,
								######################### Customers detail ##################### 
								'columns' => [
									['class' => 'yii\grid\SerialColumn'],
																		
									    [
											'attribute' => 'video_name',
											'label' => 'Video Name',
											'encodeLabel' => false,
										],
																			
										[
											'attribute' => 'youtubevideolink',
											'label' => 'Youtube Video Link',
											'encodeLabel' => false,
											//~ 'value' => 	function($dataProvider){ 
															//~ return (strip_tags($dataProvider->description));         
														//~ },
										],
										[
											'attribute' => 'date_created',
											'label' => 'Date Created',
											'filterOptions' => ['id' => 'tdDateCreated'],
											'format' => 'datetime',
										],
									[
									'attribute' => 'status',
										'value' =>function($dataProvider) { if($dataProvider->status=='1') { return 'Active'; } else { return 'Inactive'; } },
										'filter' => Html::activeDropDownList($searchModel, 'status', array('1' => 'Active', '2' => 'Inactive'),['class'=>'form-control','prompt' => 'Status']),
									],
										[
											'class' => 'yii\grid\ActionColumn',
											'header' => 'Actions',	
											'template' => '{view} {update} {delete} {status}',
												'buttons' => [
													'status' => function ($url,$dataProvider) {
														
											return Html::dropDownList('action',$dataProvider->status,['1'=>'Active','2'=>'Inactive'],['class'=>'dropdown','title' => 'Change Status','onchange' =>'updateStatus(this,'.$dataProvider->home_video_id.')']);
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
								})
								
								$('#tdDateCreated input').on('apply.daterangepicker', function(ev, picker) {    
									$("#grid-container").yiiGridView("applyFilter");                            
								});
								/*#### pagination limit ####*/
								$( "#propertiessearch-pagesize" ).change(function() {
									changePageLimit();
								});																
							});                      
							</script>									
							<?php Pjax::end(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php echo $this->render('../includes/footer'); ?>
	</div>
