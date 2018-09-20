<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Business', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
	<div class="right_col" role="main">
		<div class="">
			<div class="page-title">
				<div class="title_left">
					<h3>Business: <?php echo $this->title; ?></h3>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<p>
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
											'attribute' => 'photos',
											'label' => 'Image',
											'value'=> Html::img(SITE_URL.'common/uploads/images/'.$model->photos, ['alt'=>'some', 'class'=>'thing','width'=>400,'height'=>100]),
											'format' => 'raw',
										],								
										[
											//'attribute' => 'package.name',
											'attribute' => 'property_type',
											'label' => 'Property Type',
											'encodeLabel' => false,
										],
										[
											'attribute' => 'title',
											'label' => 'Business Opportunity',
											'encodeLabel' => false,
										],
										[
											'attribute' => 'price',
											'label' => 'Price',
											'encodeLabel' => false,
										],
										[
											'attribute' => 'description',
											'label' => 'Description',
										],
										[
											'attribute' => 'description',
											'label' => 'Description',
											'encodeLabel' => false,
										],
										[
											'attribute' => 'status',
											'label' => 'Status',
											'value' => isset($model->status) && $model->status == '1' ? 'Active' : 'Inactive',
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
