<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\db\Query;

$this->title = 'Standings';
$siteimage = Yii::getAlias('@siteimage');
$siteUrl = Yii::getAlias('@basepath');
$CtrlName	= Yii::$app->controller->id;
//echo '<pre>'; print_r($standings['contestants']);
?>

<section class="innerBanner defineFloat">
	<div class="bannerThumb">
		<div class="container">
			<div class="col-xs-12">
				<div class="bannerText">
					<h1 class="whiteText upperText"><?php echo $this->title ; ?></h1>
				</div>
			</div>
		</div>	
	</div>	
</section>
<?php 
    if(isset($standings) && !empty($standings)) {	
	$countContestant  = count($standings['contestants']);
	if(!empty($standings['contestants']) && $countContestant > 1) { ?>
	<section class="winnerOuter defineFloat">
		<div class="container">
			<div class="winnerBox standingBox">
				<div class="row">
					<div class="col-md-3 col-sm-3 col-xs-12">
						<div class="archiveThumb"> 
							<?php if(!empty($standings['highestvote_contestant']['contestant_image'])) { ?>
								<img class="img-responsive"  src="<?php  echo CONTESTANT_IMAGE_PATH.''.$standings['highestvote_contestant']['contestant_image']; ?>" alt=""> 
							<?php }  else { ?>	
								<img  class="img-responsive" src="<?php echo NOIMAGE107x114; ?>" alt=""> 
							<?php } ?> 
						</div>
					</div>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="borderBox defineFloat">
							<h2 class="pink"><span>highest</span> votes</h2>
							<?php 	$parentCity = Yii::$app->frontendmethods->parentCities(); 
									if($parentCity) {
									$getParentCity = Yii::$app->getRequest()->getQueryParam('parentCity');	
							?>
							<form name="regions" method="get" id="regions">
								<div class="selectBox">
									<select id="mainCity" name="parentCity" class="form-control">
										<option value="">Select Main Region</option>
										<?php foreach($parentCity as $pcities) {  ?>
										<option <?php if($getParentCity == $pcities['main_city_id'] ) { echo 'selected'; } ?> value="<?php echo $pcities['main_city_id']; ?>"><?php echo $pcities['main_city_name']; ?></option>	
										<?php } ?>	
									</select>
								</div>
								<?php  if(isset($getParentCity) && !empty($getParentCity)) { 
									   $subCity = Yii::$app->frontendmethods->subcities($getParentCity); 
								?>
									<div class="selectBox">
										<select name="subCity" id="subCity" class="form-control">
											<option value="">Select Sub Region</option>
											<?php foreach($subCity as $scities) {  ?>
												<option <?php if($getParentCity == $scities['sub_city_id'] ) { echo 'selected'; } ?> value="<?php echo $scities['sub_city_id']; ?>"><?php echo $scities['sub_city_name']; ?></option>	
											<?php } ?>	
										</select>
									</div>
								<?php } ?>	
							</form>	
							<?php } ?>	
						</div>
						<h3><?php echo $standings['highestvote_contestant']['contestant_name']; ?></h3>
							<div class="winnerText">
								<p>Total number of Votes </p>
								<span><?php echo $standings['highestvote_contestant']['contestant_votes']; ?></span> 
							</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php } ?>	
<section class="contentArea defineFloat" id="colorBg">
	<div class="container">
		<div class="row">
			<?php  if(isset($standings['contestants']) && !empty($standings['contestants'])) { ?>
			<?php 		$i = 0;
						foreach($standings['contestants'] as $contestant_details){ 
						$i++;		
			?>
							<div class="col-md-3 col-sm-4 col-xs-6 fullBlock">
								<div class="contestantBox">
									<div class="contestantThumb"> 
									<?php if(!empty($contestant_details['images'])) { ?>
									<?php 	$x=0; 
											foreach( $contestant_details['images'] as $images) { 
												$x++;
												if($x == 1) {
									?>
													<img class="img-responsive"  src="<?php  echo CONTESTANT_IMAGE_PATH.''.$images['contestant_image']; ?>" alt=""> 
									<?php    	}    
											} 
									?>
									<?php }  else { ?>	
											<img height="54" width="54" class="img-responsive" src="<?php echo NOIMAGE107x114; ?>" alt=""> 
									<?php } ?> 
							<?php 
								$page = Yii::$app->getRequest()->getQueryParam('page');
								if ($page == 1 || $page == '') {
								  $count = $i;
								} else {
								   $count = ($page - 1) * 12 + $i;
								}
								//if($countContestant > 2) { ?>	
								<span><?php echo $count; //echo $i; ?></span> 
							<?php //} ?>
							</div>	
									<div class="contestantText"><a href="<?php echo $siteUrl; ?>/site/contestantdetail?contestant_id=<?php echo$contestant_details['contestant_id'];?> "><?php echo $contestant_details['contestant_name']; ?></a> </div>
									<div class="detailBlk">
										<p>Total number of Votes </p>
										<span><?php echo $contestant_details['contestant_votes']; ?></span> 
									</div>
								</div>
							</div>
			<?php  		}   ?>	
		
				<div class="col-xs-12">
					<nav aria-label="Page navigation">
						<?php 
							#################= pagination =#################
							echo yii\widgets\LinkPager::widget([
								'pagination' => $standings['pages'],
								'pageSize' => 2,
								'prevPageLabel' => '<i class="fa fa-angle-left" aria-hidden="true"></i>',
								'nextPageLabel' => '<i class="fa fa-angle-right" aria-hidden="true"></i>',
								'activePageCssClass' => 'active',
								'disabledPageCssClass' => 'disabled',
								'prevPageCssClass' => 'enable',
								'nextPageCssClass' => 'enable',
								'hideOnSinglePage' => true
							]);
						?>    
					</nav>
				</div>
			<?php }  else { ?>
				<div class="topButton">
						<div class="button">
							<a onclick="window.history.go(-1); return false;" href="javascript:void(0)"><i class="fa fa-angle-left" aria-hidden="true"></i>Back to contestants</a>
						</div>
					</div>
				<div class="col-xs-12 text-center"><h3>No Contestant Found.</h3></div>
			<?php } ?>	
		</div>
	</div>
</section>
<?php }  else {  ?>
	<section class="contentArea defineFloat" id="colorBg">
		<div class="container">
			<div class="row">
				<div class="topButton">
						<div class="button">
							<a onclick="window.history.go(-1); return false;" href="javascript:void(0)"><i class="fa fa-angle-left" aria-hidden="true"></i>Back to contestants</a>
						</div>
					</div>
				<div class="col-xs-12 text-center"><h3>No Contestant Found.</h3></div>
		</div>
	</div>
</section>
<?php } ?>	
	
<script>
$(document).ready(function() {
	$('#mainCity').on('change', function() {
		$("select#subCity").html(' ');
		var check = $("select#mainCity option:checked" ).val();
		if(check != ""){
			$.ajax({
				url:'<?php echo Url::home().$CtrlName; ?>/subcities',
				type:'post',
				data:'parent_id='+check,
				success:function(response){
					var obj = JSON.parse(response);
					if(obj != '') {
						var options = '';
						options += '<option value=""> Select Sub Region</option>';
						for (var i = 0; i < obj.length; i++) {
							options += '<option value="' + obj[i].sub_city_id + '">' + obj[i].sub_city_name + '</option>';
						}
						$("select#subCity").append(options);
					} else {
						var options = '';
						options += '<option value="0"> Select Sub Region</option>';
						$("select#subCity").append(options);
						$('form#regions').submit();
					}
				}
			});
		}
	});
	
	$('#subCity').on('change', function() {
		var check = $("select#subCity option:checked" ).val();
		if(check !=""){
			this.form.submit();
		}
	});	
});
</script>
