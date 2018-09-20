<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\db\Query;
$this->title = 'Archives';
$siteimage = Yii::getAlias('@siteimage');
$siteUrl = Yii::getAlias('@basepath');
$parenCity 	= 	Yii::$app->getRequest()->getQueryParam('parentCity');
$subCity   	=  	Yii::$app->getRequest()->getQueryParam('subCity');
if(!empty(Yii::$app->getRequest()->getQueryParam('year'))){
	$year = Yii::$app->getRequest()->getQueryParam('year');
} else {
	$lastclosedSeason = Yii::$app->frontendmethods->getLastClosedSeason();
	if(!empty($lastclosedSeason )) {
		$year = $lastclosedSeason['season_year'];
	} else {
		$year = date("Y",strtotime("-1 year"));
	}	
}
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
<section class="contentArea defineFloat" id="colorBg">
	<div class="container">
		<?php if(isset($archiveDetails) && !empty($archiveDetails)) { ?>
			<div class="row">
				<?php if(!empty($archiveDetails['yearDeatils'])) { ?>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<div class="leftNav">
							<ul>
								<?php foreach($archiveDetails['yearDeatils'] as $archiveYear) {  
									  if($year == $archiveYear['season_year']) { $class = 'active'; } else { $class = ''; }
								?>
									<li class="<?php  echo $class; ?>">
										<a href="<?php echo $siteUrl; ?>/site/archives?parentCity=<?php echo $parenCity; ?>&subCity=<?php echo $subCity; ?>&year=<?php echo $archiveYear['season_year']; ?>"><?php echo $archiveYear['season_year']; ?></a>
									</li>
								<?php } ?>	
							</ul>
						</div>
					</div>
				<?php } ?>
				<div class="col-md-offset-1 col-md-9 col-sm-9 col-xs-12">
					<?php  if(!empty($archiveDetails['winnerDetails'])) {  ?>
						<div class="winnerBox">
							<div class="row">
								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="archiveThumb"> 
										<?php if(!empty($archiveDetails['winnerDetails']['contestant_image'])) { ?>
											<img class="img-responsive"  src="<?php  echo CONTESTANT_IMAGE_PATH.''.$archiveDetails['winnerDetails']['contestant_image']; ?>" alt=""> 
										<?php }  else { ?>	
											<img  class="img-responsive" src="<?php echo NOIMAGE107x114; ?>" alt=""> 
										<?php } ?> 
									</div>
								</div>
								<div class="col-md-8 col-sm-8 col-xs-12">
									<div class="borderBox defineFloat">
										<h2 class="pink"><span>Winner</span> <?php echo $archiveDetails['season_details']['season_year'];  ?></h2>
									</div>
									<h3><?php echo $archiveDetails['winnerDetails']['contestant_name']; ?></h3>
									<div class="winnerThumb"> <i class="fa fa-map-marker" aria-hidden="true"></i> </div>
									<div class="winnerText">
									  <p>From</p>
									  <span>Lagos, Nigeria</span> 
									</div>
								</div>
							</div>
						</div>
					<?php } ?>	
					<?php if(!empty($archiveDetails['runnerUpDeatils'])) { ?>
						<div class="row">
							<div class="col-md-4 col-sm-4 col-xs-6 fullBlock">
								<div class="runnerThumb"> 
									<img class="img-responsive" src="<?php echo $siteimage ?>/runnerimg.jpg" alt="">
								</div>
							</div>
							<?php foreach($archiveDetails['runnerUpDeatils'] as $runnerupDetails) { ?>
								<div class="col-md-4 col-sm-4 col-xs-6 fullBlock">
									<div class="runnerThumb"> 
										<?php if(!empty($runnerupDetails['contestant_image'])) { ?>
											<img class="img-responsive"  src="<?php  echo CONTESTANT_IMAGE_PATH.''.$runnerupDetails['contestant_image']; ?>" alt=""> 
										<?php }  else { ?>	
											<img  class="img-responsive" src="<?php echo NOIMAGE107x114; ?>" alt=""> 
										<?php } ?> 
									</div>
									<div class="runnerDetail">
										<p><?php echo $runnerupDetails['contestant_name']; ?></p>
										<?php if($runnerupDetails['result'] == 2) { ?>
											<span>1st Runner up</span> 
										<?php } else {  ?>
											<span>2nd Runner up</span>
										<?php } ?>		
									</div>
								</div>
							<?php } ?>
						</div>
					<?php } ?>	
					<?php if(!empty($archiveDetails['contestantDeatils'])) { ?>
						<div class="row">
							<div class="col-xs-12">
								<div class="borderTop ">
									<div class="pull-left">
										<div class="topText upperText"> Contestants </div>
									</div>
									<div class="pull-right">
										<div class="topButton archiveButton">
											<div class="button"><a href="<?php echo $siteUrl; ?>/site/viewarchivecontestant?season_id=<?php echo $archiveDetails['season_details']['season_id'] ?>">view all <i class="fa fa-angle-right" aria-hidden="true"></i> </a></div>
										</div>
									</div>
								</div>
							</div>
							<?php   foreach($archiveDetails['contestantDeatils'] as $contestantDetails)  { ?>
								<div class="col-md-4 col-sm-4 col-xs-6 fullBlock">
									<div class="contestantBox">
										<a href="<?php echo $siteUrl; ?>/site/contestantdetail?contestant_id=<?php echo$contestantDetails['contestant_id'];?>">
											<div class="contestantThumb"> 
												<?php if(!empty($contestantDetails['contestant_image'])) { ?>
											<img class="img-responsive"  src="<?php  echo CONTESTANT_IMAGE_PATH.''.$contestantDetails['contestant_image']; ?>" alt=""> 
										<?php }  else { ?>	
											<img  class="img-responsive" src="<?php echo NOIMAGE107x114; ?>" alt=""> 
										<?php } ?> 
											</div>
											<div class="contestantText"> <?php echo $contestantDetails['contestant_name']; ?> </div>
										</a>
									</div>
								</div>
							<?php } ?>	
						</div>
					<?php } ?>	
					<?php if(!empty($archiveDetails['seasonGroupImages'])) { ?>
						<div class="row">
							<div class="col-xs-12">
								<div class="borderTop noMargin ">
									<div class="topText upperText"> Group pictures </div>
								</div>
								<?php 	$n = 0; 
										foreach($archiveDetails['seasonGroupImages'] as $groupImages) {
										$n++;
										if($n%2==0){ $class = 'rightThumb'; } else { $class = 'leftThumb';  }	
								?>
									<div class="<?php echo $class; ?>"> 
										<img class="img-responsive" src="<?php  echo GROUP_IMAGE_PATH.''.$groupImages['group_image']; ?>" alt=""> 
									</div>
								<?php } ?>
							</div>
						</div>
					<?php }  ?>
				</div>
			<?php } else {  ?>
				<p>No Archives Found.</p>
			<?php } ?>		
		</div>
	</section>
