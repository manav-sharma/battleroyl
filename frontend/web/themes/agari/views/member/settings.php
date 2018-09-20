<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use frontend\models\Interests;
use common\models\Country;
use common\models\Currency;
use common\models\State;
use common\models\City;
use yii\db\Query;

$this->title = Yii::t('yii', 'Setting Profile');
$this->params['breadcrumbs'][] = $this->title;

$attributes = Yii::$app->user->identity->getattributes();
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
				  <ul class="nav nav-tabs responsive" role="tablist" id="myTab" >
					<li role="presentation" class="active"><a href="<?php echo Url::home().'member/settings'; ?>"><?php echo Yii::t('yii','Account Information');?></a></li>
					<li role="presentation"><a  href="<?php echo Url::home().'account/settings'; ?>"><?php echo Yii::t('yii','Payout Option');?></a></li>           
				  </ul>					
				  <div class="tab-content responsive">
                    <div class="message">
                        <?php if (Yii::$app->session->getFlash('item')): ?>
                            <div class="col-xs-12">
                                <div class="alert alert-grey alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                                    </button>
                                    <i class="glyphicon glyphicon-ok"></i><?php echo Yii::$app->session->getFlash('item'); ?>
                                </div>
                            </div>																	
                        <?php endif; ?>     
                        <?php
                        $form = ActiveForm::begin(
                            [ 'id' => 'editProfile-form',
                                'options' => [
                                    'class' => 'inner',
                                    'enctype' => 'multipart/form-data',
                                    'tag' => 'span', ####THIS OPTIONS DISABLES THE DIV.FORM_GROUP ENCLOSER TAG FOR FIELDS
                                ],
                                'fieldConfig' => [
                                    'template' => "<div class=\"form-group\">\n
                                                    {label}\n
                                                       <div class=\"val\">\n
                                                          <div class=\"controls\">
                                                          {input}
                                                             <div class=\"error-text\">
                                                             {error} {hint}
                                                             </div>
                                                          </div>
                                                          </div>
                                                       </div>",
                                    'labelOptions' => ['class' => ''],
                                    'options' => [
                                        'tag' => 'span', ####THIS OPTIONS DISABLES THE DIV.FORM_GROUP ENCLOSER TAG FOR FIELDS
                                        'class' => 'inner', ####DISABLE THE DEFAULT FORM_GROUP CLASS
                                    ],
                                ],
                            ]
                        );
                        ?>

                        <div class="fullwidth">
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <?php
                                echo $form->field($model, 'usrFirstname', ['inputOptions' => [
                                        'class' => "form-control textfeild",
                                    ]])->textInput(['maxlength' => 60, 'autofocus' => true]);
                                ?>					  
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <?php
                                echo $form->field($model, 'usrLastname', ['inputOptions' => [
                                        'class' => "form-control textfeild",
                                    ]])->textInput(['maxlength' => 60, 'autofocus' => true]);
                                ?>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <?php
                                echo $form->field($model, 'email', ['inputOptions' => [
                                        'class' => "form-control",
                                    ]])->textInput(['maxlength' => 80, 'autofocus' => true]);
                                ?>
                            </div>
                        </div>

                        <div class="fullwidth">
                            
                            <div class="col-lg-4 col-md-4 col-sm-4">

                                <div class="form-group ">
                                    <div class="val">
                                        <div class="controls">
                                            <label>Gender</label>
                                            <div class="radioButton">
                                                <input type="radio" name="UpdateMember[gender]" value="<?= MALE ?>" <?= (isset($model['gender']) && $model['gender'] == MALE ? 'checked' : '') ?> <?= (isset($model['gender']) && $model['gender'] == '' ? 'checked' : '') ?>/>
                                                <span><?php echo Yii::t('yii', 'Male'); ?></span>
                                                <input type="radio" name="UpdateMember[gender]" value="<?= FEMALE ?>" <?= (isset($model['gender']) && $model['gender'] == FEMALE ? 'checked' : '') ?> />
                                                <span><?php echo Yii::t('yii', 'Female'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="form-group ">
									<?php 
										$dobY	=	0;
										$dobM	=	0;
										$dobD	=	0;								
										if(isset($model['dob']) && !empty($model['dob'])) {
												$userDOB	=	explode("-",$model['dob']);
												if(count($userDOB) > 2) {
													$dobY	=	$userDOB[0];
													$dobM	=	$userDOB[1];
													$dobD	=	$userDOB[2];
												}
										}
									?>
								    <div class="row">
                                    <div class="val">
                                        <div class="controls">
											<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
<label>Day</label>
                                            <select name="UpdateMember[day]" id="day">
												<?php 
													for($d=1;$d<=31;$d++) {
														echo '<option value="'.$d.'" '. (isset($dobD) && $dobD == $d ? 'selected' : '') .'>'.$d.'</option>';
													}
												?>
                                            </select>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
<label>Month</label>
											<select name="UpdateMember[month]" id="month">
												<?php 
													for($m=1;$m<=12;$m++) {
														echo '<option value="'.$m.'" '. (isset($dobM) && $dobM == $m ? 'selected' : '') .'>'.$m.'</option>';
													}
												?>
                                            </select>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
<label>Year</label>
                                            <select name="UpdateMember[year]" id="year">
												<?php
													$CY	=	date('Y');
													$ST	=	$CY-100;
													for($y=$ST;$y<=$CY;$y++) {
														echo '<option value="'.$y.'" '. (isset($dobY) && $dobY == $y ? 'selected' : '') .'>'.$y.'</option>';
													}
												?>
                                            </select>
                                            </div>                                            
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>                 
                            
                        </div>
                        
						<!-- start google autocomplete location -->
                        <div class="fullwidth">
							<input id="search_user_state" type="hidden" name="UpdateMember[usrState]" value="<?php echo (isset($attributes['usrState']) ? $attributes['usrState'] : ''); ?>">
							<input id="user_country_sortname" type="hidden" name="UpdateMember[country_sortname]" value="<?php echo (isset($attributes['country_sortname']) ? $attributes['country_sortname'] : ''); ?>">
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <?php
									echo $form->field($model, 'usrAddress', ['inputOptions' => [
                                        'class' => "form-control textfeild",'id' => "search_destination1"
                                    ]])->textInput(['maxlength' => 250, 'autofocus' => true]);
                                ?>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
								<?php
									echo $form->field($model, 'usrCity', ['inputOptions' => [
                                        'class' => "form-control textfeild",'id' => "search_user_city"
                                    ]])->textInput(['maxlength' => 60, 'autofocus' => true, 'readonly' => true]);
								?>                              
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <?php
									echo $form->field($model, 'usrCountry', ['inputOptions' => [
                                        'class' => "form-control textfeild",'id' => "search_user_country"
                                    ]])->textInput(['maxlength' => 60, 'autofocus' => true, 'readonly' => true]);
                                ?>
                            </div>
                        </div>
                        <!-- end google autocomplete location -->
                        
                        <div class="fullwidth">
						<div class="col-lg-4 col-md-4 col-sm-4">
							<?php
							$currency = ArrayHelper::map(Currency::find()->all(), 'id', 'currency_name');
							echo $form->field($model, 'usrCurrency')->dropDownList($currency, ['prompt' => Yii::t('yii', 'Select Currency')]);
							?>
						</div>										
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <?php
                                if ($model->usrDayPrice == 0)
                                    $model->usrDayPrice = '';

                                echo $form->field($model, 'usrDayPrice', ['inputOptions' => [
                                        'class' => "form-control textfeild",
                            ]])->textInput(['maxlength' => 4, 'autofocus' => true]);
                                ?>
                            </div>		

                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <?php
                                if ($model->usrHourPrice == 0)
                                    $model->usrHourPrice = '';

                                echo $form->field($model, 'usrHourPrice', ['inputOptions' => [
                                        'class' => "form-control textfeild",
                            ]])->textInput(['maxlength' => 4, 'autofocus' => true]);
                                ?>
                            </div>
                        </div>

                        <div class="fullwidth">
                            <div class="col-lg-4 col-md-4 col-sm-4">
                            <?php
                            //$country = ArrayHelper::map(\common\models\Country::find()->where('phonecode != :codeval', ['codeval'=>0])->orderBy('phonecode')->all(), 'phonecode','phonecode');
                            //echo $form->field($model, 'phonecode')->dropDownList($country, ['prompt'=>'Country Code']);
                            ?>

							<div class="form-group ">
								<label><?php echo Yii::t('yii', 'Country Code'); ?></label>
								<div class="selectBg">
									<div class="val">
										<div class="controls">
											<?php
												$selLanguages = explode(",", $model->phonecode);
												$query = new Query;
												$query->select('name,phonecode')->from('countries')->where('phonecode != 0')->orderby('name');
												$countries_code = $query->createCommand()->queryAll();
												$selectBoxL = '<select name="UpdateMember[phonecode]" class="form-control" id="updatemember-phonecode">';
												foreach ($countries_code as $country) {
													$name = $country['name'];
													$c_code = $country['phonecode'];
													if (in_array($c_code, $selLanguages)) {
														$selectBoxL .= "<option selected value='$c_code'>$name -($c_code)</option>";
													} else {
														$selectBoxL .= "<option value='$c_code'>$name -($c_code)</option>";
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
                            <div class="col-lg-4 col-md-4 col-sm-4">                            <?php
                                echo $form->field($model, 'usrPhone', ['inputOptions' => [
                                    ]])->textInput(['maxlength' => 15, 'autofocus' => true]);
                                ?>
                            </div>
                            <!--<div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="form-group">
                                    <div class="val">
                                        <div class="controls">
                                            <label></label>
                                            <div class="radioButton">
                                                <span><?php echo Yii::t('yii', 'Click here to select available days'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                            <?php
                            #####################= Availability time =#####################

                            $query = new Query;
                            $query->select('*')->from('user_availability')->where('user_id = ' . Yii::$app->user->getId());
                            $availabilty = $query->createCommand()->queryOne();
                            $aval = "'" . date('m/d/Y') . "'";
                            if (isset($availabilty['available_dates']) && !empty($availabilty['available_dates'])) {
                                $arrDates = explode(",", $availabilty['available_dates']);
                                $newArr = array();
                                foreach ($arrDates as $row) {
                                    $newArr[] = "'$row'";
                                }
                                $aval = implode(", ", $newArr);
                            }
                            ?>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="form-group ">
                                    <label><?php echo Yii::t('yii', 'Select your availabilities'); ?></label>
                                    <div class="val">
                                        <div class="controls">
                                            <div class="demo viewcalender">
                                                <input type="text" value="Select your availabilities" class="form-control" readonly>
                                                <input type="text" id="from-input" name="UpdateMember[usrAvailability]" id="updatemember-usravailability" class="form-control" value="" readonly style="width: 100%;">
                                                <div class="code-box">
                                                    <pre class="code prettyprint" style="display:none;">
                                                        var date = new Date();
                                                        var y = date.getFullYear();
                                                        $('#from-input').multiDatesPicker({
                                                                altField: '#from-input',		
                                                                minDate: 0,
                                                                addDates: [<?= $aval ?>],
                                                                adjustRangeToDisabled: true,
                                                                showButtonPanel: true,	
                                                                onSelect: function(dateText, inst) { 
                                                                        inst.settings.defaultDate = dateText; 
                                                                }
                                                        });
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

						<input type="hidden" name="UpdateMember[usrAvailableTime]" id="updatemember-usravailabletime" value="ANY" />
                        </div>
                        
<div class="fullwidth">
<div class="col-lg-4 col-md-4 col-sm-4">
    <div class="form-group ">
        <label><?php echo Yii::t('yii', 'Languages spoken'); ?></label>
                                    
    <div class="selectBg">
        <div class="val">
            <div class="controls" id="usr_languages">
									<span id="taggle-btn2" class="orangebtn">Choose Language</span>
									<div class="chooseInterest2">														
										<?php
    $languages = frontend\models\Languages::find()->select(['name', 'short_name'])->where(['status' => '1'])->orderBy('name ASC')->indexBy('short_name')->column();							                   $selLanguages = explode(",", $model->usrLanguage);
                                                                        $i = 0;
                                                                        $chk = '';
    foreach ($languages as $key => $language) {
        if($i%3==0) { echo'<br/>'; }
        if (in_array($key, $selLanguages)) $chk = 'checked';
													echo '<div class="checkboxes"><input type="checkbox"  id="language1" name="UpdateMember[usrLanguage][]" value="'.$key.'" '.$chk.'/>'.$language.'</div>';
        $i++;
        $chk = '';
    }
?>
                                            </div>
<?php    
    echo $form->field($model, 'chkusrLanguage', ['inputOptions' => ['class' => "form-control textfeild",]])->hiddenInput()->label(false);
?>

                                        </div>
                                        <p><?php echo UP_LANGUAGE; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>		
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="form-group ">
                                    <label><?php echo Yii::t('yii', 'Interests'); ?></label>
                                    <div class="selectBg">
                                        <div class="val">
                                            <div class="controls" id="usr_interests">
											<span id="taggle-btn" class="orangebtn">Choose Interest</span>
                                            <div class="chooseInterest">
<?php
    $selInterests = explode(",", $model->usrInterests);
    $interests = frontend\models\Interests::find()->select(['name', 'id'])->where(['status' => '1'])->orderBy('name ASC')->indexBy('id')->column();
										    $i = 0;	
    $chk	=	'';
    foreach ($interests as $key => $interest) {             
        if($i%3==0) { echo'<br/>'; }
        if (in_array($key, $selInterests))$chk = 'checked';                 echo '<div class="checkboxes"><input type="checkbox"  id="updatemember-usrinterests'.$i.'" name="UpdateMember[usrInterests][]" value="'.$key.'" '.$chk.'/>'.$interest.'</div>';
        $i++;
        $chk = '';
    }
   
?>
                                            </div>
                                                                    <?php
     echo $form->field($model, 'chkusrInterests', ['inputOptions' => ['class' => "form-control textfeild",]])->hiddenInput()->label(false);                                                                    ?>
                                            </div>
                                            <p><?php echo UP_INTEREST; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>     
                        
                        <div class="fullwidth">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 fullfeild">
                                    <div class="col-xs-12 ">
                                        <?php
                                        echo $form->field($modelUserIdDocumentUpload, 'usrIdDocument', ['inputOptions' => [
                                                'class' => "form-control",
                                    ]])->fileInput();
                                        ?> 
                                    </div>
                                    <div class="col-xs-12">
                                        <a class="documentpdf" target="_blank" href="<?php echo (isset($model['usrIdDocument']) && !empty($model['usrIdDocument']) ? DOCUMENT_DOWNLOAD_PATH . $model['usrIdDocument'] : 'javascript:void()'); ?>"><?php echo (isset($model['usrIdDocument']) ? substr($model['usrIdDocument'], -10) : ""); ?></a>			  
                                    </div>

                                </div>			   

                                <div class="col-lg-6 col-md-6 col-sm-6  fullfeild">      
                                    <div class="col-xs-12">
                                        <?php
                                        echo $form->field($modelProfilePictureUpload, 'usrProfileImage', ['inputOptions' => ['class' => "form-control"]])->fileInput();
                                        ?>
                                    </div>


                                    <div class="col-xs-12">
                                        <?php
                                        if (isset($model['gender']) && $model['gender'] == MALE)
                                            $noprofileimage = dummy_image_male;
                                        else
                                            $noprofileimage = dummy_image_female;

                                        $profPic = (isset($model['usrProfileImage']) && !empty($model['usrProfileImage']) ? PROFILE_IMAGE_PATH . $model['usrProfileImage'] : $noprofileimage);
                                        ?>
                                        <img id="previewing" src="<?php echo $profPic; ?>" style="height:60px; width:60px;" />				  
                                    </div>


                                </div> </div></div>
                        <div class="fullwidth">
                            <div class="col-xs-12">
                                <?php
                                echo $form->field($model, 'usrDescription', ['inputOptions' => [
                                        'class' => "form-control textarea",
                                ]])->textarea(array("rows" => "4"))->label(Yii::t('yii','Describe yourself and help travelers to know a bit more about you and your interests.'));
                                ?>
                                <div id="usrDescription-helptext" class="help-text">150 characters minimum</div>
                            </div>
                        </div>
                        <div class="fullwidth">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-primary orangebtn"><?php echo Yii::t('yii', 'Save changes'); ?></button>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<script type="text/javascript">
    var imagePath = '<?php echo NO_IMAGE; ?>';
    var bob = $('#updatemember-dob').val('<?= $model['dob'] ?>');

    $(document).ready(function () {

        setTimeout(function () {
            var dobEle = document.getElementById("updatemember-dob");
            if ($(dobEle).attr('value') == '0000-00-00' || $(dobEle).attr('value') == '')
                return false;
            var scope = angular.element(dobEle).scope();
            scope.$apply(function () {
                scope.dt = new Date($(dobEle).attr('value'));
            });

        }, 300);

        /*######################= image upload =######################*/
        $("#profilepictureupload-usrprofileimage").change(function () {
            $("#message").empty(); // To remove the previous error message
            var file = this.files[0];
            var imagefile = file.type;
            var match = ["image/jpeg", "image/png", "image/jpg", "image/gif"];
            if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]) || (imagefile == match[3])))
            {

                $("#profPicPrevErr").html("<?php echo Yii::t('yii', 'Only jpeg, jpg gif and png Images type allowed'); ?>");

                return false;
            } else
            {
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
            }
        });

        $('#updatemember-usrcountry').on('change', function () {
            $("#updatemember-usrstate, #updatemember-usrcity").find("option:gt(0)").remove();
            var countryID = $(this).val();
            $("#state").find("option:first").text("Loading...");
            $.ajax({
                type: 'POST',
                url: 'states',
                data: 'id=' + countryID,
                success: function (json) {
                    $("#updatemember-usrstate").find("option:first").text("<?php echo Yii::t('yii', 'Select State'); ?>");
                    for (var i = 0; i < json.length; i++) {
                        $("<option/>").attr("value", json[i].id).text(json[i].name).appendTo($("#updatemember-usrstate"));
                    }
                }
            });
            });

        $("#updatemember-usrstate").on('change', function () {
            var stateID = $(this).val();
            $("#updatemember-usrcity").find("option:gt(0)").remove();
            $("#updatemember-usrcity").find("option:first").text("Loading...");
            $.ajax({
                type: 'POST',
                url: 'updatecities',
                data: 'id=' + stateID,
                success: function (json) {
                    $("#updatemember-usrcity").find("option:first").text("<?php echo Yii::t('yii', 'Select City'); ?>");
                    for (var i = 0; i < json.length; i++) {
                        $("<option/>").attr("value", json[i].id).text(json[i].name).appendTo($("#updatemember-usrcity"));
                    }
                }
            });
        });
 
        $("#updatemember-usrinterests").on('click', 'option', function() {
            if ($("#updatemember-usrinterests option:selected").length > 3) {
                $(this).removeAttr("selected");
                    alert('You can select upto 3 options only');
            }
        });           

	$("#taggle-btn").click(function() {
            $(".chooseInterest").toggle();
        });
 
         $("#taggle-btn2").click(function() {
            $(".chooseInterest2").toggle();
        });
        
               
        $("#usr_languages input[type='checkbox']").on('click',function(){
            if($(this).is(':checked'))
                $('#updatemember-chkusrlanguage').val('1');
            else
                $('#updatemember-chkusrlanguage').val('');
        });
        
        $("#usr_interests input[type='checkbox']").on('click',function(){
            if($(this).is(':checked'))
                $('#updatemember-chkusrinterests').val('1');
            else
                $('#updatemember-chkusrinterests').val('');
        });
        
        $('#editProfile-form').on('submit',function(){
            if($("#usr_languages input[type='checkbox']:checked").length > 0)
            $('#updatemember-chkusrlanguage').val('1');
        
            if($("#usr_interests input[type='checkbox']:checked").length)
                $('#updatemember-chkusrinterests').val('1');
            
            return;
        });
        
        /*### Remaining character count in description ###*/
        var text_max = 150;
        $('#usrDescription-helptext').html(text_max + ' characters minimum');
        var textlength = $('#updatemember-usrdescription').val().length;
        if(textlength>150) {
            $('#usrDescription-helptext').html('0 characters minimum'); 
        }   
        $('#updatemember-usrdescription').keyup(function() {
            var text_length = $('#updatemember-usrdescription').val().trim().length;
            var text_remaining = text_max - text_length;
            if(text_remaining<=0)
                text_remaining = 0;
            $('#usrDescription-helptext').html(text_remaining + ' characters minimum');
        });
            
    });

        /*######################= Display Image =#####################*/
        function imageIsLoaded(e) {
            $("#profileImg").css("color", "green");
            $('#previewing').attr('src', e.target.result);
            $('#previewing').attr('width', '60px');
            $('#previewing').attr('height', '60px');
        }
    </script>  

    <!-- loads jquery and jquery ui -->
    <!-- -->
    <link href="<?php echo SITE_URL; ?>frontend/web/themes/myguyde/js/datepicker/js/jquery-1.11.1.js" rel="stylesheet">
    <script type="text/javascript" src="<?php echo SITE_URL; ?>frontend/web/themes/myguyde/js/datepicker/js/jquery-ui-1.11.1.js"></script>
    <!-->
    <script type="text/javascript" src="js/jquery-2.1.1.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.11.1.js"></script>
    <!-- -->

    <!-- loads mdp -->
    <script type="text/javascript" src="<?php echo SITE_URL; ?>frontend/web/themes/myguyde/js/datepicker/jquery-ui.multidatespicker.js"></script>

    <script type="text/javascript">
<!--
    var latestMDPver = $.ui.multiDatesPicker.version;
	var lastMDPupdate = '2014-09-19';

$(function () {
// Version //
//$('title').append(' v' + latestMDPver);
$('.mdp-version').text('v' + latestMDPver);
$('#mdp-title').attr('title', 'last update: ' + lastMDPupdate);

// Documentation //
$('i:contains(type)').attr('title', '[Optional] accepted values are: "allowed" [default]; "disabled".');
$('i:contains(format)').attr('title', '[Optional] accepted values are: "string" [default]; "object".');
$('#how-to h4').each(function () {
var a = $(this).closest('li').attr('id');
$(this).wrap('<' + 'a href="#' + a + '"></' + 'a>');
});
$('#demos .demo').each(function () {
var id = $(this).find('.box').attr('id') + '-demo';
$(this).attr('id', id)
        .find('h3').wrapInner('<' + 'a href="#' + id + '"></' + 'a>');
});

// Run Demos
$('.demo .code').each(function () {
eval($(this).attr('title', 'NEW: edit this code and test it!').text());
this.contentEditable = true;
}).focus(function () {
if (!$(this).next().hasClass('test'))
    $(this)
            .after('<button class="test">test</button>')
            .next('.test').click(function () {
        $(this).closest('.demo').find('.hasDatepicker').multiDatesPicker('destroy');
        eval($(this).prev().text());
        $(this).remove();
    });
});
});
// -->
    </script>
    <!-- loads some utilities (not needed for your developments) -->
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>frontend/web/themes/myguyde/js/datepicker/css/mdp.css">
    <script type="text/javascript" src="<?php echo SITE_URL; ?>frontend/web/themes/myguyde/js/datepicker/js/prettify.js"></script>
    <script type="text/javascript" src="<?php echo SITE_URL; ?>frontend/web/themes/myguyde/js/datepicker/js/lang-css.js"></script>
    <script type="text/javascript">
		$(function () {
			prettyPrint();
		});
    </script>

    <script>
        var actionModel = '';

        //####= action model for popup =####//
        $(document).ready(function () {

            //####= admin commission popup =####//
            $("#updatemember-usrdayprice").on('change', function () {
                $("#adminCommissionModel").modal('show');
            });

            //####= admin commission popup =####//
            //~ $("#updatemember-usrhourprice").on('change',function() {
            //~ $("#adminCommissionModel").modal('show');
            //~ });		

        });
    </script>			
</section>
<?php
$query = new Query;
$query->select('admin_fee')->from('admin');
$commission = $query->createCommand()->queryOne();
?>
<div id="adminCommissionModel" data-backdrop="static" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
				<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button> -->
                <p style="padding: 16px;"><?php echo Yii::t('yii', 'For each booking, '); ?> <strong><?php echo ((isset($commission['admin_fee']) && $commission['admin_fee'] > 0 )? floatval($commission['admin_fee']) : '1.00'); ?>%</strong>  <?php echo Yii::t('yii', ' of the booking amount will go to the admin as payment process fees.'); ?></p>
               
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary orng-btn" data-dismiss="modal" aria-hidden="true">Ok</button>
           </div>
        </div>
    </div>
</div>
