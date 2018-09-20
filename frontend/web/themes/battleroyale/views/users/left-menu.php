<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\db\Query;

$siteimage = Yii::getAlias('@siteimage');
$siteUrl = Yii::getAlias('@basepath');
$actionId 	= Yii::$app->controller->action->id;
$CtrlName	= Yii::$app->controller->id;
$attributes = Yii::$app->user->identity->getattributes();
$myp=$pas='';
if($CtrlName == 'users' 		&& $actionId == 'myprofile') { $myp  = 'active'; } 
if($CtrlName == 'users' 		&& $actionId == 'password')  { $pas  = 'active'; } 

?>
<div class="profileThumb"> 
	<?php if(!empty($attributes['profile_image'])) { ?>
		<img class="img-responsive" src="<?php  echo PROFILE_IMAGE_PATH.'/'.$attributes['profile_image']; ?>" alt=""> 
	<?php }  else { ?>	
		<img class="img-responsive" src="<?php echo NOIMAGE107x114; ?>" alt=""> 
	<?php } ?>	
</div>
<div class="leftNav">
	<ul>
		<li class="<?php echo $myp; ?>"><a href="<?php echo $siteUrl; ?>/users/myprofile">My Profile</a></li>
		<li class="<?php echo $pas; ?>"><a href="<?php echo $siteUrl; ?>/users/password">Change password</a></li>
	</ul>
</div>
