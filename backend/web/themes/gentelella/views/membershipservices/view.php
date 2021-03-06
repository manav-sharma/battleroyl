<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Memberships', 'url' => ['/memberships/index']];
$this->params['breadcrumbs'][] = ['label' => 'Membership Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
	<!-- page content -->
	<div class="right_col" role="main">
		<div class="">
			<div class="page-title">
				<div class="title_left">
					<h3>Membership Service: <?php echo $this->title; ?></h3>
				</div>

			</div>
			<div class="clearfix"></div>

			<div class="row">

				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel" style="height:600px;">
						<div class="x_title">
							
					<p>
						<?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
						<?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
									'attribute' => 'name',
									'label' => 'Name',
									'encodeLabel' => false,
								],																
								[
									'attribute' => 'description',
									'label' => 'Description',
									'encodeLabel' => false,
								],
								[
									'attribute' => 'allowed_service',
									'label' => 'Permissions',
									'encodeLabel' => false,
								],
								[
									'attribute' => 'number_of_access',
									'label' => 'Number of access',
									'encodeLabel' => false,
								],	
								[
									'attribute' => 'service_type',
									'label' => 'Service',
									'encodeLabel' => false,
								],	
								[
									'attribute' => 'package.name',
									'label' => 'Membership Plan',
									'encodeLabel' => false,
								],																																
								[
									'attribute' => 'datetime',
									'label' => 'Date Created',
									'format' => 'date',
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
   
