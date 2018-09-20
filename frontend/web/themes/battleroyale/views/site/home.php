<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\db\Query;

$this->title = 'Home';
$siteimage = Yii::getAlias('@siteimage');
$siteUrl = Yii::getAlias('@basepath');
$banner = Yii::$app->frontendmethods->frontendbannerhome();
if(!empty($videos)) {
	$countVideos = count($videos);
	$playerCount = $countVideos + 1;
} else {
	$playerCount = '1';
}
$bannerVideo = Yii::$app->frontendmethods->frontendbannervideo();
?>
<section class="landingPage home" style="background:url(<?php echo BANNER_IMAGE_PATH.'/'.$banner['bannerImage']; ?>) no-repeat center center;background-attachment: fixed;background-size: cover;">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="logo logo-all"><img src="<?php echo $siteimage;?>/logo.png" alt=""></div>
				<div class="title"> <?php echo $banner['title']; ?> <span><?php echo $banner['description']; ?></span> </div>
				<div class="socialIcons socialIcons-all">
					<ul>
						<li><a class="facebook" href="javascript:void(0)"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
						<li><a class="twiter" href="javascript:void(0)"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
						<li><a class="instagram" href="javascript:void(0)"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
						<li><a class="youtube" href="javascript:void(0)"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
					</ul>
				</div>
				<?php   if(!empty($bannerVideo)){ ?>
					<div class="watch-main"> 
						<a class="watchVideo" href="javascript:void(0)" class=""><img class="img-responsive" src="<?php echo $siteimage;?>/watch.png" alt=""> </a>
						<p>Watch Live!</p>
					</div>
				<?php } ?>	
			</div>
		</div>
	</div>
</section>
<?php   if(!empty($bannerVideo)){
		$url = $bannerVideo['youtubevideolink']; 
		parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars ); 
		$value = $my_array_of_vars['v'];            
?> 
<section class="homeVideoBanner">

	<iframe class="video" id="player<?php echo $playerCount; ?>" width="100%" height="450px" src="http://www.youtube.com/embed/<?php echo $value;  ?>?rel=0&wmode=Opaque&enablejsapi=1;showinfo=0;controls=0" frameborder="0"  allowfullscreen></iframe>
</section>
<?php } ?>
<?php 	$parentcity = $model['parentcity']; 
		if(!empty($parentcity)) {
?>
	<section class="choose-city"> <img class="img-responsive" src="<?php echo $siteimage;?>/choose.png" alt="">
		<div class="container">
			<h2>Choose <span>CITY</span></h2>
			<div class="row">
				<div class="choose-city-top">
					<?php 	$x = 0; 
							$countParentCity = count($parentcity);
							foreach($parentcity as $getParentCity) {
							$x++;
							$getSubCities = Yii::$app->frontendmethods->subcities($getParentCity['main_city_id']); 	
					?>
						<div class="col-md-3 col-sm-3 col-xs-6 fullBlock">
							<div class="choose-city-inner">
								<?php  	if(!empty($getSubCities)) {  ?>
									<p class="<?php echo $getParentCity['main_city_name']; ?> subCitiesCheck"><?php echo $getParentCity['main_city_name']; ?></p>
								<?php } else { ?>	
									<a href="<?php echo $siteUrl; ?>/site/season?parentCity=<?php echo $getParentCity['main_city_id']  ?>&subCity=0"><p class="<?php echo $getParentCity['main_city_name']; ?>"><?php echo $getParentCity['main_city_name']; ?></p></a>
								<?php } ?>	
								<?php  	if(!empty($getSubCities)) {  ?>
											<ul class="">
												<?php  foreach($getSubCities as $subCities) { ?>
													<li><a href="<?php echo $siteUrl; ?>/site/season?parentCity=<?php echo $getParentCity['main_city_id']  ?>&subCity=<?php echo $subCities['sub_city_id']; ?>"><?php echo $subCities['sub_city_name']; ?></a></li>
												<?php } ?>
											</ul>
							 <?php   }  ?>
							</div>
						</div>
						<?php   if($x%4 == 0 && $x!=$countParentCity ) { ?>
							</div>
							</div>
							<div class="row">
							<div class="choose-city-top">
						<?php } ?>		
					<?php } ?>	
				</div>
			</div>
		</div>
	</section>
<?php } ?>
<div class="content-main" id="colorBg">
	<div class="container">
		<div class="row"> 
			<div class="col-md-9 col-sm-9 col-xs-12">
				<?php 	$videos = $model['videos']; 
						if(!empty($videos)) {
				?>
					<section class="content-video">
						<div class="row">
							<div class="content-video-row">
								<?php 	$i =0;
										$countVideos = count($videos);
										foreach($videos as $getVideos) { 
										$i++;	
								?>
									<div class="col-md-4 col-sm-4 col-xs-6 res-400">
										<div class="content-video-inner"> 
											<?php   $url = $getVideos['youtubevideolink']; 
													parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars ); 
													$value = $my_array_of_vars['v'];            ?>
											 <iframe class="yt_players" id="player<?php echo $i; ?>" width="100%" height="100%" src="http://www.youtube.com/embed/<?php echo $value;  ?>?rel=0&wmode=Opaque&enablejsapi=1;showinfo=0;controls=0" frameborder="0" allowfullscreen></iframe>
<!--
											<img class="img-responsive" src="images/img-1.png" alt=""> 
-->
											<a href="javascript:void(0)"><?php echo $getVideos['video_name'];  ?></a> 
										</div>
									</div>
									<?php   if($i%3 == 0 && $i!=$countVideos ) { ?>
												</div>
												<div class="content-video-row">	
									<?php   } ?>		
								<?php } ?>	
							</div>
						</div>
					</section>
				<?php  } ?>	
				<?php 
				$about = $model['about']; 
				if(!empty($about)) { 	
				?>
					<section class="about-main">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="about">
									<?php 
									$p_content = str_ireplace('../../..//admin/', SITE_URL.'admin/', $about['pageContent']);
									$p_content = str_ireplace('../../admin/', SITE_URL.'admin/', $about['pageContent']);
									$p_content = str_ireplace('../../..//', SITE_URL.'admin/', $about['pageContent']);
									$p_content = str_ireplace('../../', SITE_URL.'admin/', $about['pageContent']);
									
									
									 echo $p_content; ?>
									<a href="<?php echo $siteUrl;  ?>/cms/page/about">READ MORE</a> 
								</div>
							</div>
						</div>
					</section>
				<?php }  ?>	
			</div>
			<?php $posts = $model['posts']; 
				  if(!empty($posts)) {
			?>
				<div class="col-md-3 col-sm-3 col-xs-12">
					<section class="sidebar">
						<h3>Recent Posts</h3>
							<?php foreach($posts as $postData) { ?>
								<div class="row">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<div class="sidebar-inner"> 
											<img class="img-responsive" src="<?php  echo POSTS_IMAGE_PATH.'/'.$postData['image']; ?>" alt="">
											<div class="date">
												<p><i class="fa fa-clock-o" aria-hidden="true"></i>
													<?php  echo date('d-m-Y',strtotime($postData['datecreated']));  ?>
												</p>
												<p><i class="fa fa-comment" aria-hidden="true"></i>
													<?php 	$count = Yii::$app->frontendmethods->countcomments($postData['id']); 
														echo $count['cnt'].' Comments';
													 ?>
													
												</p>
											</div>
											<a href="<?php echo $siteUrl;?>/post/postdetail?id=<?php echo $postData['id'];?>"><?php echo $postData['name']; ?></a> 
										</div>
									</div>
								</div>
							<?php } ?>
						<a class="view" href="<?php echo $siteUrl; ?>/post/postlisting" >VIEW ALL POSTS<i class="fa fa-angle-right" aria-hidden="true"></i></a>
					</section>
				</div>
			<?php } ?>	
		</div>
	</div>
</div>  



<script type="text/javascript" src="http://www.youtube.com/player_api"></script>
<script type="text/javascript">
$(".homeVideoBanner").hide();	
$(".watchVideo").click(function(ev){
	$(".video")[0].src += "&autoplay=1";
    ev.preventDefault();
	$(".homeVideoBanner").show();	
	$(".home").hide();
});
	
	players = new Array();
	newplayers = new Array();
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
		
		var newtemp = $("iframe.video");
		var newT = new YT.Player($(newtemp).attr('id'), {
				events: {
					'onStateChange': onPlayerStateChange
				}
		});
		newplayers.push(newT);
		
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
			
			var tempPlayerplays = $("iframe.video");
			for (var i = 0; i < newplayers.length; i++) {
				if (newplayers[i].a.src != temp) 
					newplayers[i].stopVideo();
			}
			
		}
	}
</script>

