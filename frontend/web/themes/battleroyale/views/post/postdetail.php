<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\db\Query;
use yii\widgets\LinkPager;
use yii\data\Pagination;
//echo '<pre>'; print_r($postdetail);
$this->title = 'Post Detail';
$siteimage = Yii::getAlias('@siteimage');
$siteUrl = Yii::getAlias('@basepath');
//echo '<pre>'; print_r($comments);
$attributes = Yii::$app->user->identity->getattributes();
$post_id = Yii::$app->getRequest()->getQueryParam('id');
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
<?php if(isset($postdetail) && !empty($postdetail)) {  ?>
<section class="contentArea defineFloat" id="colorBg">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="topButton">
					<div class="button"> 
						<a href="<?php echo $siteUrl; ?>/post/postlisting"><i class="fa fa-angle-left" aria-hidden="true"></i> back</a> 
					</div>
				</div>
			</div>
			<div class="col-xs-12">
				<div class="outerBox">
					<div class="leftColumn">
						<div class="dateBlk">
							<?php   $fulldate =  date('d-M-Y',strtotime($postdetail['datecreated']));  
									$dateValues = explode('-',$fulldate);
							?>
							<div class="date"><?php echo $dateValues[0]; ?></div>
							<span><?php echo $dateValues[1]; ?>, <?php echo $dateValues[2]; ?></span> 
						</div>
					</div>
					<div class="rightColumn">
						<div class="postThumb"> <img class="img-responsive" src="<?php  echo POSTS_IMAGE_PATH.'/'.$postdetail['image']; ?>" alt=""> </div>
						<div class="postText">
							<div class="comment"><i class="fa fa-comment" aria-hidden="true"></i> 
								<?php 	$count = Yii::$app->frontendmethods->countcomments($postdetail['id']); 
										echo $count['cnt'].' Comments';
								?>
							</div>
							<span><?php echo $postdetail['name']; ?></span>
							<p><?php echo $postdetail['description']; ?> </p>
							<?php if(!empty($postdetail['youtubevideolink'])){ ?>
								<div class="postThumb">
									<?php 	$url = $postdetail['youtubevideolink']; 
											parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars ); 
											$value = $my_array_of_vars['v'];    
									?>
									<iframe class="yt_players" id="player" width="100%" height="350px" src="http://www.youtube.com/embed/<?php echo $value;  ?>?rel=0&wmode=Opaque&enablejsapi=1;showinfo=0;controls=0" frameborder="0" allowfullscreen></iframe>
								</div>
							<?php } ?>	
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="comments">
			<?php 
				echo $this->render('comments',[
				'comments'=> $comments,
				'pages' => $pages
				]);
            ?>
		</div>
		<?php 
		if(!Yii::$app->user->isGuest) {?>
			<div class="row">
				<div class="col-md-7 col-sm-12 col-xs-12">
					<div class="commentBox">
						<h3>Leave a comment</h3>
						<?php if (Yii::$app->session->getFlash('item')): ?>                                    
							<div class="alert alert-grey alert-dismissible">
							   <button type="button" class="close" data-dismiss="alert">
								  <span aria-hidden="true">&times;</span>
							   </button>
							<i class="glyphicon glyphicon-ok"></i> <?php echo Yii::$app->session->getFlash('item'); ?>
							</div>                                           
                        <?php endif; ?>
						<?php
							$form = ActiveForm::begin(
							[
								'id' => 'commentForm',
								'options' => [
								   // 'class' => 'inner',
									'tag' => 'span', ####THIS OPTIONS DISABLES THE DIV.FORM_GROUP ENCLOSER TAG FOR FIELDS
								],
								'fieldConfig' => [
										 'template' => "
										 {label}\n
										 {input}
											<div class=\"col-xs-12\">
											   <label></label>{error} {hint}
											</div>",
											   ],
											]
							);
						?> 
							<?php  echo $form->field($model, 'user_id')->hiddenInput(['value'=> $attributes['id']])->label(false);?>
							<?php  echo $form->field($model, 'post_id')->hiddenInput(['value'=> $post_id])->label(false);?>
							<?php
									echo $form->field($model, 'comment_description', ['inputOptions' => [
									'class' => "form-control",
									]])->textarea(['rows' => 3])->label('Your Comment *');
							?>	
							<div class="button"><button class="btn btn-primary">submit</button></div>
						<?php ActiveForm::end(); ?>
					</div>
				</div>
			</div>
		
		<?php } ?>
	</div>
</section>
<?php } else { ?>
		
	<section class="contentArea defineFloat" id="colorBg">
		<div class="container">
			<div class="row">
				<h3>No Details Found.</h3>
			</div>	
		</div>
	</section>
<?php } ?>	
