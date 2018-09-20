<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;  
use yii\helpers\ArrayHelper;
use backend\models\homebannervideo\Homebannervideo;
$this->title = 'Home Banner Video';
$this->params['breadcrumbs'][] = $this->title;
$CtrlName	 =	Yii::$app->controller->id;
$FunName	 =	Yii::$app->controller->action->id;
$count		 = new Homebannervideo();
$countValues = $count->countHomebannervideoValues();
?>

<!-- page content -->
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
						<?php if($countValues < 1) { ?>
							<?php echo Html::a('<i class="fa fa-plus"></i> Add Home Video Banner', ['create'], ['class' => 'btn btn-success']) ?>
						
						<?php  } ?>
                        <?php //echo Html::a('<i class="fa fa-plus"></i> Settings', ['settings'], ['class' => 'btn btn-success']); ?>
						<?= Html::button('Apply Filter', ['class' => 'btn btn-primary','id'=>'btnfilterApply','style'=>'float:right']) ?>
						<?= Html::button('Reset Filter', ['class' => 'btn btn-primary','id'=>'resetFilter','style'=>'float:right']) ?>
					</p>
					<?php Pjax::begin(['id' => 'Pjax_usersfilter', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET']]); ?>
					<?= GridView::widget([
						'id'=>'grid_container',
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
									'label' => 'Video Youtube Link',
									'encodeLabel' => false,
								],
								[
									'attribute' => 'date_created',
									'label' => 'Date Created',
									'format' => 'datetime',
									'encodeLabel' => false,
								],								
							
							[
							'attribute' => 'status',
								'value' =>function($dataProvider){ if($dataProvider->status=='1') { return 'Active'; } else { return 'Inactive'; } },
								//'filter' => Html::activeDropDownList($searchModel, 'status', array('1' => 'Active', '2' => 'Inactive'),['class'=>'form-control','prompt' => 'Status']),
							],
								[
									'class' => 'yii\grid\ActionColumn',
									'header' => 'Actions',	
									'template' => '{view} {update} {delete} {status}',
										'buttons' => [
											'status' => function ($url,$dataProvider) {
												
									return Html::dropDownList('action',$dataProvider->status,[''=>'Status','1'=>'Active','2'=>'Inactive'],['class'=>'dropdown','title' => 'Change Status','onchange' =>'updateStatus(this,'.$dataProvider->video_banner_id.')']);
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

	<!-- footer content -->
		<?php echo $this->render('../includes/footer'); ?>
	  <!-- /footer content -->

	</div>
	<!-- /page content -->
   
<!-- daterangepicker -->
	<script type="text/javascript" src="<?php echo Url::home(); ?>/themes/gentelella/js/moment.min2.js"></script>
	<script type="text/javascript" src="<?php echo Url::Home(); ?>/themes/gentelella/js/datepicker/daterangepicker.js"></script>
  <script type="text/javascript">
		
		 $(document).ready(function () {
			 
				$('#tdDateCreated input').daterangepicker({
					singleDatePicker: true,
					calender_style: "picker_4"
				});
			
				
				//$('#grid_container-filters td:last').html('<button type="button" id="btnfilterApply" class="btn btn-primary" style="float:right">Apply Filter</button>');
				
				//$.pjax.defaults.timeout = false;//IMPORTANT
				//$.pjax.reload({container:'#Pjax_usersfilter'});
				
				//~ var submit_form = false;
//~ 
				//~ $('body').on('click', '#btnfilterApply',  function(){
					//~ //enable submit for applyFilter event
					//~ if(submit_form === false) {
						//~ submit_form = true;
						//~ $("#grid_container").yiiGridView("applyFilter");
					//~ }
				//~ });

				//disable default submit

				//~ $("body").on('beforeFilter', "#grid_container" , function(event) {
					//~ return submit_form;
				//~ });
//~ 
				//~ $("body").on('afterFilter', "#grid_container" , function(event) {
					//~ submit_form = false;
				//~ });
				
				//$('.form-control').keypress(function(ev)
					// if (ev.which === 13) { }
				//});					

		});	
		
		$(document).on('pjax:complete', function() {
				$('#tdDateCreated input').daterangepicker({
					singleDatePicker: true,
					calender_style: "picker_4"
				});
		});
	
	function updateStatus(dis,userid)
	{
		var post = {'Updatebanner':{'status':dis.value}};	
		var url = '<?php echo Url::home(); ?>homebannervideo/status/'+userid;
		//alert(url); //return false;
		if(dis.value && dis.value != '') {
			$.ajax({
					url:'<?php echo Url::home(); ?>homebannervideo/status/'+userid,
					type:'post',
					data:post,
					success:function(response){
						//return false;
							window.location.reload();
						}
					
				});	
		}
	}
		
	</script>
