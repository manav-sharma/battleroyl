<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Subcity;
$this->title = $model->season_name;
$this->params['breadcrumbs'][] = ['label' => 'Service', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$parentCity = new Subcity();
$val = $parentCity->getparentname($model->seasonMainCity_Id);
if($model->seasonSubCity_Id != '0') {
	$subVal =  $parentCity->getSubCityName($model->seasonSubCity_Id);
	$cityName = $subVal->sub_city_name;
} else {
	$cityName = '';
}

if($model->status == '1') {
	$status = 'Open';
} else if($model->status == '2'){
	$status = 'Close';
} else {
	$status = 'Inactive';
}

?>
	<!-- page content -->
	<div class="right_col" role="main">
		<div class="">
			<div class="page-title">
				<div class="title_left">
					<h3>Seasons: <?php echo $this->title; ?></h3>
				</div>

			</div>
			<div class="clearfix"></div>

			<div class="row">

				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel" style="height:600px;">
						<div class="x_title">
							
					<p>
						<?= Html::a('Update', ['update', 'id' => $model->season_id], ['class' => 'btn btn-primary']) ?>
						<?= Html::a('Delete', ['delete', 'id' => $model->season_id], [
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
									'attribute' => 'season_name',
									'label' => 'Season Name',
									'encodeLabel' => false,
								],
								[
									'attribute' => 'season_year',
									'label' => 'Season Year',
									'encodeLabel' => false,
								],														
								[
									'attribute' => 'season_description',
									'label' => 'Season Description',
									'encodeLabel' => false,
									'value' => 	strip_tags($model->season_description),         
												
								],
								[
									'attribute' => 'seasonMainCity_Id',
									'label' => 'Season Main Region',
									'encodeLabel' => false,
									'value' => 	$val->main_city_name,            
												
								],
								
								[
									'attribute' => 'seasonSubCity_Id',
									'label' => 'Season Sub Region',
									'encodeLabel' => false,
									'value' => 	$cityName,            
												
								],
								
								[
									'attribute' => 'season_venue',
									'label' => 'Season Venue',
									'encodeLabel' => false,
									'value' => 	strip_tags($model->season_venue),            
												
								],
								
								[
									'attribute' => 'status',
									'label' => 'Season Status',
									'encodeLabel' => false,
									'value' => 	$status,            
												
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
   
