<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\db\Query;

$this->title = 'Contestant Detail';
$siteimage = Yii::getAlias('@siteimage');
$siteUrl = Yii::getAlias('@basepath');
?>

<section class="innerBanner defineFloat">
	<div class="bannerThumb">
		<div class="container">
			<div class="col-xs-12">
				<div class="bannerText">
                	<h1 class="whiteText upperText"><?php echo $this->title; ?></h1>
                </div>
			</div>
		</div>
	</div>
</section>
<section class="contentArea defineFloat" id="colorBg">
	<div class="container">
		<?php if(!empty($contestantdetails)) { ?>
			<div class="row">
				<div class="col-xs-12">
					<div class="topButton">
						<div class="button">
							<a onclick="window.history.go(-1); return false;" href="javascript:void(0)"><i class="fa fa-angle-left" aria-hidden="true"></i>Back to contestants</a>
						</div>
					</div>
				</div>
				
				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="detailThumb">
						<?php if(!empty($images)) { ?>
							<?php 	$i=0; 
									foreach( $images as $detailimages) { 
										$i++;
										if($i == 1) {
							?>
								<img class="img-responsive"  src="<?php  echo CONTESTANT_IMAGE_PATH.''.$detailimages['contestant_image']; ?>" alt=""> 
							<?php    	}    
									} 
							?>
					<?php }  else { ?>	
						<img height="54" width="54" class="img-responsive" src="<?php echo NOIMAGE107x114; ?>" alt=""> 
					<?php } ?>
					</div>
				</div>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<div class="detailText">
						<h3><?php echo $contestantdetails['contestant_name']; ?></h3>
						<div class="socialOuter"> <span>share:</span>
							<ul class="Icons">
								<li><a href="javascript:void(0)"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li><a href="javascript:void(0)"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
								<li><a href="javascript:void(0)"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
							</ul>
						</div>
						<?php if(!empty($contestantdetails['contestant_description'])) { ?>
							<div class="bioText">Biography</div>
							<?php echo $contestantdetails['contestant_description']; ?>
						<?php } ?>	
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 c0l-xs-12">
					<div class="card">
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">images</a></li>
							<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">videos</a></li>
						</ul>
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="home">
								<div class="row">
									<?php   $countImages = count($images);
											if(!empty($images) && $countImages > 1) { 
												$x = 0;	
												foreach( $images as $detailimages) {
													$x++;
													if($x > 1) {	
									?>
														<div class="col-md-3 col-sm-3 col-xs-6 fullBlock">
															<div class="imageBlk">
																<img class="img-responsive" src="<?php  echo CONTESTANT_IMAGE_PATH.''.$detailimages['contestant_image']; ?>" alt="">
															</div>
														</div>     
									<?php  			}  
												}
											} else { 
									?>
									<div class="col-xs-12">	
										<p>No Additional images found.</p>
									</div>	
									<?php } ?>		
								</div>     	
							</div>
							<div role="tabpanel" class="tab-pane" id="profile">
								<div class="row">
									<?php   
											$links = $contestantdetails['contestant_youtubelink'];
											if(!empty($links)) {
											$linkArray = explode(",",$links);
												$i=0;
												foreach($linkArray as $yotubevalue) {
													$i++;
													$url = $yotubevalue; 
													parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
													if(!empty($my_array_of_vars)) {
													$value = $my_array_of_vars['v'];            
									?>
														<div class="col-md-3 col-sm-3 col-xs-6 fullBlock">
															<div class="imageBlk">
																<iframe class="yt_players" id="player<?php echo $i; ?>" width="100%" height="100%" src="http://www.youtube.com/embed/<?php echo $value;  ?>?rel=0&wmode=Opaque&enablejsapi=1;showinfo=0;controls=0" frameborder="0" allowfullscreen></iframe>
															</div>
														</div> 
									<?php 			} 
												} 
											} else { 
									?>	
										<div class="col-xs-12">	
											<p>No Videos found.</p>
										</div>	
									<?php } ?>		  
									      
								</div>     	
							</div>     
						</div>
					</div>
				</div>
			</div>
		<?php } else {  ?>
			
			<div class="col-xs-12">
				<h3> No Information Found.</h3>
			</div>
		<?php } ?>		
   </div>
</section>
<script type="text/javascript" src="http://www.youtube.com/player_api"></script>
<script type="text/javascript">
	players = new Array();
	function onYouTubeIframeAPIReady() {
		var temp = $("iframe.yt_players");
		for (var i = 0; i < temp.length; i++) {
			var t = new YT.Player($(temp[i]).attr('id'), {
				events: {
					'onStateChange': onPlayerStateChange
				}
			});
			players.push(t);
		}
	}
	onYouTubeIframeAPIReady();

	function onPlayerStateChange(event) {
		if (event.data == YT.PlayerState.PLAYING) {
			var temp = event.target.a.src;
			var tempPlayers = $("iframe.yt_players");
			for (var i = 0; i < players.length; i++) {
				if (players[i].a.src != temp) 
					players[i].stopVideo();
			}
		}
	}
</script>
