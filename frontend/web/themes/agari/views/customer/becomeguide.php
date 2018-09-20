<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use common\models\Country;
use common\models\Currency;
use common\models\State;
use common\models\City;
use frontend\models\Interests;
use yii\db\Query;

$this->title = Yii::t('yii','Become an Insider');
$this->params['breadcrumbs'][] = $this->title;
//echo"<pre>"; print_r($model); exit();
?>
<section>
  <?php echo $this->render('//common/searchbox'); ?>
  <div class="form1">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-12 col-sm-12">
        <div class="formcustomer"> 
          <!-- Tab panes -->
          <div class="col-xs-12">
            <div class="row">
              <div class="col-xs-12">
              <h2><?php echo Yii::t('yii','Become an Insider');?></h2>
				<?php if (Yii::$app->session->getFlash('item')): ?>
					 <div class="alert alert-grey alert-dismissible">
						   <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
						   </button>
						   <i class="glyphicon glyphicon-ok"></i><?php echo Yii::$app->session->getFlash('item'); ?>
					 </div>																
				<?php endif; ?>
				<?php
					  $form = ActiveForm::begin(
					  [
					  'id' => 'frmBecomeGuide',
					  'options' => [
					  'enctype' => 'multipart/form-data',
					  'class' => 'inner',
					  'tag' => 'span', ####THIS OPTIONS DISABLES THE DIV.FORM_GROUP ENCLOSER TAG FOR FIELDS
					  ],
					  'fieldConfig' => [
					  'template' => "<div class=\"form-group\">\n
						 {label}\n
							<div class=\"val\">\n
							   <div class=\"controls\">
							   {input}
								  <div class=\"col-lg-10\">
								  {error} {hint}
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
               <input type="hidden" name="UpdateMember[usrLanguage]" id="updatemember-usrlanguage" value="<?= Yii::$app->language ?>" />
                <div class="fullwidth">
                  <div class="col-lg-4 col-md-4 col-sm-4">
					  <?php
					  echo $form->field($model, 'usrFirstname', ['inputOptions' => [
					  'class' => "form-control textfeild",
					  ]])->textInput(['maxlength'=>60 , 'autofocus' => true]);
					  ?>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-4">
					  <?php
					  echo $form->field($model, 'usrLastname', ['inputOptions' => [
					  'class' => "form-control textfeild",
					  ]])->textInput(['maxlength'=>60 , 'autofocus' => true]);
					  ?>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-4">
					  <?php
					  echo $form->field($model, 'email', ['inputOptions' => [
					  'class' => "form-control",
					  ]])->textInput(['maxlength'=>80 , 'autofocus' => true, 'readonly' => true]);
					  ?>
                  </div>
                </div>
                <div class="fullwidth">
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

                  <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="form-group ">
                      <div class="val">
                        <div class="controls">
						 
								<label><?php echo $model->getAttributeLabel('gender');?></label>
								<div class="radioButton">
									<input type="radio" name="UpdateMember[gender]" value="<?= MALE ?>" <?= (isset($model['gender']) && $model['gender'] == MALE ? 'checked' : '') ?> <?= (isset($model['gender']) && $model['gender'] == '' ? 'checked' : '') ?>/>
									<span><?php echo Yii::t('yii','Male');?></span>
									<input type="radio" name="UpdateMember[gender]" value="<?= FEMALE ?>" <?= (isset($model['gender']) && $model['gender'] == FEMALE ? 'checked' : '') ?> />
									<span><?php echo Yii::t('yii','Female');?></span>
								</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>
                  <div class="fullwidth">
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
                  <div class="col-lg-4 col-md-4 col-sm-4">
					  <?php
					  echo $form->field($model, 'usrPhone', ['inputOptions' => [
					  'class' => "form-control",
					  ]])->textInput(['maxlength'=>15 , 'autofocus' => true]);
					  ?>
                  </div>              
                </div>

				<!-- start google autocomplete location -->
				<div class="fullwidth">
					<input id="search_user_state" type="hidden" name="UpdateMember[usrState]" value="<?php echo (isset($model['usrState']) ? $model['usrState'] : ''); ?>">
					<input id="user_country_sortname" type="hidden" name="UpdateMember[country_sortname]" value="<?php echo (isset($model['country_sortname']) ? $model['country_sortname'] : ''); ?>">
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
						if($model->usrDayPrice==0)
							$model->usrDayPrice = '';
							
						  echo $form->field($model, 'usrDayPrice', ['inputOptions' => [
						  'class' => "form-control",
						  ]])->textInput(['maxlength'=>5 , 'autofocus' => true]);
					  ?>
                  </div>					
                  <div class="col-lg-4 col-md-4 col-sm-4">
					  <?php
						if($model->usrHourPrice==0)
							$model->usrHourPrice = '';
							
						  echo $form->field($model, 'usrHourPrice', ['inputOptions' => [
						  'class' => "form-control",
						  ]])->textInput(['maxlength'=>5 , 'autofocus' => true]);
					  ?>
                  </div>               
                </div>
				<div class="fullwidth">
					<div class="col-lg-4 col-md-4 col-sm-4">
						<div class="form-group ">
							<label><?php echo Yii::t('yii', 'Languages spoken'); ?></label>
							<div class="selectBg">
								<div class="val">
									<div class="controls">
									<span id="taggle-btn2" class="orangebtn">Choose Language</span>
									<div class="chooseInterest2">											
								<?php
										$languages = frontend\models\Languages::find()->select(['name', 'short_name'])->where(['status' => '1'])->orderBy('name ASC')->indexBy('short_name')->column();										
										$selLanguages = explode(",", $model->usrLanguage);
										$i 		= 0;
										$chk	=	'';
										foreach ($languages as $key => $language) {
											if($i%3==0) { echo'<br/>'; }
											if (in_array($key, $selLanguages)) {
												 $chk = 'checked';
											}
											echo '<div class="checkboxes"><input type="checkbox"  id="language1" name="UpdateMember[usrLanguage][]" value="'.$key.'" '.$chk.'/>'.$language.'</div>';
											$i++;
											$chk = '';
										}
								?>
									</div>
									<p><?php echo UP_LANGUAGE; ?></p>
								</div>
								</div>
							</div>
						</div>
					</div>					
					<div class="col-lg-4 col-md-4 col-sm-4">
						<div class="form-group ">
							<label><?php echo Yii::t('yii', 'Interests'); ?></label>
							<div class="selectBg">
								<div class="val">
									<div class="controls">
									<span id="taggle-btn" class="orangebtn">Choose Interest</span>
									<div class="chooseInterest">
										<?php
											$selInterests = explode(",", $model->usrInterests);
											$interests = frontend\models\Interests::find()->select(['name', 'id'])->where(['status' => '1'])->orderBy('name ASC')->indexBy('id')->column();
											$i = 0;
											$chk	=	'';
											foreach ($interests as $key => $interest) {
												if($i%3==0) { echo'<br/>'; }
												if (in_array($key, $selInterests)) {
													 $chk = 'checked';
												}
												echo '<div class="checkboxes"><input type="checkbox"  id="updatemember-usrinterests'.$i.'" name="UpdateMember[usrInterests][]" value="'.$key.'" '.$chk.'/>'.$interest.'</div>';
												$i++;
												$chk = '';
											}
										?>
									</div>
									<p><?php echo UP_INTEREST; ?></p>
									</div>
								</div>
							</div>
						</div>
					</div>	
				</div>
				<div class="fullwidth">
					<div class="col-lg-4 col-md-4 col-sm-4">
					  <?php
						  echo $form->field($modelUserIdDocumentUpload, 'usrIdDocument', ['inputOptions' => [
						  'class' => "form-control",
						  ]])->fileInput();
					  ?>           
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4">
					  <?php
						  echo $form->field($modelProfilePictureUpload, 'usrProfileImage', ['inputOptions' => ['class' => "form-control"]])->fileInput()->label(Yii::t('yii','Profile Picture'));
					  ?>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4" id="image_preview">
						<?php
							if(isset($model['gender']) && $model['gender'] == MALE)
								$noprofileimage = dummy_image_male;
							else
								$noprofileimage = dummy_image_female;

							$profPic = (isset($model['usrProfileImage']) && !empty($model['usrProfileImage']) ? PROFILE_IMAGE_PATH.$model['usrProfileImage'] : $noprofileimage);
						 ?>
						<img id="previewing" src="<?php echo $profPic; ?>" style="height:60px; width:60px;" />
				    </div>
				</div>
                <div class="fullwidth">
                  <div class="col-xs-12">
					  <?php
						echo $form->field($model, 'usrDescription',['inputOptions' => [
						  'class' => "form-control textarea",
						  ]])->textarea(array("rows"=>"4"))->label(Yii::t('yii','Describe yourself and help travelers to know a bit more about you and your interests *'));
					  ?>   
                  </div>
                </div>
                <div class="fullwidth">
                  <div class="col-xs-12">
                    <?= Html::submitButton(Yii::t('yii','Submit'), ['class' => 'btn btn-primary orangebtn', 'name' => 'BecomeGuide-submit', 'id' => 'BecomeGuide-submit']) ?>
                  </div>
                </div>
              <?php ActiveForm::end(); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
<script type="text/javascript">

	var imagePath	=	'<?php echo NO_IMAGE; ?>';
	var lan = '<?php echo Yii::$app->language ?>';
	
	$(document).ready(function () {
		
		setTimeout(function(){
			var dobEle = document.getElementById("updatemember-dob");
			if($(dobEle).attr('value') =='0000-00-00')
				return false;
			var scope = angular.element(dobEle).scope();
			scope.$apply(function () {
				scope.dt = new Date($(dobEle).attr('value'));
			});
    
		},200);
		
	/*######################= image upload =######################*/ 
		$("#profilepictureupload-usrprofileimage").change(function() { 
			$("#message").empty(); // To remove the previous error message
			var file = this.files[0];
			var imagefile = file.type;
			var match= ["image/jpeg","image/png","image/jpg","image/gif"];
			if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]) || (imagefile==match[3])))
			{
				$('#image_preview').attr('src',imagePath);
				$("#profPicPrevErr").html('<?php echo Yii::t('yii','Only jpeg, jpg gif and png Images type allowed');?>');
				$('#image_preview').val("");
				return false;
			}
			else
			{
				var reader = new FileReader();
				reader.onload = imageIsLoaded;
				reader.readAsDataURL(this.files[0]);
			}
		});
		
		$('#updatemember-usrcountry').on('change',function(){
			$("#updatemember-usrstate, #updatemember-usrcity").find("option:gt(0)").remove();
				var countryID = $(this).val();
				$("#state").find("option:first").text("Loading...");
					$.ajax({
						type:'POST',
						url:'states',
						data:'id='+countryID,
						success:function(json){
						   $("#updatemember-usrstate").find("option:first").text("<?php echo Yii::t('yii','Select State');?>");
							for (var i = 0; i < json.length; i++) {
								$("<option/>").attr("value", json[i].id).text(json[i].name).appendTo($("#updatemember-usrstate"));
							}
						}
					});
		});

		$("#updatemember-usrstate").on('change',function(){
				var stateID = $(this).val();
				$("#updatemember-usrcity").find("option:gt(0)").remove();
				$("#updatemember-usrcity").find("option:first").text("Loading...");
					$.ajax({
						type:'POST',
						url:'updatecities',
						data:'id='+stateID,
					success:function (json) {
					$("#updatemember-usrcity").find("option:first").text("<?php echo Yii::t('yii','Select city');?>");
					for (var i = 0; i < json.length; i++) {
						$("<option/>").attr("value", json[i].id).text(json[i].name).appendTo($("#updatemember-usrcity"));
					}
				}
			});
		});
	 });

	/*######################= Display Image =#####################*/
	function imageIsLoaded(e) {
		$("#profileImg").css("color","green");
		$('#image_preview').css("display", "block");
		$('#previewing').attr('src', e.target.result);
		$('#previewing').attr('width', '60px');
		$('#previewing').attr('height', '60px');
	}
</script>  

<script>
    var actionModel = '';

    //####= action model for popup =####//
    $(document).ready(function () {

		lan			= '';
		myModelThis = '';

		//####= model popup open =####//
		var lan = '<?php echo Yii::$app->language ?>';
		if(lan =='fr') {
			$("#acceptLanguageModel").modal('show');           
			actionModel = 'jobComplete';    
			myModelThis = $(this);
		} else {
			$("#updatemember-usrlanguage").val('en');
		}

        //####= yes/no popup actions =####//
        $('.bt-action').on('click', function () {        
                var confirm = $(this).data('action');
                if (confirm == 'accept')
                {
					$("#updatemember-usrlanguage").val('en,fr');
                    myModelThis.addClass('disabled');
                    $("#acceptLanguageModel").modal('hide');
                }
                else if (confirm == 'decline')
                {
					$("#updatemember-usrlanguage").val('fr');
                    $("#acceptLanguageModel").modal('hide');
                }
        });

        //####= admin commission popup =####//
        $("#updatemember-usrdayprice").on('change',function() {
			$("#adminCommissionModel").modal('show');
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
                
    });
</script>
</section>
<?php
	$query	 = new Query;
	$query->select('admin_fee')->from('admin');
	$commission = $query->createCommand()->queryOne();
?>
<div id="acceptLanguageModel" data-backdrop="static" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <div class="htop"> <i class="fa fa-exclamation-circle"></i> <b><?php echo Yii::t('yii','Attention!');?></b></div>
                <p><?php echo Yii::t('yii','Would you like to create your guide profile in english?');?></p>
                <a class="btn btn-primary bt-action" data-action="accept" href="javascript:void(0);"><?php echo Yii::t('yii','Yes');?></a>
                <a class="btn btn-primary blue bt-action" data-action="decline" href="javascript:void(0);"><?php echo Yii::t('yii','No');?></a> 
            </div>
        </div>
    </div>
</div>

<div id="adminCommissionModel" data-backdrop="static" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
            <p style="padding: 16px;"><?php echo Yii::t('yii', 'For each booking, '); ?> <strong><?php echo ((isset($commission['admin_fee']) && $commission['admin_fee'] > 0 )? floatval($commission['admin_fee']) : '1.00'); ?>%</strong>  <?php echo Yii::t('yii', ' of the booking amount will go to the admin as payment process fees.'); ?></p>
            </div>
             <div class="modal-footer">
            <button type="button" class="btn btn-primary orng-btn" data-dismiss="modal" aria-hidden="true">Ok</button>
           </div>
        </div>
    </div>
</div>


<!-- Modal code End -->
