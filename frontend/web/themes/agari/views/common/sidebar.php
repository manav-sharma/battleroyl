<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\db\Query;
##################= unread messages count =################
$attributes = Yii::$app->user->identity->getattributes();
$userId = Yii::$app->user->getId();
$query  = new Query;
$query->select('COUNT(message_id) as cnt')
->from('messages')
->where('is_read = 0 AND is_trashed = 0 AND user_to ='.$userId);
$messages = $query->createCommand()->queryOne();

$CtrlName	=	Yii::$app->controller->id;
$FunName	=	Yii::$app->controller->action->id;
####################= member sidebar =####################
if(isset($attributes['usrType']) && $attributes['usrType'] == MEMBER) {
?>
<ul class="navleft">
  <li <?php if($CtrlName == 'member' && $FunName == 'index') { ?> class="active" <?php } ?>>
		<?php echo Html::a('<i aria-hidden="true" class="fa fa-user"></i>'.Yii::t('yii','My Profile'),Url::home().'member',['member']);?>
  </li>
  <li <?php if($CtrlName == 'messages') { ?> class="active" <?php } ?> ng-controller="notificationCrtl">
		<?php echo Html::a('<i aria-hidden="true" class="fa fa-envelope"></i><span class="numbermsg">'.(isset($messages['cnt']) && $messages['cnt'] > 0 ? $messages['cnt'] : '') . '</span>' . Yii::t('yii','Messages'),Url::home().'messages',['messages']); ?>
  </li>
  <li <?php if($CtrlName == 'member' && $FunName == 'bookinghistory') { ?> class="active" <?php } ?>>
		<?php echo Html::a('<i aria-hidden="true" class="fa fa-history"></i>'.Yii::t('yii','Booking History'),Url::home().'member/bookinghistory',['member']);?>
  </li>
  <li <?php if($CtrlName == 'member' && $FunName == 'ratings' ) { ?> class="active" <?php } ?>>
		<?php echo Html::a('<i aria-hidden="true" class="fa fa-star-half-o"></i>'.Yii::t('yii','Rating &amp; Feedback'),Url::home().'member/ratings',['ratings']);?>
  </li>
  <li <?php if($CtrlName == 'member' && $FunName == 'settings') { ?> class="active" <?php } ?>>
	<?php echo Html::a('<i aria-hidden="true" class="fa fa-cog"></i>'.Yii::t('yii','Account Settings'),Url::home().'member/settings',['member']);?>
  </li>
</ul>
<?php } else { 
####################= customer sidebar =#################### 
?>
<ul class="navleft">
  <li <?php if($CtrlName == 'customer' && $FunName == 'index') { ?> class="active" <?php } ?>>
		<?php echo Html::a('<i class="fa fa-user" aria-hidden="true"></i>'.Yii::t('yii','My Profile'),Url::home().'customer',['customer']);?>
  </li>
  <li <?php if($CtrlName == 'messages') { ?> class="active" <?php } ?> ng-controller="notificationCrtl">
		<?php echo Html::a('<i aria-hidden="true" class="fa fa-envelope"></i><span class="numbermsg">' .(isset($messages['cnt']) && $messages['cnt'] > 0 ? : '') . '</span>' . Yii::t('yii','Messages'),Url::home().'messages',['messages']);?>
  </li>
  <li <?php if($CtrlName == 'customer' && $FunName == 'paymenthistory') { ?> class="active" <?php } ?>>
		<?php echo Html::a('<i class="fa fa-history" aria-hidden="true"></i>'.Yii::t('yii','Booking History'),Url::home().'customer/paymenthistory',['customer']);?>
  </li>
  <li <?php if($CtrlName == 'customer' && $FunName == 'settings') { ?> class="active" <?php } ?>>
	<?php echo Html::a('<i class="fa fa-cog" aria-hidden="true"></i>'.Yii::t('yii','Account Settings'),Url::home().'customer/settings',['customer']); ?>
  </li>
</ul>
<?php } ?>
