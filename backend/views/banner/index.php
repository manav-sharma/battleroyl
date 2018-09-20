<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;  

use yii\helpers\ArrayHelper;

$this->title = 'Banner';
$this->params['breadcrumbs'][] = $this->title;

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
						<?= Html::a('<i class="fa fa-plus"></i> Add Banner', ['create'], ['class' => 'btn btn-success']) ?>
                                            
                                                <?= Html::a('<i class="fa fa-plus"></i> Settings', ['settings'], ['class' => 'btn btn-success']) ?>
						
						<?= Html::button('Apply Filter', ['class' => 'btn btn-primary','id'=>'btnfilterApply','style'=>'float:right']) ?>
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
									'attribute' => 'bannerImage',
									'label' => 'Image',
									'format' => 'html',    
									'value' => function ($dataProvider) {
										if( $dataProvider->bannerImage != '' ) {
											$profile_picarr = $dataProvider->bannerImage;
											

										} else 
										$profile_picarr = array();
										
										$profile_pic = isset($dataProvider->bannerImage)? BANNER_IMAGE_PATH.$dataProvider->bannerImage : NO_IMAGE;
										return Html::img($profile_pic,
											['width' => '150px','height' => '80px']);
									},
								],							
								[
									'attribute' => 'title',
									'label' => 'Title',
									'encodeLabel' => false,
								],
								[
									'attribute' => 'description',
									'label' => 'Description',
									'encodeLabel' => false,
								],
								[
									'attribute' => 'dateCreated',
									'label' => 'Date Created',
									'encodeLabel' => false,
								],								
							
							[
							'attribute' => 'status',
								'value' =>function($dataProvider){ if($dataProvider->status=='1') { return 'Active'; } else { return 'Inactive'; } },
								'filter' => Html::activeDropDownList($searchModel, 'status', array('1' => 'Active', '2' => 'Inactive'),['class'=>'form-control','prompt' => 'Status']),
							],
								[
									'class' => 'yii\grid\ActionColumn',
									'header' => 'Actions',	
									'template' => '{view} {update} {delete} {status}',
										'buttons' => [
											'status' => function ($url,$dataProvider) {
												
									return Html::dropDownList('action',$dataProvider->status,[''=>'Status','1'=>'Active','2'=>'Inactive'],['class'=>'dropdown','title' => 'Change Status','onchange' =>'updateStatus(this,'.$dataProvider->id.')']);
											},
										],
								],
						],
					]);
					?>
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
		if(dis.value && dis.value != '') {
			$.ajax({
					url:'<?php echo Url::home(); ?>banner/status/'+userid,
					type:'post',
					data:post,
					success:function(response){
							window.location.reload();
						}
					
				});	
		}
	}
		
	</script>
	
<!-- 
https://www.youtube.com/watch?v=NKG24GJpZRA&ebc=ANyPxKqCUTyN8weSdpN7jflaiD_La3RWILEVYA-hOEoczIKrRV7HR1TQdBaVpKDmec3d3sLRCq9yfWH5tX91RRzuktaZrM99qg
-->
