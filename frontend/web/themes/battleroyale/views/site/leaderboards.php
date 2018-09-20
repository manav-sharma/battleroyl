<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\db\Query;

$this->title = 'Leader Boards';
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
<?php 	
	$countContestant  = count($leaderboards);
	if(!empty($leaderboards) && $countContestant > 1) { ?>
	<section class="winnerOuter defineFloat">
		<div class="container">
			<div class="winnerBox standingBox">
				<div class="row">
					<div class="col-md-3 col-sm-3 col-xs-12">
						<div class="archiveThumb"> 
							<?php if(!empty($highestvote_contestant['contestant_image'])) { ?>
								<img class="img-responsive"  src="<?php  echo CONTESTANT_IMAGE_PATH.''.$highestvote_contestant['contestant_image']; ?>" alt=""> 
							<?php }  else { ?>	
								<img  class="img-responsive" src="<?php echo NOIMAGE107x114; ?>" alt=""> 
							<?php } ?> 
						</div>
					</div>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="borderBox defineFloat">
							<h2 class="pink"><span>highest</span> votes</h2>
						</div>
						
							<h3><?php echo $highestvote_contestant['contestant_name']; ?></h3>
							<div class="winnerText">
								<p>Total number of Votes </p>
								<span><?php echo $highestvote_contestant['contestant_votes']; ?></span> 
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
			<?php 	if(!empty($leaderboards)) { ?>
				<?php 	$i = 0;
						foreach($leaderboards as $contestant_details){ 
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
							if($countContestant > 2) { ?>	
								<span><?php echo $i; ?></span> 
							<?php } ?>	
							</div>
							<div class="contestantText"><a href="<?php echo $siteUrl; ?>/site/contestantdetail?contestant_id=<?php echo$contestant_details['contestant_id'];?> "><?php echo $contestant_details['contestant_name']; ?></a> </div>
							<div class="detailBlk">
								<p>Total number of Votes </p>
								<span><?php echo $contestant_details['contestant_votes']; ?></span> 
							</div>
						</div>
					</div>
				<?php } ?>
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
			<?php } else { ?>	
				<div class="col-xs-12 text-center"><h3>No Contestant Found.</h3></div>
			<?php } ?>	
		</div>
	</div>
</section>
