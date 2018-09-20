<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\seasons\Seasons;
$this->title = $model->contestant_name;
$this->params['breadcrumbs'][] = ['label' => 'Service', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
if($model->result == 1){
	$result = 'Winner';
} else if($model->result == 2){
	$result = '1st Runner up';
} else if($model->result == 3){
	$result = '2nd Runner up';
} else {
	$result = 'Participant';
}

$getSeason = new Seasons();
$name = $getSeason->getSeasonName($model->season_id);

?>
	<!-- page content -->
	<div class="right_col" role="main">
		<div class="">
			<div class="page-title">
				<div class="title_left">
					<h3>Contestant: <?php echo $this->title; ?></h3>
				</div>

			</div>
			<div class="clearfix"></div>

			<div class="row">

				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel" style="height:600px;">
						<div class="x_title">
							
					<p>
						<?= Html::a('Update', ['update', 'id' => $model->contestant_id], ['class' => 'btn btn-primary']) ?>
						<?= Html::a('Delete', ['delete', 'id' => $model->contestant_id], [
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
									'attribute' => 'contestant_name',
									'label' => 'Contestant Name',
									'encodeLabel' => false,
								],	
								[
									'attribute' => 'contestant_votes',
									'label' => 'Contestant Votes',
									'encodeLabel' => false,
									
												
								],								
								[
									'attribute' => 'result',
									'label' => 'Result',
									'encodeLabel' => false,	
									'value' => $result 		
								],

								[
									'attribute' => 'season_id',
									'label' => 'Season Name',
									'encodeLabel' => false,	
									'value' => $name->season_name		
								],
								[
									'attribute' => 'contestant_youtubelink',
									'label' => 'Contestant Youtubelinks',
									'encodeLabel' => false,
									      
												
								],											
								[
									'attribute' => 'contestant_description',
									'label' => 'Contestant Description',
									'encodeLabel' => false,
									'value' => 	strip_tags($model->contestant_description),         
												
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
   
