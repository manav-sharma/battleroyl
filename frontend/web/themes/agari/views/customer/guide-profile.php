<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\Country;
use common\models\State;
use common\models\City;


#######PAGINATION#############################
use yii\widgets\LinkPager;

$this->title = Yii::t('yii','Guide Profile');
$this->params['breadcrumbs'][] = $this->title;
$attributes = Yii::$app->user->identity->getattributes();

##############= country, state, city =################
if (isset($attributes['usrCountry']) && $attributes['usrCountry'] > 0) {
    $countryName = Country ::find()->where(['id' => $attributes['usrCountry']])->one();
}

if (isset($attributes['usrState']) && $attributes['usrState'] > 0) {
    $stateName = State ::find()->where(['id' => $attributes['usrState']])->one();
}

if (isset($attributes['usrCity']) && $attributes['usrCity'] > 0) {
    $cityName = City ::find()->where(['id' => $attributes['usrCity']])->one();
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
                            <div class="guideprofilewrapper"><img src="<?= (isset($guideDetails['usrProfileImage']) ? PROFILE_IMAGE_PATH . $guideDetails['usrProfileImage'] : NO_IMAGE); ?>" alt="Guide profile"></div>
                        </div>
                        <div class="media-body">
                            <h2><?= $guideDetails['usrFirstname']. ' ' . $guideDetails['usrLastname']; ?></h2>
                            <?php
                            $city = City::findOne($guideDetails['usrCity']);       
                            
                            $starRatingArray = array();
                            ?>
                            <h6><i class="fa fa-map-marker" aria-hidden="true"></i><?= (!empty($city) ) ? $city->name : ''; ?></h6>
                            <a class="orangebtn" href="javascript:void(0);"><?php echo Yii::t('yii','Book me'); ?></a>
                            <div class="rating3">
                                <?php
                                if ($guideDetails['rating_total'] > 0 && $guideDetails['rating_outof_total'] > 0)
                                    $starRatingArray[] = 5 * ($guideDetails['rating_total'] / $guideDetails['rating_outof_total']);
                                ?>
                                
                                <ul class="staricon star0"> </ul>
                                
                                <?php
                                /* Count Reviews*/
								$totalReviews =  backend\models\feedback\feedback::find()->where(['receiver_userid'=>$guideDetails['id']])->count();
                                ?>
                                <h6><a href="javascript:void(0)"><?= (!empty($totalReviews) ) ? $totalReviews : 0; ?> <?php echo Yii::t('yii','reviews'); ?></a></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 col-md-4 col-xs-12">
                    <div class="greyhobbies">
                        <h2><?php echo Yii::$app->params['currencySymbol'] . $guideDetails['usrDayPrice']; ?><span><?php echo Yii::t('yii','per day'); ?></span></h2>
                        <div class="hobbiesborder">
                            <h6><?php echo Yii::t('yii','Interests'); ?>:</h6>
                            <ul>                                
                                <?php
                                $interests = (array)explode(',', $guideDetails['usrInterests']);                               
                                 
                                foreach ($interests as $interestId) {
                                    
                                    $interest = frontend\models\Interests::findOne($interestId);
                                    
                                    if(!empty($interest) )
                                        echo "<li><a href='javascript:void(0)'>$interest->name</a></li>";
                                }
                                ?>
                            </ul>
                            <h6><?php echo Yii::t('yii','Languages Spoken'); ?>:</h6>
                            <ul>
                                <?php
                                $languagesSpoken = (array)explode(',', $guideDetails['usrLanguage']);                               
                                 
                                foreach ($languagesSpoken as $languageId) {
                                    $language = frontend\models\Languages::findOne($languageId);
                                    
                                    if(!empty($language) )
                                        echo "<li><a href='javascript:void(0)'>$language->name</a></li>";
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
                        <div class="media-left pull-left"> <i class="fa fa-calendar-check-o" aria-hidden="true"></i> </div>
                        <div class="media-body"> <span> <?php echo Yii::t('yii','Availability');?> </span>
                            <h5>Jun 23, 2016 </h5>
                        </div>
                    </div>
                    <a href="javascript:void(0)" class="guidebtn"><?php echo Yii::t('yii','View calendar');?></a>
                    <div class="verification">
                        <h6>Verification</h6>
                        <ul>
                            <li> <i class="fa fa-check-circle" aria-hidden="true"></i> ID verified</li>
                            <li><i class="fa fa-check-circle" aria-hidden="true"></i> Email verified</li>
                            <li><i class="fa fa-check-circle" aria-hidden="true"></i> Phone number verified</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="informationdetail">
                        <div class="informationarea">
                            <h6><?php echo Yii::t('yii','About guide'); ?></h6>
                            <p>
                                <?php echo $guideDetails['usrDescription']; ?>
                            </p>
                            <a class="guidebtn" href="sendMessage.php"><?php echo Yii::t('yii','Contact guide'); ?></a> </div>
                        <div class="detailwhite">
                            <h6><?php echo Yii::t('yii','Booking information'); ?></h6>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td><span><?php echo Yii::t('yii','Per day'); ?></span> <?php echo Yii::$app->params['currencySymbol'] . $guideDetails['usrDayPrice']; ?></td>
                                        <td><span><?php echo Yii::t('yii','Per hour'); ?></span> <?php echo Yii::$app->params['currencySymbol'] . $guideDetails['usrHourPrice']; ?></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="reviewguide">
                            <h6><?php echo Yii::t('yii','Reviews'); ?></h6>
                            <ul>
                                <?php 
                                $i = 1;
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
                                                    <img src="<?= (isset($customerDetails['usrProfileImage']) ? PROFILE_IMAGE_PATH . $customerDetails['usrProfileImage'] : NO_IMAGE); ?>" alt="Customer profile">
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <div class="ratedetail">
                                                    <div class="rating3">
                                                        <!--<ul>
                                                            <li><a href="javascript:void(0)"><i aria-hidden="true" class="fa fa-star"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i aria-hidden="true" class="fa fa-star"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i aria-hidden="true" class="fa fa-star"></i></a></li>
                                                            <li><a href="javascript:void(0)"><i aria-hidden="true" class="fa fa-star"></i></a></li>
                                                            <li class="unrating"> <a href="javascript:void(0)"><i aria-hidden="true" class="fa fa-star"></i></a></li>
                                                        </ul>-->
                                                        
                                                         <ul class="staricon star<?=$i?>"> </ul>
                                                        
                                                    </div>
                                                    <ul class="personname"> 
                                                        <li>In <span><?= $destinationName; ?></span></li>
                                                        <li>By <span><?= $customerDetails['usrFirstname'] . ' ' . $customerDetails['usrLastname']; ?></span></li>
                                                        <li><?php echo date('M-d-Y', strtotime($review['date_time'])); ?></li>
                                                    </ul>
                                                    <p><?= $review['comment']; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>      
                                <?php
                                    if ($customerDetails['rating_total'] > 0 && $customerDetails['rating_outof_total'] > 0)
                                        $starRatingArray[] = 5 * ($customerDetails['rating_total'] / $customerDetails['rating_outof_total']);
                                
                                    $i++;
                                }
                                
//                                echo "<pre>";
//                                print_r($starRatingArray);die;
                                ?>
                                
                            </ul>
                            <nav class="paginationdesign">
                                <?php
                               // display pagination
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    
</section>

<link rel="stylesheet" href="<?php echo Yii::getAlias('@webThemeUrl'); ?>/css/jquery.rateyo.css"/>
<script src="<?php echo Yii::getAlias('@webThemeUrl'); ?>/js/jquery.rateyo.js"></script>

<script>
    var starRatingArry = '<?php echo json_encode($starRatingArray); ?>';

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
