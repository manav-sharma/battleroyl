<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\Country;
use common\models\State;
use common\models\City;
use yii\db\Query;

$this->title = Yii::t('yii','Guide Profile');
$this->params['breadcrumbs'][] = $this->title;

if($guideDetails['gender'] == 'Male')
	$noprofileimage = dummy_image_male;
else
	$noprofileimage = dummy_image_female;	

$customer = Yii::$app->user->identity;

##########################= display name of insider =######################
$ufn = (isset($guideDetails['usrFirstname']) ? $guideDetails['usrFirstname'] : '');
$uln = (isset($guideDetails['usrLastname']) ? $guideDetails['usrLastname'] : '');
if($ufn != '' || $uln != '') {
	//$cntguideName	=	Yii::t('yii','Contact ').$ufn.' '.$uln;
	//$bookme			=	Yii::t('yii','Book ').$ufn.' '.$uln;

	$cntguideName	=	Yii::t('yii','Contact ').$ufn;
	$bookme			=	Yii::t('yii','Book ').$ufn;	
	
} else {
	$cntguideName 	=	Yii::t('yii','Contact guide');
	$bookme 		=	Yii::t('yii','Book me');
}

#######= verified status =##########
if(isset($guideDetails['id']) && $guideDetails['id'] > 0) {
	$query	 = new Query;
	####= availability =####
	$query->select('available_dates,available_time')->from('user_availability')->where('user_id = '.$guideDetails['id']);
	$availabilty = $query->createCommand()->queryOne();
	$aval	=	"";
	if(isset($availabilty['available_dates']) && !empty($availabilty['available_dates'])) {
			$arrDates = explode(",",$availabilty['available_dates']);
			$newArr = array();
			foreach($arrDates as $row) {
				$newArr[] = "'$row'";
			}
			$aval =  implode(", ",$newArr);
	}
	
	####= booking =####
	$query->select("`booked_to_date`,`booked_from_date`,DATEDIFF(`booked_to_date`,`booked_from_date`) AS diff_days")->from('booking')->where(['guyde_user_id' => $guideDetails['id'],'booking_status'=>'1']);
	$bookingData 	= $query->createCommand()->queryAll();
	$bookingDates	=	array();
	$bookingVal		=	"'".date('m/d/Y')."'";

	if(isset($bookingData) && !empty($bookingData)) {
		foreach($bookingData as $booking) {
			$booking_from 	=	$booking['booked_from_date'];
			for($i=0; $i<=$booking['diff_days']; $i++) {
				$bookDay = date("m/d/Y",strtotime($booking_from));
				$bookingDates[] = "'$bookDay'";
				$booking_from   = date("m/d/Y",strtotime($booking_from.' +1 day'));
			}
		}
		$bookingVal =  (isset($bookingDates) && $bookingDates ? implode(", ",$bookingDates) : "");
	}
	
	$searchpost = Yii::$app->session->get('searchpost');
	$searchDate = isset($searchpost['searchdate'])?date('m/d/Y',strtotime($searchpost['searchdate'])):date('m/d/Y');
	
	
	/* Currency */
	$usrCurrencySign	 =	'$';
	$usrCurrencyName	 =	'USD';
	if(isset($guideDetails['usrCurrency']) && !empty($guideDetails['usrCurrency'])) {
		$currencyArr 	 = common\models\Currency::findOne(['id'=>$guideDetails['usrCurrency']]);
		$usrCurrencySign = (isset($currencyArr['currency_sign']) ? $currencyArr['currency_sign'] : '');
		$usrCurrencyName = (isset($currencyArr['currency_name']) ? $currencyArr['currency_name'] : '');
	}
}

?>
<section>
    
<?php echo $this->render('//common/searchbox-nogaparea'); ?>
    
    <div class="profilegrey">
        <div class="container">
            <div class="row">
                <div class="col-sm-7 col-md-8 col-xs-12">
                    <div class="media greyprofileinner">
                        <div class="media-left pull-left">
                            <div class="guideprofilewrapper"><img src="<?= (isset($guideDetails['usrProfileImage']) ? PROFILE_IMAGE_PATH . $guideDetails['usrProfileImage'] : $noprofileimage); ?>" alt="Guide profile" onerror="this.onerror=null;this.src='<?php echo $noprofileimage;?>'"></div>
                        </div>
                        <div class="media-body">
                            <h2><?= $guideDetails['usrFirstname']. ' ' . $guideDetails['usrLastname']; ?></h2>
                            <?php
                            $city = City::findOne($guideDetails['usrCity']);       
                            
                            $starRatingArray = array();
                            ?>
                            <h6><i class="fa fa-map-marker" aria-hidden="true"></i><?= (isset($guideDetails['usrCity']) ) ? $guideDetails['usrCity'] : '--'; ?> <?= (isset($guideDetails['usrCountry']) ) ? ', '.$guideDetails['usrCountry'] : ''; ?></h6>
                            <?php 
                            if(isset($customer->id) && $customer->id == $guideDetails['id']) {  }else{
								echo  Html::a($bookme, ['booking/book-member', 'id' => $guideDetails['id']], ['class' => 'orangebtn']); 	
							} ?>
                            
                            <div class="rating3">
                                <?php
                                if ($guideDetails['rating_total'] > 0 && $guideDetails['rating_outof_total'] > 0)
                                    $starRatingArray[] = 5 * ($guideDetails['rating_total'] / $guideDetails[	'rating_outof_total']);
                                else
									$starRatingArray[] = 0;	

                                ?>
                                <ul class="staricon star0"> </ul>
                                
                                <?php
                                /* Count Reviews*/
								$totalReviews =  backend\models\feedback\feedback::find()->where(['receiver_userid'=>$guideDetails['id']])->count();
                                ?>
                                <h6><?php
									if(empty($totalReviews)) {
										echo "<a>0 ".Yii::t('yii','reviews')."</a>";	
									}else{
										echo "<a href='javascript:void()' id='review_block'>$totalReviews ".Yii::t('yii','reviews')."</a>";
									}
									?></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 col-md-4 col-xs-12">
                    <div class="greyhobbies">
                        <h2 style="font-size:26px"><?php echo $usrCurrencySign . $guideDetails['usrDayPrice'].' '.Yii::t('yii','per day').'/'.$usrCurrencySign.$guideDetails['usrHourPrice'].' '.Yii::t('yii','per hour');; ?></h2>
                        <div class="hobbiesborder">
                            <h6><?php echo Yii::t('yii','Interests'); ?>:</h6>
                            <ul>                                
                                <?php
                                $interests = (array)explode(',', $guideDetails['usrInterests']);                               
                                foreach ($interests as $interestId) {
                                    
                                    $interest = frontend\models\Interests::findOne($interestId);
                                    
                                    if(!empty($interest) )
                                        echo "<li><a style='text-decoration: none;'>$interest->name</a></li>";
                                }
                                ?>
                            </ul>
                            <h6><?php echo Yii::t('yii','Languages Spoken'); ?>:</h6>
                            <ul>
                            <?php
                                $languagesSpoken = (array)explode(',', $guideDetails['usrLanguage']);
                                foreach ($languagesSpoken as $languageId) {
                                    $language = frontend\models\Languages::findOne(['short_name'=>$languageId]);
                                    if(!empty($language) )
                                        echo "<li><a style='text-decoration:none;'>$language->name</a></li>";
                                }
                            ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="profilewhite">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
                    <div class="media availabilty">
                        <div class="media-left pull-left"><i class="fa fa-calendar-<?php echo (isset($bookingVal) && strpos($bookingVal,$searchDate) ? 'times' : (isset($aval) && strpos($aval,$searchDate) ? 'check' : 'times')); ?>-o" aria-hidden="true"></i> </div>
                        
                        <div class="media-body">
												<div class="demo viewcalender" style="margin-top:10px;">
						<a href="javascript:void(0)" id="btnViewCal" class="guidebtn"><?php echo Yii::t('yii','View calendar');?></a>
						<input type="text"  id="from-input" value="" readonly>
						<div class="code-box">
							<pre class="code prettyprint" style="display:none;">
								var date = new Date();
								var y = date.getFullYear();
								$('#from-input').multiDatesPicker({
								maxPicks: 0,	
								minDate: 0,
								addDates: [<?= $aval ?>],
								adjustRangeToDisabled: true,
								addDisabledDates:[<?= $bookingVal ?>],
								});
							</pre>
						</div>
					</div>
							 <span style="padding-top:12px;">Brown (Available)/Gray (Not Available)</span>
                        </div>
                    </div>
                    

                    <div class="verification">
                        <h6><?php echo Yii::t('yii','Verification');?></h6>
                        <ul>
							<?php 
								
								
								 ###########= verification items =#############
								 $verifiedEmail = ($guideDetails->usrRegistrationType=='FB' || $guideDetails->usrRegistrationType=='GPLUS' || $guideDetails->status == ACTIVE)?1:in_array('EMAIL',  array_column($documentVerified, 'type')); 
								 $verifiedPhone = in_array('PHONE',  array_column($documentVerified, 'type')); 
								 $verifiedDocId = in_array('DOC_ID', array_column($documentVerified, 'type'));
								 
							?>

                            <li><i class="fa fa-<?= (isset($verifiedDocId) && $verifiedDocId != '' ? 'check-circle' : 'times-circle unvalidate') ?>" aria-hidden="true"></i> <?php echo Yii::t('yii','ID verified');?></li>
                            <li><i class="fa fa-<?= (isset($verifiedEmail) && $verifiedEmail != '' ? 'check-circle' : 'times-circle unvalidate') ?>" aria-hidden="true"></i> <?php echo Yii::t('yii','Email verified');?></li>
                            <li><i class="fa fa-<?= (isset($verifiedPhone) && $verifiedPhone != '' ? 'check-circle' : 'times-circle unvalidate') ?>" aria-hidden="true"></i> <?php echo Yii::t('yii','Phone number verified');?></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="informationdetail">
                        <div class="informationarea">
                            <h6><?php echo Yii::t('yii','About the Insider'); ?></h6>
                            <p>
                                <?php echo $guideDetails['usrDescription']; ?>
                            </p>
                         
                            <?php
                            
                            if(isset($customer->id) && $customer->id == $guideDetails['id']) { 
								
							}else{
								echo  Html::a($cntguideName, ['messages/contactwithguide', 'id' => $guideDetails['id']], ['class' => 'guidebtn']); 
								}
                            ?>             
                        </div>
                        <div class="detailwhite">
                            <h6><?php echo Yii::t('yii','Booking information'); ?></h6>
                            <table class="table">
                                <tbody>
                                    <tr>
										<td><span><?php echo Yii::t('yii','Currency'); ?></span> <?php echo $usrCurrencyName; ?></td>
                                        <td><span><?php echo Yii::t('yii','Per day'); ?></span> <?php echo $usrCurrencySign . $guideDetails['usrDayPrice']; ?></td>
                                        <td><span><?php echo Yii::t('yii','Per hour'); ?></span> <?php echo $usrCurrencySign . $guideDetails['usrHourPrice']; ?></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
               <?php
				Pjax::begin(['id' => 'Pjax_reviews', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET']]);
				?>
                        <div class="reviewguide">
                            <h6><?php echo Yii::t('yii','Reviews'); ?></h6>
				
                            <ul>
                                <?php 
                                $i = 1;
                                if(empty($reviews))
									echo '<ul><li>'.Yii::t('yii','No Reviews Yet!').'</li></ul>';
								
                                foreach ( $reviews as $review)
                                {
                                    
                                    $customerDetails = \frontend\models\users\Users::findOne($review['sender_userid']);
                                    
                                    $destination = frontend\models\Booking::findOne($review['booking_id']);
                                    
                                    if(!empty($destination) )
                                        $destinationName = $destination['booking_destination'];
                                    else
                                        $destinationName = '';
                                ?> 
                                    <li>
                                        <div class="media">
                                            <div class="media-left pull-left">
                                                <div class="feedbackwrapper">
                                                    <img src="<?= (isset($customerDetails['usrProfileImage']) ? PROFILE_IMAGE_PATH . $customerDetails['usrProfileImage'] : NOIMAGE107x114); ?>" alt="Customer profile"  onerror="this.onerror=null;this.src='<?php echo NOIMAGE107x114;?>'">
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <div class="ratedetail">
                                                    <div class="rating3">
                                                         <ul class="staricon star<?=$i?>"> </ul>
                                                        
                                                    </div>
                                                    <ul class="personname"> 
                                                        <li><?php echo Yii::t('yii','In');?> <span><?= $destinationName; ?></span></li>
                                                        <li><?php echo Yii::t('yii','By');?> <span><?= $customerDetails['usrFirstname'] . ' ' . $customerDetails['usrLastname']; ?></span></li>
                                                        <li><?php echo date('M-d-Y', strtotime($review['date_time'])); ?></li>
                                                    </ul>
                                                    <p><?= $review['comment']; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>      
                                <?php
                                    if ($review['starrating'] > 0 )
                                        $starRatingArray[] = $review['starrating'];
									else
										$starRatingArray[] = 0;
                                
                                    $i++;
                                }
                                ?>
                            </ul>
                            <nav class="paginationdesign">
                               <?php
                               //display pagination
                               if($reviewsPagination !== null):
                               echo yii\widgets\LinkPager::widget([
                                    'pagination' => $reviewsPagination,
                                    'prevPageLabel' => '<i class="fa fa-angle-left" aria-hidden="true"></i>',
                                    'nextPageLabel' => '<i class="fa fa-angle-right" aria-hidden="true"></i>',
                                    'activePageCssClass' => 'active',
                                    'disabledPageCssClass' => 'disabled',
                                    'prevPageCssClass' => 'enable',
                                    'nextPageCssClass' => 'enable',
                                    'hideOnSinglePage' => true
                               ]);
                               endif;
                               ?>
                            </nav>
                        </div>
                     <script>
var starRatingArry = '<?php echo json_encode($starRatingArray); ?>';
console.log(starRatingArry);
starRatingArry = $.parseJSON(starRatingArry);

$(document).ready(function () {
        var i = 0;
        $.each(starRatingArry, function (index, val) {

                $(".staricon.star" + i).rateYo({
                        rating: val,
                        readOnly: true,
                        starWidth: "14px",
                        ratedFill: "#f88e49",
                        normalFill: '#a7a6a6',
                });

                i++;

        });

});

					</script>  
                        <?php Pjax::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" href="<?php echo Yii::getAlias('@webThemeUrl'); ?>/css/jquery.rateyo.css"/>
<script src="<?php echo Yii::getAlias('@webThemeUrl'); ?>/js/jquery.rateyo.js"></script>

<script>
    var guide_reviews = '<?php echo isset($_GET['reviews'])?true:false?>'; 
    $(document).ready(function () {
       
        if(guide_reviews=='1') {
            $('html,body').animate({
                scrollTop: $(".reviewguide").offset().top},
                'fast');
        }
        $('#btnViewCal').on('click',function(){
            $('#from-input').click();
	});
        
        $('#review_block').on('click',function(){
            $('html,body').animate({
                scrollTop: $(".reviewguide").offset().top},
                'fast');
	});		
				
    });

</script> 

		<!-- loads jquery and jquery ui -->
		<!-- -->
		<link href="<?php echo SITE_URL; ?>frontend/web/themes/myguyde/js/datepicker/js/jquery-1.11.1.js" rel="stylesheet">
		<script type="text/javascript" src="<?php echo SITE_URL; ?>frontend/web/themes/myguyde/js/datepicker/js/jquery-ui-1.11.1.js"></script>

		<script type="text/javascript" src="<?php echo SITE_URL; ?>frontend/web/themes/myguyde/js/datepicker/jquery-ui.multidatespicker.js"></script>
		
		<script type="text/javascript">
		<!--
			var latestMDPver = $.ui.multiDatesPicker.version;
			var lastMDPupdate = '2014-09-19';
			
			$(function() {

				$('.mdp-version').text('v' + latestMDPver);
				$('#mdp-title').attr('title', 'last update: ' + lastMDPupdate);
				
				// Documentation //
				$('i:contains(type)').attr('title', '[Optional] accepted values are: "allowed" [default]; "disabled".');
				$('i:contains(format)').attr('title', '[Optional] accepted values are: "string" [default]; "object".');
				$('#how-to h4').each(function () { 
					var a = $(this).closest('li').attr('id');
					$(this).wrap('<'+'a href="#'+a+'"></'+'a>');
				});
				$('#demos .demo').each(function () { 
					var id = $(this).find('.box').attr('id') + '-demo';
					$(this).attr('id', id)
						.find('h3').wrapInner('<'+'a href="#'+id+'"></'+'a>');
				});
				
				// Run Demos
				$('.demo .code').each(function() {
					eval($(this).attr('title','NEW: edit this code and test it!').text());
					this.contentEditable = true;
				}).focus(function() {
					if(!$(this).next().hasClass('test'))
						$(this)
							.after('<button class="test">test</button>')
							.next('.test').click(function() {
								$(this).closest('.demo').find('.hasDatepicker').multiDatesPicker('destroy');
								eval($(this).prev().text());
								$(this).remove();
							});
				});
			});

		</script>
		<!-- loads some utilities (not needed for your developments) -->
		<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>frontend/web/themes/myguyde/js/datepicker/css/mdp.css">
		<script type="text/javascript" src="<?php echo SITE_URL; ?>frontend/web/themes/myguyde/js/datepicker/js/prettify.js"></script>
		<script type="text/javascript" src="<?php echo SITE_URL; ?>frontend/web/themes/myguyde/js/datepicker/js/lang-css.js"></script>
		<script type="text/javascript">
		$(function() {
			prettyPrint();

		});
		</script>
