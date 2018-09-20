<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Advertisements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
	<div class="right_col" role="main">
		<div class="">
			<div class="page-title">
				<div class="title_left">
					<h3>Advertisement: <?php echo $this->title; ?></h3>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<p>
								<?= Html::a('Update advertisement image', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
											//'attribute' => 'package.name',
											'attribute' => 'membership_id',
											'label' => 'Package',
											'encodeLabel' => false,
										],
										[
											'attribute' => 'name',
											'label' => 'Advertisement Name',
											'encodeLabel' => false,
										],
										[
											'attribute' => 'advertisement_image',
											'label' => 'Advertisement Image',
											'value'=> Html::img(SITE_URL.'common/uploads/images/'.$model->advertisement_image, ['alt'=>'some', 'class'=>'thing','width'=>400,'height'=>100]),
											'format' => 'raw',
										],
										[
											'attribute' => 'user_images',
											'label' => 'Images',
											'format' => 'raw',
										],
										[
											'attribute' => 'description',
											'label' => 'Description',
											'encodeLabel' => false,
										],										
										[
											'attribute' => 'start_date',
											'label' => 'Start date',
											'encodeLabel' => false,
										],
										[
											'attribute' => 'end_date',
											'label' => 'End date',
											'encodeLabel' => false,
										],
										[
											//'attribute' => 'user.name',
											'attribute' => 'user_id',
											'label' => 'User',
											'encodeLabel' => false,
										],
										[
											'attribute' => 'approved',
											'label' => 'Approved By Admin',
											'value'=> isset($model->approved) && $model->approved == '1' ? 'Approved' : isset($model->approved) && $model->approved == '2' ? 'Declined' : 'Pending',
											'encodeLabel' => false,
										],
										[
											'attribute' => 'status',
											'label' => 'Status',
											'value' => isset($model->status) && $model->status == '1' ? 'Active' : 'Inactive',
											'encodeLabel' => false,
										],
										[
											'attribute' => 'date_created',
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
