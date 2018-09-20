<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Comment Description';
$this->params['breadcrumbs'][] = ['label' => 'Service', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
	<!-- page content -->
	<div class="right_col" role="main">
		<div class="">
			<div class="page-title">
				<div class="title_left">
					<h3>Faq: <?php echo $this->title; ?></h3>
				</div>

			</div>
			<div class="clearfix"></div>

			<div class="row">

				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel" style="height:600px;">
						<div class="x_title">
							
					<p>
						<?= Html::a('Update', ['update', 'id' => $model->comment_id], ['class' => 'btn btn-primary']) ?>
						<?= Html::a('Delete', ['delete', 'id' => $model->comment_id], [
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
								'attribute' => 'user',
								'label' => 'Username',
								'encodeLabel' => false,
								'value'=> $model->user->firstname.' '.$model->user->lastname,
							],					
							[
								'attribute' => 'post',
								'label' => 'Post Title',
								'encodeLabel' => false,
								'value'=> $model->post->name,
							],								
							[
								'attribute' => 'comment_description',
								'label' => 'Description',
								'encodeLabel' => false,
								'value' => 	strip_tags($model->comment_description)
							],
							[
								'attribute' => 'date_created',
								'label' => 'Date Created',
								'filterOptions' => ['comment_id' => 'tdDateCreated'],
								'format' => 'datetime',
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
   
