<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\db\Query;
use yii\widgets\LinkPager;
use yii\data\Pagination;

$this->title = 'Posts';
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
		<?php if(!empty($posts)) { ?>
			<?php foreach($posts as $getPosts) { ?>
				<div class="row">
					<div class="col-md-9 col-sm-12 col-xs-12">
						<div class="bottomBorder">
							<div class="leftColumn">
								<div class="dateBlk">
									<?php  $fulldate =  date('d-M-Y',strtotime($getPosts['datecreated']));  
										   $dateValues = explode('-',$fulldate);
										   //echo '<pre>'; print_r($dateValues);	
									?>
									<div class="date"><?php echo $dateValues[0]; ?></div>
									<span><?php echo $dateValues[1]; ?>, <?php echo $dateValues[2]; ?></span> 
								</div>
							</div>
							<div class="rightColumn">
								<div class="postThumb"> 
									<img class="img-responsive" src="<?php  echo POSTS_IMAGE_PATH.'/'.$getPosts['image']; ?>" alt=""> 
								</div>
								<div class="postText">
									<div class="comment"><i class="fa fa-comment" aria-hidden="true"></i> 
									<?php 	$count = Yii::$app->frontendmethods->countcomments($getPosts['id']); 
											echo $count['cnt'].' Comments';
									?>
													</div>
									<span><?php echo $getPosts['name']; ?></span>
									<p><?php echo $getPosts['description']; ?> </p>
									<div class="button"><a href="<?php echo $siteUrl; ?>/post/postdetail?id=<?php echo $getPosts['id']; ?>">read more</a></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php }  ?>
			<div class="row">
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
		</div>
		<?php } else { ?>
			<div class="row">
				<div class="col-xs-12">
					<h3>No Posts Found !!!</h3>
				</div>	
			</div>	
		<?php } ?>	
	</div>	
</section>
