<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Update:' . ' ' . $model->video_name;
$this->params['breadcrumbs'][] = ['label' => 'Homepagevideo', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update Homepagevideo';
?>
<!-- page content -->
	<div class="right_col" role="main">
		<div class="">
			<div class="page-title">
				<div class="title_left">
					<h3>
						<?= Html::encode($this->title) ?>
					</h3>
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
						</div>
							<?= $this->render('_form', [ 
								'data' => $data,
								'model' => $model,
								//'modelImageUpload' => $modelImageUpload,
							]) ?>
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
	<script type="text/javascript" src="<?php echo Url::Home(); ?>/themes/gentelella/js/moment.min2.js"></script>
	<script type="text/javascript" src="<?php echo Url::Home(); ?>/themes/gentelella/js/datepicker/daterangepicker.js"></script>
    <script type="text/javascript">
		 $(document).ready(function () {
			
					$('.date-picker').daterangepicker({
						maxDate: new Date() ,
						singleDatePicker: true,
						showDropdowns: true,
						calender_style: "picker_4"
					});
				
		});
		
    </script>
