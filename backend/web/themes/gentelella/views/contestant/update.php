<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Update Contestant: ' . ' ' . $model->contestant_name;
$this->params['breadcrumbs'][] = ['label' => 'Contestant', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update Contestant';
$CtrlName	=	Yii::$app->controller->id;
$FunName	=	Yii::$app->controller->action->id;
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
								'modelImageUpload' => $modelImageUpload,
								'mediaArr'=>$mediaArr,
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
	<script src="<?php echo Url::Home(); ?>themes/gentelella/js/uploadmulti.js">
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
			
			/*########### delete media files of propertes ###########*/
			$('.mediaKey').on('click', function(e){
				e.preventDefault();
				var media_id = this.id;
				var post = {'update':{'status':media_id}};	
				if(media_id && media_id != '') {
					$.ajax({
							url:'<?php echo Url::home().$CtrlName; ?>/deletepmedia/'+media_id,
							type:'post',
							data:post,
							success:function(response){
									$("."+media_id).remove();
								}
						});
				}
			});		
				
		});
		
    </script>
