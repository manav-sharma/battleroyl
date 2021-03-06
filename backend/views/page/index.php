<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Pages';
$this->params['breadcrumbs'][] = $this->title;
$CtrlName	 =	Yii::$app->controller->id;
$FunName	 =	Yii::$app->controller->action->id;
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
					<?= Html::a('<i class="fa fa-plus"></i> Add Page', ['create'], ['class' => 'btn btn-success']) ?>
					<?= Html::button('Apply Filter', ['class' => 'btn btn-primary','id'=>'btnfilterApply','style'=>'float:right']) ?>
				</p>
				<?php Pjax::begin(['id' => 'Pjax_Menufilter', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET']]); ?> 
				<?= GridView::widget([
					'id'=>'grid_page_container',
					'dataProvider' => $dataProvider,
					'filterModel' => $searchModel,
					'columns' => [
						['class' => 'yii\grid\SerialColumn'],
						'pageName',
						'pageTitle',
						'pageType',
						[
							'attribute'=>'pageDateCreated',
							'value'=>'pageDateCreated',
							'filterOptions' => ['id' => 'tdDateCreated'],
						],
						'status',		
						['class' => 'yii\grid\ActionColumn',
							'template'=>'{view} {update} {delete} {status}',
								'buttons' => [
									'status' => 
											function ($url,$dataProvider) {
												return Html::dropDownList('action',$dataProvider->status,[''=>'Status','Active'=>'Active','Inactive'=>'Inactive'],['class'=>'dropdown','title' => 'Change Status','onchange' =>'updateStatus(this,'.$dataProvider->id.')']);
											},
								],
								'header' => '&nbsp;&nbsp;&nbsp;Actions&nbsp;&nbsp;&nbsp;&nbsp;',	
						],
					],
				]); ?>
				<div class="col-md-3 col-sm-3 col-xs-6 page_limit_layout">
					<select id="propertiessearch-pagesize" name="PropertiesSearch[pagesize]" class="form-control">
						<option value="5">5</option>
						<option value="30" <?php echo (isset($_GET['p']) && $_GET['p'] == 30) ? 'selected' : ''; ?>>30</option>
						<option value="50" <?php echo (isset($_GET['p']) && $_GET['p'] == 50) ? 'selected' : ''; ?>>50</option>
						<option value="100" <?php echo (isset($_GET['p']) && $_GET['p'] == 100) ? 'selected' : ''; ?>>100</option>
					</select>
				</div>
				<script>
					/*#### pagination limit ####*/
					$(document).ready(function () {	
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

<!-- daterangepicker -->
<script type="text/javascript" src="<?php echo Url::home(); ?>/themes/gentelella/js/moment.min2.js"></script>
<script type="text/javascript" src="<?php echo Url::Home(); ?>/themes/gentelella/js/datepicker/daterangepicker.js"></script>
<script type="text/javascript">
		$(document).ready(function () {			 
			$('#tdDateCreated input').daterangepicker({
				singleDatePicker: true,
				calender_style: "picker_4"
			});
		});
		$(document).on('pjax:complete', function() {
			$('#tdDateCreated input').daterangepicker({
				singleDatePicker: true,
				calender_style: "picker_4"
			});
		});
	</script>
