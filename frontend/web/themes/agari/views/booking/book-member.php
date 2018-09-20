<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;  
use yii\bootstrap\ActiveForm;
use common\models\Currency;
use yii\db\Query;

$this->title = Yii::t('yii','Book Validation');
$this->params['breadcrumbs'][] = $this->title;
$attributes = Yii::$app->user->identity->getattributes();
$booking_details = Yii::$app->session->get('booking_details');

$query = new Query;
$query->select('service_fee')->from('admin');
$service_fee = $query->createCommand()->queryOne();
$service_charge	=	0;
if(isset($service_fee['service_fee']) && $service_fee['service_fee'] > 0 )
{
	$service_charge	=	$service_fee['service_fee'];
}

if(isset($member_info['usrCurrency']) && $member_info['usrCurrency'] > 0) { 
	$currency	=	Currency ::find()->where(['id' => $member_info['usrCurrency']])->one();
}
$currency_sign	=	(isset($currency['currency_sign']) ? $currency['currency_sign'] : "$");
$currency_name	=	(isset($currency['currency_name']) ? $currency['currency_name'] : "USD");
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
			  <div class="col-xs-12">
				 <div class="alert alert-grey alert-dismissible">
					   <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
					   </button>
					   <i class="glyphicon glyphicon-ok"></i><?php echo Yii::$app->session->getFlash('item'); ?>
				 </div>
			  </div>
			  <?php endif; ?>

			<div class="wizard">
            <div class="wizard-inner">
               <!--  <div class="connecting-line"></div> -->
                <ul class="nav nav-tabs" role="tablist">

                    <li role="presentation" class="active">
                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Booking Details"> <?php echo Yii::t('yii','Booking Details');?>
                        
                        </a>
                    </li>

                    <li role="presentation">
                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Booking Summary" class="fnxt"> <?php echo Yii::t('yii','Booking Summary');?>
                        </a>
                    </li>

<!--
                    <li role="presentation">
                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Confirm Booking"> <?php //echo Yii::t('yii','Confirm');?>
                        </a>
                    </li>
-->

                </ul>
            </div>

			<?php
               $form = ActiveForm::begin(
                  ['id' => 'booking-form',
                  'options' => [
                  'class'=>'',
                  'tag' => 'span', ####THIS OPTIONS DISABLES THE DIV.FORM_GROUP ENCLOSER TAG FOR FIELDS
                  ],
                  'fieldConfig' => [
                  'template' => "<div class=\"col-lg-6 col-md-6 col-sm-8 col-xs-8 \">\n
                     <div class=\"form-group\">\n
                     {label}\n
                        <div class=\"val\">\n
                           <div class=\"controls\">
                           {input}
                              <div class=\"col-lg-10\">
                              {error} {hint}
                              </div>
                           </div>
                           </div>
                        </div>
                     </div>",
                  'labelOptions' => ['class' => ''],
                  'options' => [
                  'tag' => 'span', ####THIS OPTIONS DISABLES THE DIV.FORM_GROUP ENCLOSER TAG FOR FIELDS
                  'class' => '', ####DISABLE THE DEFAULT FORM_GROUP CLASS
                  ],
                  ],
                  ]
                 );
                ?>
				<input type="hidden" name="usrDayPrice" value="<?php echo $member_info['usrDayPrice']; ?>" />
				<input type="hidden" name="usrHourPrice" value="<?php echo $member_info['usrHourPrice']; ?>" />
				<input type="hidden" name="Booking[currency_sign]" id="currency_sign" value="<?php echo $currency_sign; ?>" />
				<input type="hidden" name="Booking[currency_name]" id="currency_name" value="<?php echo $currency_name; ?>" />
                <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="step1">

						 <div class="fullwidth">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="form-group">
									<input type="radio" name="bookType" id="bookDaily" class="bookingTDH" value="D" checked /> Daily
									<input type="radio" name="bookType" id="bookHourly" class="bookingTDH" value="H" /> Hourly
								</div>
							</div>
							</div>
							<div class="fullwidth">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="form-group ">
									<label><?php echo Yii::t('yii', 'Travelers'); ?></label>
									<div class="selectBg">
										<div class="val">
											<div class="controls">
												<?php
													$pre_val = Yii::$app->session->get('travellers');
													$selectBoxL = '<select name="booked_travelers" class="form-control" id="booking-travelers">';
													for($i = 2; $i <= 10; $i++) {
														$sel	=	'';
														if($pre_val == $i) { $sel = "selected"; }
														if($i == 10) {
															$selectBoxL .= "<option value='$i+' $sel>$i+ Travelers</option>";
														} else {
															$selectBoxL .= "<option value='$i' $sel>$i Travelers</option>";
														}
													}
													$selectBoxL .= "</select>";
													echo $selectBoxL;
												?>
											</div>
										</div>
									</div>
								</div>
                            </div>							
							
						</div>
                        
						 <div class="fullwidth">
						  
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="form-group">
									<label id="f_d1"><?php echo Yii::t('yii','From date');?></label>
								   <?php
									   echo $form->field($model, 'booked_from_date', ['template'=>'<div class="val"><div class="controls"><div class="input-group innerDate" ng-controller="DatepickerDemoCtrlSearch">{input}<div class=\"col-lg-10\">{error} {hint}</div><span class="input-group-addon" ng-click="open1()"><i class="fa fa-calendar" aria-hidden="true"></i></span></div></div></div>','inputOptions' => ['class'=>'form-control','uib-datepicker-popup'=>'{{format_p}}','ng-model'=>'dtStart','is-open'=>'popup1.opened','datepicker-options'=>'dateOptions','ng-required'=>'true','close-text'=>'Close','alt-input-formats' => 'altInputFormats','ng-change'=>'onSelectDate(dtStart)'
									   ]])->textInput(['readonly' => true])->label(false);
									   
									   
								   ?>
								</div>
							</div>			   

							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="t_d1">
								<div class="form-group">
									<label><?php echo Yii::t('yii','To date');?></label>
								   <?php
									   echo $form->field($model, 'booked_to_date', ['template'=>'<div class="val"><div class="controls"><div class="input-group innerDate" ng-controller="DatepickerDemoCtrlSearch">{input}<div class=\"col-lg-10\">{error} {hint}</div><span class="input-group-addon" ng-click="open1()"><i class="fa fa-calendar" aria-hidden="true"></i></span></div></div></div>','inputOptions' => ['class'=>'form-control','uib-datepicker-popup'=>'{{format_p}}','ng-model'=>'dtTo','is-open'=>'popup1.opened','datepicker-options'=>'dateOptions','ng-required'=>'true','close-text'=>'Close','alt-input-formats' => 'altInputFormats','ng-change'=>'onSelectToDate(dtTo)'
									   ]])->textInput(['readonly' => true])->label(false);
								   ?>
								</div>
							</div>
						</div>
						<div class="fullwidth searchleft" id="noOfHours" style="display:none;">
        <?php
                $items[0] = Yii::t('yii','Number of hours');
                for($i=2;$i<7;$i++) {
                        $items[$i] = $i;
                }
                //$items[8] = 'More than 7';

                echo $form->field($model, 'no_of_hours', ['inputOptions' => [
                         ]])->dropDownList(
$items, []  // options
)->label('Number of hours');
        ?>
						</div>
						
						
						<div class="fullwidth">
						  <div class=" list-inline pull-right">
							<button class="btn btn-primary orangebtn next-step fnxt" type="button"><?php echo Yii::t('yii','Next');?></button>
						  </div>
						</div>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step2">                       <div class="fullwidth">
                            <div class="col-xs-12"> 
                                <div class="twoColumnNew">
        <div class="left">
            <table class="table" cellpadding="0" cellspacing="0">
                <tr>
                    <td> Destination <br>
                            <span id="bookdesination"><?php echo (isset($search_String) ? $search_String : ''); ?></span>
                    </td>
                </tr>
            </table>
        </div>
        <div class="left">                   
            <table class="table" cellpadding="0" cellspacing="0">                   
				<tr>
					<td class="day_date"> from <br>                                                      
						<span id="fdate"><?php echo date("d/m/Y"); ?></span>                 
					</td>                                                              
					<td class="day_date"> to <br>                                                            
						<span id="tdate"><?php echo date("d/m/Y"); ?></span>            
					</td>
					
				   <td colspan="2" class="fday_date" style="display:none;"> Date <br>                                                           
						<span id="fday_date"><?php echo date("d/m/Y"); ?></span>           
				   </td>
                </tr>     
            </table>
	</div>
        <div class="left">                   
            <table class="table" cellpadding="0" cellspacing="0">                   <tr><td> Number of Travelers <br>
                            <span id="travelers_count"><?= $travellers_Cnt ?></span>
                    </td>                                                           </tr>     
            </table>
	</div>
                     
        <div class="">
            <table class="table" cellpadding="0" cellspacing="0">
                <tr>
                    <td> 
                        Subtotal: <br>
                        <span id="hprice"><?= $currency_sign .''. $member_info['usrHourPrice'] ?></span>
                        <span id="mprice"><?= $currency_sign .''. $member_info['usrDayPrice'] ?></span>
                        X <span id="bookingfor">3 days</span>
                        
                        =     
                        
                        <span id="subtotal_price"><?= $currency_sign .''. $member_info['usrDayPrice'] ?></span>
                    </td>
                   
                <!--<td id="hourly_rate"> Per hour Price<br>
                        <span id="hprice"><?= $currency_sign .''. $member_info['usrHourPrice'] ?></span>
                </td>
                <td id="daily_rate"> Per Day Price <br>
                        <span id="mprice"><?= $currency_sign .''. $member_info['usrDayPrice'] ?></span>
                </td>
                <td> Booking For <br>
                        <span id="bookingfor">3 days</span>
                </td>-->
                </tr>
            </table>
        </div>
        <div class="">
            <table class="table" cellpadding="0" cellspacing="0">
                <tr>
                    <td>MyGuyde Service Fee <br>
                            <span id="servicefee"><?= $currency_sign .''. $service_charge ?></span>
                    </td>                
                </tr>
            </table>
        </div>
    </div>
                <div class="totalPrice">
					
					<div class=" col-md-6 col-sm-4 col-xs-4 tpOuter"> Total Price <br>
                <span id="tprice"><?= $currency_sign .''. $member_info['usrDayPrice'] ?></span> </div>
					
                  <?php
                    $model->payment_method = 'PayPal';
                    echo $form->field($model, 'payment_method')->radioList(['PayPal'=>Yii::t('yii','PayPal'),'CDCard'=>Yii::t('yii','Credit/Debit Card')],[]);
                ?>  
                    
                   
                </div>
                
            </div>
    </div>

                       <div class="fullwidth">
						  <div class="list-inline pull-right">
							<button class="btn btn-primary orangebtn prev-step" type="button"><?php echo Yii::t('yii','Previous');?></button>
							<button class="btn btn-primary orangebtn next-step" type="submit"><?php echo Yii::t('yii','Continue');?></button>
						  </div>
						</div>
                    </div>

                    <div class="tab-pane" role="tabpanel" id="step3">
						<p> Continue to booking... </p>
                        <div class="fullwidth">
						  <div class="list-inline pull-right">
							<button class="btn btn-primary orangebtn prev-step" type="button"><?php echo Yii::t('yii','Previous');?></button>
							<button class="btn btn-primary orangebtn next-step" type="submit"><?php echo Yii::t('yii','Continue');?></button>
						  </div>
						</div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php ActiveForm::end(); ?>
              </div>
              </div>
            </div>
         </div>
      </div>
</section>
<style>
    .inner .controls{
	margin-bottom:15px;
    }
    
</style>
<script>
var searchDate = '<?php echo Yii::$app->session->get('searchpost')['searchdate'];?>';
    
$(document).ready(function () {
    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();
    
    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var $target = $(e.target);
    
        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);

    });
    $(".prev-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);

    });
    
    //#######################= booking details =######################//
	show_booking_details();
	$("#booking-no_of_hours").change(function(e) {
		show_booking_details();
	});

	$(".fnxt").click(function(e) {
		show_booking_details();
	});
	
	if($('#bookDaily').is(':checked')) { 
		$("#noOfHours").css("display","none"); $("#booking-no_of_hours").val(0);
                            $('#f_d1').text("From date");
							$('#t_d1').css("display","block");					 
	}
	if($('#bookHourly').is(':checked')) {
		$("#noOfHours").css("display","block"); 	
							$('#f_d1').text("Date");
							$('#t_d1').css("display","none");			 
	}
		 	
    $(".bookingTDH").click(function (e) {
            if($('#bookDaily').is(':checked')) { 
                    $("#noOfHours").css("display","none"); $("#booking-no_of_hours").val(0); 	
                            $('#f_d1').text("From date");
							$('#t_d1').css("display","block");		
            }
            if($('#bookHourly').is(':checked')) {
                    $("#noOfHours").css("display","block"); 
							$('#f_d1').text("Date");
							$('#t_d1').css("display","none");                    			 
            }
    });
    
    if(searchDate != ''){
        var date_arr = searchDate.split('-');
        //console.log(date_arr[0]+'--'+date_arr[1]+'--'+date_arr[2]);
        var sdate = new Date(date_arr[0],date_arr[1]-1,date_arr[2]);
       
        angular.element(document.getElementById("booking-booked_from_date")).scope().dtStart = sdate;
        angular.element(document.getElementById("booking-booked_to_date")).scope().dtTo = sdate;
        
        var controllerElement = document.querySelector('div[ng-controller="DatepickerDemoCtrlSearch"]');
	var controllerScope = angular.element(controllerElement).scope();
        controllerScope.dtStart = sdate;
    }
    
});

function nextTab(elem) {
	if($('#step1 .has-error').length > 0) return;
	
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}

function updateToMinDate(dt){
    console.log(dt);
	var dtStartScope = angular.element(document.getElementById("booking-booked_from_date")).scope();
	var scope = angular.element(document.getElementById("booking-booked_to_date")).scope();
	
	scope.dtTo = dt;

	var controllerElement = document.querySelector('div[ng-controller="DatepickerDemoCtrlSearch"]');
	var controllerScope = angular.element(controllerElement).scope();
	console.log(controllerScope.dtStart);
	
	/*controllerScope.$apply(function(controllerScope){
		controllerScope.dtStart = dt;
	});*/
	scope.dateOptions.minDate = dt;
}
function hideNoOfHours(){
	$('#noOfHours').hide();
}
function showNoOfHours(){
	$('#noOfHours').show();
}

function show_booking_details() {
	var mdayprice		=	"<?= $member_info['usrDayPrice'] ?>";
    var mhourlyprice	=	"<?= $member_info['usrHourPrice'] ?>";
    var servicecharges	=	"<?= $service_charge ?>";
    
    var	f_date			=	$("#booking-booked_from_date").val();
    var	t_date			=	$("#booking-booked_to_date").val();
    var	bookhours		=	$("#booking-no_of_hours").val();
    var	currency_sign	=	$("#currency_sign").val();
	var	booktravelers   =	$("#booking-travelers").val();

	var date1 = new Date(f_date);
	var date2 = new Date(t_date);
	var timeDiff = Math.abs(date2.getTime() - date1.getTime());
	var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
	if(diffDays > 0) {
		var	tprice = mdayprice*(diffDays+1);
		$('#bookingfor').text(diffDays+1+" days");
		$("#mprice").css("display","");
		$("#hprice").css("display","none");

		$(".fday_date").css("display","none");
		$(".day_date").css("display","block");
	} else {
		if(bookhours > 0)	{
			var	tprice = mhourlyprice*bookhours;
			$('#bookingfor').text(bookhours+" hours");
			$("#mprice").css("display","none");
			$("#hprice").css("display","");

			$(".day_date").css("display","none");
			$(".fday_date").css("display","block");
		} else {
			var	tprice = mdayprice*1;
			$('#bookingfor').text(diffDays+1+" day");
			$("#mprice").css("display","");
			$("#hprice").css("display","none");

			$(".fday_date").css("display","none");			
			$(".day_date").css("display","block");				
		}
	}
	
	var service_fee	=	(servicecharges/100)*tprice;
        service_fee = Math.round(service_fee * 100) / 100
	
	$('#fdate').text(f_date);
	$('#tdate').text(t_date);
	$('#subtotal_price').text(currency_sign+tprice);
	$('#fday_date').text(t_date);
        tprice	=	tprice+service_fee;
	$('#tprice').text(currency_sign+tprice);
	$('#servicefee').text(currency_sign+service_fee);
	$('#travelers_count').text(booktravelers);
}
</script>
