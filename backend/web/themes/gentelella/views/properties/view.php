<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Properties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
	<!-- page content -->
	<div class="right_col" role="main">
		<div class="">
			<div class="page-title">
				<div class="title_left">
					<h3>Properties: <?php echo $this->title; ?></h3>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
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
									'attribute' => 'reference_number',
									'label' => 'Reference Number',
									'encodeLabel' => false,
								],
								[
									'attribute' => 'usermembership',
									'label' => 'Membership Plan',
									'value'=> (isset($model->usermembership->package->name) ? $model->usermembership->package->name : '--'),
								],																								
								[
									'attribute' => 'property_type',
									'label' => 'Property Type',
									'encodeLabel' => false,
								],
								[
									'attribute' => 'property_for',
									'label' => 'Property For',
									'encodeLabel' => false,
								],
								[
									'attribute' => 'country',
									'label' => 'Country',
									'encodeLabel' => false,
								],
								[
									'attribute' => 'region',
									'label' => 'Region',
									'encodeLabel' => false,
								],
								[
									'attribute' => 'city',
									'label' => 'City',
									'encodeLabel' => false,
								],
								[
									'attribute' => 'build_year',
									'label' => 'Build Year',
									'encodeLabel' => false,
								],
								[
									'attribute' => 'area',
									'label' => 'Area',
									'encodeLabel' => false,
								],
								[
									'attribute' => 'rooms',
									'label' => 'Rooms',
									'encodeLabel' => false,
								],
								[
									'attribute' => 'floors',
									'label' => 'Floors',
									'encodeLabel' => false,
								],	
								[
									'attribute' => 'price',
									'label' => 'Price',
									'encodeLabel' => false,
								],
								[
									'attribute' => 'specification',
									'label' => 'Specification',
									'encodeLabel' => false,
								],	
								[
									'attribute' => 'description',
									'label' => 'Description',
									'encodeLabel' => false,
								],	
								[
									'attribute' => 'property_right',
									'label' => 'Property Rights',
									'encodeLabel' => false,
								],	
								[
									'attribute' => 'added_by',
									'label' => 'Added By',
									'encodeLabel' => false,
								],	
								[
									'attribute' => 'user',
									'label' => 'Username',
									'value'=> (isset($model->added_by) && $model->added_by == 'Admin' ? 'Admin' : (isset($model->user->firstname) ? $model->user->firstname : ''). ' '. (isset($model->user->lastname) ? $model->user->lastname : '')),
								],
								[
									'attribute' => 'expiry_date',
									'label' => 'Expiry date',
									'format' => 'date',
								],								
								[
									'attribute' => 'updated_at',
									'label' => 'Date Updated',
									'format' => 'date',
								],
								[
									'attribute' => 'created_at',
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
   
