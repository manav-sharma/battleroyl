<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\db\Query;

$this->title = 'Battle Royale';
$siteimage = Yii::getAlias('@siteimage');
$siteUrl = Yii::getAlias('@basepath');
$banner = Yii::$app->frontendmethods->frontendbannerlanding();
?>
<body class="landing" style="background:url(<?php echo BANNER_IMAGE_PATH.'/'.$banner['bannerImage']; ?>) no-repeat center center;background-attachment: fixed;background-size: cover;">
<section class="landingPage">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="logo"><img src="<?php echo $siteimage;?>/logo.png" alt=""></div>
        <div class="title"> <?php echo $banner['title']; ?> <span><?php echo $banner['description']; ?></span> </div>
        <div class="socialIcons">
          <ul>
            <li><a class="facebook" href="javascript:void(0)"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li><a class="twiter" href="javascript:void(0)"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
            <li><a class="instagram" href="javascript:void(0)"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
            <li><a class="youtube" href="javascript:void(0)"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
          </ul>
        </div>
        <a href="<?php echo $siteUrl; ?>/site/home" class="homelink landingButton">Go to Homepage <i class="fa fa-angle-double-right" aria-hidden="true"></i></a> </div>
    </div>
  </div>
</section>
</body>
