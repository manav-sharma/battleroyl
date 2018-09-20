<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;  
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('yii','Rating & feedback');
$this->params['breadcrumbs'][] = $this->title;
?>
<section>
 <div class="mainheading">
	<div class="container">
		<div class="row">
           <div class="col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0"></div>
        </div>
    </div>

    <div class="bordertopwhite">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12 ">
					<div class="headinginner"><?= $this->title ?></div>
				</div>
			</div>
		</div>
    </div>
 </div>

  <div class="searchresult">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-4 col-xs-12">
			<?php echo $this->render('../common/sidebar'); ?>
        </div>
        <div class="col-xs-12 col-sm-8 col-md-9">
          <ul class="personsearch personrate">
			<?php if(isset($ratingDetails) && !empty($ratingDetails)) { 
					foreach($ratingDetails as $rating) {
						if(isset($rating['gender']) && $rating['gender'] == MALE)
							$noprofileimage = dummy_image_male;
						else
							$noprofileimage = dummy_image_female;			
						
						$profile_pic = (isset($rating['usrProfileImage']) && $rating['usrProfileImage'] != '' ? PROFILE_IMAGE_PATH.$rating['usrProfileImage'] : $noprofileimage);
			?>  
				<li>
					<div class="media">
						<div class="media-left pull-left">
							<div class="feedbackwrapper"><img src="<?= $profile_pic ?>" onerror="this.onerror=null;this.src='<?php echo NOIMAGE107x114;?>'" alt="person"> </div>
						</div>
						
						<div class="media-body">
							<div class="ratedetail">
								<div class="rating3">
									<?php if(isset($rating['starrating']) && $rating['starrating'] > 0) {
											echo'<ul>';
												for($i = 1; $i <= 5; $i++) {
													$cl = '';
													if($i > $rating['starrating']) { $cl = 'class="unrating"'; }
													echo '<li '.$cl.'><a href="javascript:void(0)"><i class="fa fa-star" aria-hidden="true"></i></a></li>';
												}
											echo '</ul>';
											}
									?>
								</div>
								<ul class="personname">
									<li><?php echo Yii::t('yii','In');?> <span><?= (isset($rating['location']) ? $rating['location'] : '') ?></span></li>
									<li><?php echo Yii::t('yii','By');?> <span><?= (isset($rating['usrFirstname']) ? $rating['usrFirstname']." ".$rating['usrLastname'] : '') ?></span></li>
									<li><?= (isset($rating['date_time']) ? date("d-m-y",strtotime($rating['date_time'])) : '') ?></li>
								</ul>
								<p><?= (isset($rating['comment']) ? substr($rating['comment'],0,200) : '') ?></p>
							</div>
						</div>
					</div>
				</li>
           <?php }
           } else {
           ?> 
				<li>
					<div class="media"><?php echo Yii::t('yii','No Reviews Yet!'); ?>
					</div>
				</li>
			<?php } ?>	           
          </ul>
          <nav class="paginationdesign">
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
  </div>
</section>
