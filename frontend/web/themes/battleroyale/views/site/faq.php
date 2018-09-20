<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\db\Query;
use yii\widgets\LinkPager;
use yii\data\Pagination;

$this->title = 'FAQ';
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
		<?php if(isset($faq) && !empty($faq)) { ?>
			<div class="panel-group" id="accordion">
				<?php 	
						
						$i = 0;
						foreach($faq as $faqDetails)  { 
						$i++;	
						if($i == 1){
							$class =  'glyphicon glyphicon-minus';
						} else {
							$class =  'glyphicon glyphicon-plus';
						}
				?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i; ?>"> <span class="buttons <?php echo $class; ?>"></span> <span class="textBlk"><?php echo $faqDetails['name']; ?></span></a> </h4>
						</div>
						<div id="collapse<?php echo $i; ?>" class="panel-collapse collapse <?php if($i == 1) { echo ' in';  }?>">
							<div class="panel-body">
								<p><?php echo $faqDetails['description']; ?></p>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		<?php } else { ?>	
				<div class="row">
					<div class="col-xs-12">
						<h3>No FAQ Found !!!</h3>
					</div>	
				</div>	
		<?php } ?>	
	</div>
</section>
<script type="text/javascript">
function toggleIcon(e) {
    $(e.target)
        .prev('.panel-heading')
        .find(".buttons")
        .toggleClass('glyphicon-plus glyphicon-minus');
}
$('.panel-group').on('hidden.bs.collapse', toggleIcon);
$('.panel-group').on('shown.bs.collapse', toggleIcon);
</script>	
