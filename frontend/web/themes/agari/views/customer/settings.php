<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use common\models\Country;
use common\models\State;
use common\models\City;
use yii\db\Query;

$this->title = Yii::t('yii', 'Setting Profile');
$this->params['breadcrumbs'][] = $this->title;


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
                                    'template' => "<div class=\"col-lg-4 col-md-4 col-sm-4\">\n
                                                    <div class=\"form-group\">\n
                                                    {label}\n
                                                       <div class=\"val\">\n
                                                          <div class=\"controls\">
                                                          {input}
                                                             <div class=\"error-text\">
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

                        <div class="fullwidth">
                            <?php
                            echo $form->field($model, 'usrFirstname', ['inputOptions' => [
                                ]])->textInput(['maxlength' => 60, 'autofocus' => true]);
                            ?>
                            <?php
                            echo $form->field($model, 'usrLastname', ['inputOptions' => [
                                ],])->textInput(['maxlength' => 60, 'autofocus' => true]);
                            ?>
                            <?php
                            echo $form->field($model, 'email', ['inputOptions' => [
                                ]])->textInput(['maxlength' => 80, 'autofocus' => true]);
                            ?>
                        </div>

                        <div class="fullwidth">

                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="form-group ">
                                    <div class="val">
                                        <div class="controls">
                                            <label><?php echo Yii::t('yii', 'Gender'); ?></label>
                                            <div class="radioButton">
                                                <input type="radio" name="UpdateUser[gender]" value="<?= MALE ?>" <?= (isset($model['gender']) && $model['gender'] == MALE ? 'checked' : '') ?> <?= (isset($model['gender']) && $model['gender'] == '' ? 'checked' : '') ?>/>
                                                <span><?php echo Yii::t('yii', 'Male'); ?></span>
                                                <input type="radio" name="UpdateUser[gender]" value="<?= FEMALE ?>" <?= (isset($model['gender']) && $model['gender'] == FEMALE ? 'checked' : '') ?> />
                                                <span><?php echo Yii::t('yii', 'Female'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>				   
                            </div>				   
                        </div>
				<!-- start google autocomplete location -->
				<div class="fullwidth">
					<input id="search_user_state" type="hidden" name="UpdateUser[usrState]" value="<?php echo (isset($model['usrState']) ? $model['usrState'] : ''); ?>">
					<input id="user_country_sortname" type="hidden" name="UpdateUser[country_sortname]" value="<?php echo (isset($model['country_sortname']) ? $model['country_sortname'] : ''); ?>">

						<?php
							echo $form->field($model, 'usrAddress', ['inputOptions' => [
								'class' => "form-control textfeild",'id' => "search_destination1"
							]])->textInput(['maxlength' => 250, 'autofocus' => true]);
						?>

						<?php
							echo $form->field($model, 'usrCity', ['inputOptions' => [
								'class' => "form-control textfeild",'id' => "search_user_city"
							]])->textInput(['maxlength' => 60, 'autofocus' => true, 'readonly' => true]);
						?>

						<?php
							echo $form->field($model, 'usrCountry', ['inputOptions' => [
								'class' => "form-control textfeild",'id' => "search_user_country"
							]])->textInput(['maxlength' => 60, 'autofocus' => true, 'readonly' => true]);
						?>
				</div>
				<!-- end google autocomplete location -->
                        <div class="fullwidth">
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="form-group ">
									<input id="search_user_state" type="hidden" name="UpdateUser[dob]" value="<?php echo (isset($model['dob']) ? $model['usrState'] : ''); ?>">
                                    <label><?php echo $model->getAttributeLabel('dob'); ?></label>
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
											<div class="col-lg-4 col-md-4 col-sm-4">
                                            <select name="UpdateUser[day]" id="day">
												<?php 
													for($d=1;$d<=31;$d++) {
														echo '<option value="'.$d.'" '. (isset($dobD) && $dobD == $d ? 'selected' : '') .'>'.$d.'</option>';
													}
												?>
                                            </select>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
											<select name="UpdateUser[month]" id="month">
												<?php 
													for($m=1;$m<=12;$m++) {
														echo '<option value="'.$m.'" '. (isset($dobM) && $dobM == $m ? 'selected' : '') .'>'.$m.'</option>';
													}
												?>
                                            </select>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                            <select name="UpdateUser[year]" id="year">
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
                            
    <?php
   // $country = ArrayHelper::map(\common\models\Country::find()->where('phonecode != :codeval', ['codeval'=>0])->orderBy('phonecode')->all(), 'phonecode','phonecode');
   // echo $form->field($model, 'phonecode')->dropDownList($country, ['prompt'=>'Country Code']);
    ?>
    <div class="col-lg-4 col-md-4 col-sm-4"> 
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
												$selectBoxL = '<select name="UpdateUser[phonecode]" class="form-control" id="updateuser-phonecode">';
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
                            <?php
                            echo $form->field($model, 'usrPhone', ['inputOptions' => [
                            ]])->textInput(['maxlength' => 15, 'autofocus' => true]);
                            ?>
                        </div>

                        <div class="fullwidth">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6  fullfeild">      
                                    <div class="col-xs-12">
                                        <?php
                                        echo $form->field($modelProfilePictureUpload, 'usrProfileImage', 
                                            [
                                                'template' => '<div class="form-group">
                                                                    {label}
                                                                    <div class="val">
                                                                       <div class="controls">
                                                                            {input}
                                                                            <div class="error-text">
                                                                                {error} {hint}
                                                                            </div>
                                                                       </div>
                                                                    </div>
                                                                </div>',    
                                                'inputOptions' => ['class' => "form-control"]
                                            ])->fileInput()->label($model->getAttributeLabel('usrProfileImage'));
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
                                </div>
                            </div>					
                        </div>					

                        <div class="fullwidth">
                            <div class="col-xs-12">
                                <button class="btn btn-primary orangebtn" type="submit"><?php echo Yii::t('yii', 'Save changes'); ?></button>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</section>

<script type="text/javascript">
    var imagePath = '<?php echo NO_IMAGE; ?>';
    $(document).ready(function () {

        setTimeout(function () {
            var dobEle = document.getElementById("updateuser-dob");
            if ($(dobEle).attr('value') == '0000-00-00')
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
                $('#image_preview').attr('src', imagePath);
                $("#profPicPrevErr").html("<?php echo Yii::t('yii', 'Only jpeg, jpg gif and png Images type allowed'); ?>");
                $('#image_preview').val("");
                return false;
            } else
            {
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
            }
        });

        $('#updateuser-usrcountry').on('change', function () {
            $("#updateuser-usrstate, #updateuser-usrcity").find("option:gt(0)").remove();
            var countryID = $(this).val();
            $("#state").find("option:first").text("Loading...");
            $.ajax({
                type: 'POST',
                url: 'states',
                data: 'id=' + countryID,
                success: function (json) {
                    $("#updateuser-usrstate").find("option:first").text("<?php echo Yii::t('yii', 'Select State'); ?>");
                    for (var i = 0; i < json.length; i++) {
                        $("<option/>").attr("value", json[i].id).text(json[i].name).appendTo($("#updateuser-usrstate"));
                    }
                }
            });
        });

        $("#updateuser-usrstate").on('change', function () {
            var stateID = $(this).val();
            $("#updateuser-usrcity").find("option:gt(0)").remove();
            $("#updateuser-usrcity").find("option:first").text("Loading...");
            $.ajax({
                type: 'POST',
                url: 'updatecities',
                data: 'id=' + stateID,
                success: function (json) {
                    $("#updateuser-usrcity").find("option:first").text("<?php echo Yii::t('yii', 'Select City'); ?>");
                    for (var i = 0; i < json.length; i++) {
                        $("<option/>").attr("value", json[i].id).text(json[i].name).appendTo($("#updateuser-usrcity"));
                    }
                }
            });
        });

    });

    /*######################= Display Image =#####################*/
    function imageIsLoaded(e) {
        $("#profileImg").css("color", "green");
        $('#image_preview').css("display", "block");
        $('#previewing').attr('src', e.target.result);
        $('#previewing').attr('width', '60px');
        $('#previewing').attr('height', '60px');
    }
</script>
