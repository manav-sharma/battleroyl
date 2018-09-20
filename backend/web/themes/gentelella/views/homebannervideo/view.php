<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CrudTest */

$this->title = $model->video_name;
$this->params['breadcrumbs'][] = ['label' => 'Banner', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
	
		<!-- page content -->
	<div class="right_col" role="main">
		<div class="">
			<div class="page-title">
				<div class="title_left">
					<h3>Video: <?php echo $this->title; ?></h3>
				</div>

			</div>
			<div class="clearfix"></div>

			<div class="row">

				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel" style="height:600px;">
						<div class="x_title">
							
					<p>
						<?= Html::a('Update', ['update', 'id' => $model->video_banner_id], ['class' => 'btn btn-primary']) ?>
						<?= Html::a('Delete', ['delete', 'id' => $model->video_banner_id], [
							'class' => 'btn btn-danger',
							'data' => [
								'confirm' => 'Are you sure you want to delete this item?',
								'method' => 'post',
							],
						]) ?>
					</p>

					<?= DetailView::widget([
						'model' => $model,
						'attributes' => [
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
									'encodeLabel' => false,
								],	
						],
					]) ?>
							
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
   
