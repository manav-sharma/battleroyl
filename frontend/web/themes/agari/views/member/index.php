<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;  
use yii\helpers\ArrayHelper;
use frontend\models\Interests;
use frontend\models\Languages;
use common\models\Country;
use common\models\Currency;
use common\models\State;
use common\models\City;
use yii\db\Query;

$this->title = Yii::t('yii','My Profile');
$this->params['breadcrumbs'][] = $this->title;
$attributes = Yii::$app->user->identity->getattributes();

##############= country, state, city =################
if(isset($attributes['usrCurrency']) && $attributes['usrCurrency'] > 0) { 
	$currency	=	Currency ::find()->where(['id' => $attributes['usrCurrency']])->one();
}
if(isset($attributes['usrInterests']) && $attributes['usrInterests'] != '') { 
	$usrInterests = explode(',',$attributes['usrInterests']);
	$usrInterests = array_filter($usrInterests);
	
	$usrInterestsVal	=	Interests ::find('name')->where(['id'=>$usrInterests])->all();
	
	$usrInterestsArr	=	array();
	foreach($usrInterestsVal as $valrow) {
		$usrInterestsArr[]=$valrow['name'];
	}
	$usrInterests = implode(", ",$usrInterestsArr);
}

if(isset($attributes['usrLanguage']) && $attributes['usrLanguage'] != '') { 
	$usrlangExpl 	= explode(',',$attributes['usrLanguage']);
	$languageArr	=	Languages ::find('name')->where(['short_name'=> $usrlangExpl])->all();
	if(!empty($languageArr) && count($languageArr) > 0) {
		$usrlangArr	=	array();
		foreach($languageArr as $lag) {
			$usrlangArr[]	=	$lag['name'];
		}

		$userlang	=	implode(", ",$usrlangArr);
	}
}

#######= verified status =##########
$query = new Query;
$query->select('COUNT(id) as cnt')->from('userverification')->where('user_id = '.$attributes['id'].' AND type = "PHONE" AND status = "1"');
$verifyPhone = $query->createCommand()->queryOne();
         
if(isset($attributes['gender']) && $attributes['gender'] == MALE)
	$noprofileimage = dummy_image_male;
else
	$noprofileimage = dummy_image_female;

$profile_picture = $attributes['usrProfileImage'];
$profile_pic = (isset($profile_picture) && $profile_picture != '' ? PROFILE_IMAGE_PATH.$profile_picture : $noprofileimage);
?>
<section>
<?php echo $this->render('//common/searchbox'); ?>
<div class="searchresult">
   <div class="container">
      <div class="row">
            <div class="col-md-3 col-sm-4 col-xs-12">
               <?php echo $this->render('../common/sidebar'); ?>
            </div>   
      <div class="col-xs-12 col-sm-8 col-md-9">
            <?php if (Yii::$app->session->getFlash('item')): ?>

				 <div class="alert alert-grey alert-dismissible">
					   <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
					   </button>
					   <i class="glyphicon glyphicon-ok"></i><?php echo Yii::$app->session->getFlash('item'); ?>
				 </div>
																
			  <?php endif; ?>		  
         <div class="detailright">
            <div class="profiledetail">
                  <div class="media">
                     <div class="media-left pull-left">
                        <div class="profilewrapper"> <img src="<?php echo $profile_pic; ?>" alt="No Image" onerror="this.onerror=null;this.src='<?php echo $noprofileimage;?>'"> 
                        </div>
                     </div>
                     <div class="media-body">
						 <?php $custName = (isset($attributes['usrFirstname']) ? $attributes['usrFirstname'] : '').' '.(isset($attributes['usrLastname']) ? $attributes['usrLastname'] : '') ?>
                        <h2><?= substr($custName,0,20) ?></h2>
                        <h6><i aria-hidden="true" class="fa fa-map-marker"></i>
                        <?= (isset($attributes['usrCity']) ) ? $attributes['usrCity'] : '--'; ?> <?= (isset($attributes['usrCountry']) ) ? ', '.$attributes['usrCountry'] : ''; ?>
                        </h6>
                        <div class="rating3">
							<?php if(isset($attributes['rating_total']) && $attributes['rating_total'] > 0) {
									echo'<ul>';
										for($i = 1; $i <= 5; $i++) {
											$cl = '';
											if($i > $attributes['rating_total']) { $cl = 'class="unrating"'; }
											echo '<li '.$cl.'><a href="javascript:void(0)"><i class="fa fa-star" aria-hidden="true"></i></a></li>';
										}
									echo '</ul>';
							?>
								<h6><a href="<?php echo Yii::$app->homeUrl; ?>member/ratings"><?= (isset($attributes['rating_outof_total']) && $attributes['rating_outof_total'] > 0 ? $attributes['rating_outof_total'] / 5 .' reviews' : '') ?></a></h6>
                           <?php } ?>
                        </div> 
                        <a class="editprofile" href="<?php echo Yii::$app->homeUrl; ?>member/settings">
                            <i class="fa fa-cog" aria-hidden="true"></i>
                                <?php echo Yii::t('yii','Edit profile');?>
                        </a>
                        <a class="editprofile passwordEdit" href="<?php echo Yii::$app->homeUrl; ?>member/change-password">
                            <i class="fa fa-key" aria-hidden="true"></i><?php echo Yii::t('yii','Change Password');?>
                        </a>
                     
                     </div>
                     
                        <!-- <a href="<?php //echo Yii::$app->homeUrl; ?>cms/page/tips" 
                           class="editprofile tips" target="_blank">
                               <?php //echo Yii::t('yii','Tips'); ?>
                        </a> -->
                     
                     </div>
               </div>
            <div class="detailwhite">
                     <h6><?php echo Yii::t('yii','Personal information');?></h6>
                        <div class="table-responsive">
                           <table class="table">
							   <tbody>
								   <tr>
									   <td>
										   <span><?php echo Yii::t('yii','First name');?></span><br/>
										   <?php echo (isset($attributes['usrFirstname']) ? substr(ucfirst($attributes['usrFirstname']),0,20) : ''); ?>
									   </td>
									   <td>
										   <span><?php echo Yii::t('yii','Last name');?></span><br/>
										   <?php echo (isset($attributes['usrLastname']) ? substr(ucfirst($attributes['usrLastname']),0,20) : '');?>
									   </td>
									   <td>
										   <span><?php echo Yii::t('yii','email');?></span><br/>
											<?php echo (isset($attributes['email']) ? $attributes['email'] : '');?>
									   </td>
								   </tr>

								   <tr>
									   <td>
										   <span><?php echo Yii::t('yii','Birth date');?></span><br/>
										   <?php echo (isset($attributes['dob']) && $attributes['dob'] != '0000-00-00' && $attributes['dob'] != '' ? date("d-m-Y",strtotime($attributes['dob'])) : '--');?>
									   </td>
									   <td>
										   <span><?php echo Yii::t('yii','Gender');?> </span><br/>
										   <?php echo (isset($attributes['gender']) ? ucfirst($attributes['gender']) : '');?>
									   </td>
									   <td>
										   <span><?php echo Yii::t('yii','Phone number');?></span><br/>
										   <?php echo (isset($attributes['usrPhone']) ? ucfirst($attributes['usrPhone']) : '--'); ?> <?php if(isset($verifyPhone['cnt']) && $verifyPhone['cnt'] > 0) { ?><a style="color:green;"> 	<?php echo Yii::t('yii','Verified');?></a><?php } else { ?> <a href="javascript:void(0)" id="verifyPhoneNumber" style="color:red;"> 	<?php echo Yii::t('yii','Verify Phone');?></a> <?php } ?>
									   </td>
								   </tr>
								   <tr>
									   <td>
											<span><?php echo Yii::t('yii','Where do you live');?></span><br/>
											<?php echo (isset($attributes['usrAddress']) ? ucfirst($attributes['usrAddress']) : '--');?>
									   </td>	
									   <td>
										   <span><?php echo Yii::t('yii','City');?> </span><br/>
										   <?php echo (isset($attributes['usrCity']) ? ucfirst($attributes['usrCity']) : '--');?>
									   </td>									   								   
									   <td>
										   <span><?php echo Yii::t('yii','Country');?></span><br/>
										   <?php echo (isset($attributes['usrCountry']) ? ucfirst($attributes['usrCountry']) : '--');?>							   
									   </td>
								   </tr>

								   <tr>
									   <td>
										   <span><?php echo Yii::t('yii', 'Languages spoken'); ?></span><br/>
										   <?php echo (isset($userlang) ? ucfirst($userlang) : '--');?>						   
									   </td>
								   </tr>								   
							   </tbody>
                           </table>
                        </div>

						  <h6><?php echo Yii::t('yii','Interests information');?></h6>
						  <div class="table-responsive">
							<table class="table">
							  <tbody>
								<tr>
								 
								<td><span><?php echo Yii::t('yii','Interests');?> </span><br/>
									<?php echo (isset($usrInterests) ? $usrInterests : '--'); ?>
								</td>
								</tr>
								
							  </tbody>
							</table>
						  </div>
						  <h6><?php echo Yii::t('yii','Payment information');?></h6>
						  <div class="table-responsive">
							<table class="table">
							  <tbody>
								<tr>
								  <td><span><?php echo Yii::t('yii','	Currency');?></span><br/>
										<?php echo (isset($currency['currency_name']) ? $currency['currency_name'] : ''); ?>
								  </td>
								  <td><span><?php echo Yii::t('yii','	Daily price');?></span><br/>
										<?php echo (isset($attributes['usrDayPrice']) ? (isset($currency['currency_sign']) ? $currency['currency_sign'] : '$') .$attributes['usrDayPrice'] : ''); ?>
								  </td>
								  <td><span><?php echo Yii::t('yii','Hourly price');?></span><br/>
										<?php echo (isset($attributes['usrHourPrice']) ? (isset($currency['currency_sign']) ? $currency['currency_sign'] : '$') .$attributes['usrHourPrice'] : ''); ?>
								  </td>						
								  <td></td>
								  <td></td>
								</tr>
							  </tbody>
							</table>
						  </div>

						  <div class="description">
							<h6><?php echo Yii::t('yii','Uploaded documents');?></h6>
							<?php if(isset($attributes['usrIdDocument']) && !empty($attributes['usrIdDocument'])) { ?>
								<a class="documentpdf" target="_blank" href="<?php echo (isset($attributes['usrIdDocument']) && !empty($attributes['usrIdDocument']) ? DOCUMENT_DOWNLOAD_PATH.$attributes['usrIdDocument'] : 'javascript:void()'); ?>"><?php echo (isset($attributes['usrIdDocument']) ? substr($attributes['usrIdDocument'],-10) : ""); ?></a>
							<?php } else {
								 echo '<a class="documentpdf">'.Yii::t('yii','No Documents').'</a>';
							 } ?>	
						
						 </div>
						  <div class="description">
							<h6><?php echo Yii::t('yii','Description');?></h6>
							<p><?php echo (isset($attributes['usrDescription']) ? ucfirst($attributes['usrDescription']) : ''); ?></p>
						  </div>						  
                                      
                    </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
<script type="text/javascript">
	$(document).ready(function () {
		$('#verifyPhoneNumber').on('click',function() {
					$.ajax({
						type:'POST',
						url:"<?php echo Url::to(['member/send-verification-code']); ?>",
						success:function(response) {
							if(response == true) {
								window.location = "<?php echo Url::to(['member/verify-phone-number']); ?>";
							}
						}
					});
		});
	 });
</script>
</section>
