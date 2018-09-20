<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\db\Query;

$this->title = 'Contestants';
$siteimage = Yii::getAlias('@siteimage');
$siteUrl = Yii::getAlias('@basepath');
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
<section class="contentArea defineFloat contestantList" id="colorBg">
	<div class="container">
		<div class="row">
			<div class="listButton">
				<div class="col-xs-12">
					<div class="topButton">
						<div class="button"> <a onclick="window.history.go(-1); return false;" href="javascript:void(0)"><i class="fa fa-angle-left" aria-hidden="true"></i> back</a> </div>
					</div>
				</div>
				<?php 	if(!empty($contestants)) { 
							if(!empty($season_id)) { 
							$details = Yii::$app->frontendmethods->getSeasonName($season_id);	
				?>
					<div class="col-xs-12 text-center">
						<h3><?php echo $details['season_name']; ?></h3>
					</div>
				<?php } ?>	
			</div>
			<?php 	foreach($contestants as $contestant_details){ 	?>
							<div class="col-md-3 col-sm-4 col-xs-4 fullBlock">
								<div class="contestantBox">
									<a href="<?php echo $siteUrl; ?>/site/contestantdetail?contestant_id=<?php echo$contestant_details['contestant_id'];?> ">
										<div class="contestantThumb"> 
											<?php if(!empty($contestant_details['images'])) { ?>
													<?php 	$i=0; 
															foreach( $contestant_details['images'] as $images) { 
																$i++;
																if($i == 1) {
													?>
														<img class="img-responsive"  src="<?php  echo CONTESTANT_IMAGE_PATH.''.$images['contestant_image']; ?>" alt=""> 
													<?php    	}    
															} 
													?>
											<?php }  else { ?>	
												<img height="54" width="54" class="img-responsive" src="<?php echo NOIMAGE107x114; ?>" alt=""> 
											<?php } ?>
										</div>
										<div class="contestantText"><?php echo $contestant_details['contestant_name']; ?> </div>
									</a>
								</div>
							</div>
			<?php 		} 	?>
			
			<div class="col-xs-12">
				<nav aria-label="Page navigation">
					<?php 
						#################= pagination =#################
						echo yii\widgets\LinkPager::widget([
							'pagination' => $pages,
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
			<?php } else {  ?>
				<div class="col-xs-12 text-center"><h3>No Contestant Found.</h3></div>
			<?php } ?>	
		</div>
	</section>
