<?php
use yii\helpers\Html;

use yii\bootstrap\ActiveForm;
use yii\widgets\DetailView;
use common\models\Country;
use common\models\State;
use common\models\City;
use yii\helpers\ArrayHelper;

$this->title = 'Setting Profile';
$this->params['breadcrumbs'][] = $this->title;

?>
<section>
  <div class="mainheading">
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0">
        </div>
      </div>
    </div>
    <div class="bordertopwhite">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12 ">
            <div class="headinginner"> Settings </div>
            <?php if (Yii::$app->session->getFlash('item')): ?>
                              <div class="col-xs-12">
                                 <div class="alert alert-grey alert-dismissible">
                                       <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>
                                       </button>
                                       <i class="glyphicon glyphicon-ok"></i><?php echo Yii::$app->session->getFlash('item'); ?>
                                 </div>
                              </div>																	
                              <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="searchresult">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-4 col-xs-12">
          <?php echo $this->render('sidebar'); ?>
        </div>
        <div class="col-xs-12 col-sm-8 col-md-9">
          <div class="message">
     
				<!-- <form action="" id="frmAddUser" name="frmAddUser" method="POST" class="inner"> -->
               <?php
               $form = ActiveForm::begin(
                  [ 'id' => 'editProfile-form',
                  
                  'options' => [
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

                <div class="fullwidth">
               <?php
                     echo $form->field($model, 'usrFirstname', ['inputOptions' => [
                     ]])->textInput()->label('First Name');
               ?>
               <?php
                     echo $form->field($model, 'usrLastname', ['inputOptions' => [
                     ]])->textInput()->label('Last Name');
               ?>
               <?php
                     echo $form->field($model, 'email', ['inputOptions' => [
                     ]])->textInput()->label('Email');
               ?>
				</div>
			<div class="fullwidth">
               <?php
                     echo $form->field($model, 'usrLastname', ['inputOptions' => [
                     ]])->textInput()->label('Last Name');
               ?>
               <?php
                     echo $form->field($model, 'email', ['inputOptions' => [
                     ]])->textInput()->label('Email');
               ?>
                  

                 <?php
                  $items = array('Male' => 'Male', 'Female' => 'Female');
                  echo $form->field($model, 'gender', ['inputOptions' => [
                  'class' => "controls",

                  ]])->inline()->radioList($items)->label('Gender');
                  ?>
                </div>
				
                <div class="fullwidth">
                      <?php 
                      $country = ArrayHelper::map(Country::find()->all(), 'id', 'name');

                          echo $form->field($model, 'usrCountry')
                          ->dropDownList(
                            $country,

                            ['prompt'=>'select country'],  
                            ['onchange'=>'this.form.submit()']  // options
                        )->label('City');
                      ?>
                

                      <?php 
                      $country = ArrayHelper::map(Country::find()->all(), 'id', 'name');

                          echo $form->field($model, 'usrCountry')
                          ->dropDownList(
                            $country,

                            ['prompt'=>'select country'],  
                            ['onchange'=>'this.form.submit()']  // options
                        )->label('Country <span class="required">*</span>');
                      ?>
                      
                      <?php 
                      $country = ArrayHelper::map(Country::find()->all(), 'id', 'name');

                          echo $form->field($model, 'usrCountry')
                          ->dropDownList(
                            $country,

                            ['prompt'=>'select country'],  
                            ['onchange'=>'this.form.submit()']  // options
                        )->label('State');
                      ?>                      
                    </div>  
                    </div> 
		<div class="fullwidth">
                 
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="form-group ">
                      <label>Date of Birth</label>
                      <div class="val">
                        <div class="controls">
                         <div  class="input-group innerDate" ng-controller="DatepickerDemoCtrl">
							<input type="text" class="form-control" uib-datepicker-popup="{{format}}" ng-model="dt" is-open="popup1.opened" datepicker-options="dateOptions" ng-required="true" close-text="Close" alt-input-formats="altInputFormats" />
							<span class="input-group-addon" ng-click="open1()"><i class="fa fa-calendar" aria-hidden="true"></i></span>
						</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
               <?php
                     echo $form->field($model, 'email', ['inputOptions' => [
                     ]])->textInput()->label('Phone Number');
               ?>
		</div>
                <div class="fullwidth">
                  <div class="col-xs-12">
                    <button class="btn btn-primary" type="submit">Save</button>
                  </div>
                </div>
                    
               
              <?php ActiveForm::end(); ?> 
         
          </div>
        </div>
      </div>  
    </div>
  </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  
    $('#updateuser-usrcountry').on('change',function(){
    $("#state, #city").find("option:gt(0)").remove();
        var countryID = $(this).val();
        $("#state").find("option:first").text("Loading...");
            $.ajax({
                type:'POST',
                url:'states',
                data:'id='+countryID,
                success:function(json){
                   $("#state").find("option:first").text("Select State  ");
                    for (var i = 0; i < json.length; i++) {
                     $("<option/>").attr("value", json[i].id).text(json[i].name).appendTo($("#state"));
                     }
                   
                }
            }); 
        
    });
    
    
    $("#state").on('change',function(){
        var stateID = $(this).val();
        $("#city").find("option:gt(0)").remove();
        $("#city").find("option:first").text("Loading...");
            $.ajax({
                type:'POST',
                url:'cities',
                data:'id='+stateID,
            success:function (json) {
            $("#city").find("option:first").text("Select city");
            for (var i = 0; i < json.length; i++) {
            $("<option/>").attr("value", json[i].id).text(json[i].name).appendTo($("#city"));
            }
        
        }
    });
});


 });
</script>

