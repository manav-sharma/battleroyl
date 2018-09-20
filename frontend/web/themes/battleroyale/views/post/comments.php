<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
use yii\data\Pagination;
?>
<?php
      Pjax::begin(['id' => 'Pjax_whats-new', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET']]); 
?>
<?php if(isset($comments) && !empty($comments)) {  ?>
			<div class="row">
				<div class="col-md-10 col-sm-12 col-xs-12">
					<h3>Comments</h3>
					<div class="whiteOuter">
						<?php foreach($comments as $commentDetails) { 
						      $userDetails = Yii::$app->frontendmethods->commenteduser($commentDetails['user_id']);	
						?>
							<div class="whiteBlk">
								<div class="whiteThumb"> 
								<?php if(!empty($userDetails['profile_image'])) { ?>
									<img height="80" width="80" class="img-responsive" src="<?php  echo PROFILE_IMAGE_PATH.'/'.$userDetails['profile_image']; ?>" alt=""> 
								<?php }  else { ?>	
									<img class="img-responsive" src="<?php echo NOIMAGE107x114; ?>" alt=""> 
								<?php } ?>	
								</div>
								<div class="whiteDetail">
									<ul>
										<li><i class="fa fa-clock-o" aria-hidden="true"></i> <a href="javascript:void(0)"><?php  echo date('d-m-Y',strtotime($commentDetails['date_created']));  ?></a></li>
										<li>
											<a href="javascript:void(0)">
												<?php 	
														echo $userDetails['firstname'].' '.$userDetails['lastname'];		
												?> 
											</a>
										</li>
									</ul>
									<p><?php echo $commentDetails['comment_description'];  ?></p>
								</div>
							</div>
						<?php } ?>
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
			</div>
		<?php } ?>	
<?php Pjax::end(); ?>
