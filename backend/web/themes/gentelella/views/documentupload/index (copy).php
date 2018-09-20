<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;  
use yii\helpers\ArrayHelper;

$this->title = 'Documents';
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
								<?= Html::a('<i class="fa fa-plus"></i> Add Document', ['create'], ['class' => 'btn btn-success']) ?>
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
											'attribute' => 'title',
											'label' => 'Name',
											'encodeLabel' => false,
										],
										[
											'attribute' => 'category.name',
											'label' => 'Category Name',
											'encodeLabel' => false,
										],
										[
											'attribute' => 'description',
											'label' => 'Description',
											'encodeLabel' => false,
										],
										[
											'attribute' => 'document_type',
											'label' => 'Document Type',
											'encodeLabel' => false,
										],
										[
											'attribute' => 'datetime',
											'label' => 'Date Created',
											'filterOptions' => ['id' => 'tdDateCreated'],
											'format' => 'date',
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
														
											return Html::dropDownList('action',$dataProvider->status,['1'=>'Active','2'=>'Inactive'],['class'=>'dropdown','title' => 'Change Status','onchange' =>'updateStatus(this,'.$dataProvider->id.')']);
													},
												],
										],
								],
							]);
							?>
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
	 //~ $(document).ready(function () {
			//~ $('#tdDateCreated input').daterangepicker({
				//~ singleDatePicker: true,
				//~ calender_style: "picker_4"
			//~ });
	//~ });	
//~ 
	//~ $(document).on('pjax:complete', function() {
			//~ $('#tddatetime input').daterangepicker({
				//~ singleDatePicker: true,
				//~ calender_style: "picker_4"
			//~ });
	//~ });
    $(document).ready(function(){
        $('.x_title').on('click', '#resetFilter', function(){
            $('.filters').find('input').val('');
            $("#grid-container").yiiGridView("applyFilter");
        });

        $('.x_title').on('click', '#btnfilterApply', function(){
            $("#grid-container").yiiGridView("applyFilter");
        });
    });
	function updateStatus(dis,userid) {
		var post = {'UpdateDocument':{'status':dis.value}};	
		if(dis.value && dis.value != '') {
			$.ajax({
					url:'<?php echo Url::home(); ?>documentupload/status/'+userid,
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
