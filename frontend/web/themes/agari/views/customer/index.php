<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;  
use yii\helpers\ArrayHelper;
use frontend\models\Languages;
use common\models\Country;
use common\models\State;
use common\models\City;

$this->title = Yii::t('yii','My Profile');
$this->params['breadcrumbs'][] = $this->title;
$attributes = Yii::$app->user->identity->getattributes();

if(isset($attributes['usrLanguage']) && $attributes['usrLanguage'] != '') {
	$usrlang	=	Languages ::find('name')->where(['short_name'=> $attributes['usrLanguage']])->one();
}

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
                <?php echo $this->render('//common/sidebar'); ?>
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
                        <div class="profilewrapper"> <img src="<?php echo $profile_pic; ?>" alt="Profile Pic" onerror="this.onerror=null;this.src='<?php echo $noprofileimage;?>'"> 
                        </div>
                     </div>
                     <div class="media-body">
						 <?php $custName = (isset($attributes['usrFirstname']) ? $attributes['usrFirstname'] : '').' '.(isset($attributes['usrLastname']) ? $attributes['usrLastname'] : '') ?>
                        <h2><?= substr($custName,0,20) ?></h2>
                        <h6><i aria-hidden="true" class="fa fa-map-marker"></i><?= (isset($attributes['usrCity']) ) ? $attributes['usrCity'] : '--'; ?> <?= (isset($attributes['usrCountry']) ) ? ', '.$attributes['usrCountry'] : ''; ?></h6>
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
                        <a class="editprofile" href="<?php echo Yii::$app->homeUrl; ?>customer/settings">
                            <i class="fa fa-cog" aria-hidden="true"></i><?php echo Yii::t('yii','Edit profile');?>
                        </a>
                        <a class="editprofile passwordEdit" href="<?php echo Yii::$app->homeUrl; ?>customer/change-password">
                            <i class="fa fa-key" aria-hidden="true"></i><?php echo Yii::t('yii','Change Password');?>
                        </a>
                     </div>                       
                  
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
										   <span><?php echo Yii::t('yii','Where do you live');?></span><br/>
										   <?php echo (isset($attributes['usrAddress']) ? ucfirst($attributes['usrAddress']) : '--');?>
									   </td>
								   </tr>
								   <tr>
									   <td>
										   <span><?php echo Yii::t('yii','City');?> </span><br/>
										   <?php echo (isset($attributes['usrCity']) ? ucfirst($attributes['usrCity']) : '--'); ?>
									   </td>
									   <td>
										   <span><?php echo Yii::t('yii','Country');?></span><br/>
										   <?php echo (isset($attributes['usrCountry']) ? ucfirst($attributes['usrCountry']) : '--');?>
									   </td>									   
									   <td>
										   <span><?php //echo Yii::t('yii', 'Languages spoken'); ?></span><br/>
										   <?php //echo (isset($usrlang['name']) ? ucfirst($usrlang['name']) : '--');?>						   
									   </td>
								   </tr>
							   </tbody>
                           </table>
                        </div>
                    </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
</section>
