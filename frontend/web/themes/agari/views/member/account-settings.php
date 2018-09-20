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
                                    ]])->textInput(['maxlength' => 80, 'autofocus' => true, 'readonly' => true]);
                                ?>
                            </div>
                        </div>

                        <div class="fullwidth">
                            
                            <div class="col-lg-4 col-md-4 col-sm-4">

                                <div class="form-group ">
                                    <div class="val">
                                        <div class="controls">
                                            <label>Payment Method</label>
                                            <div class="radioButton">
                                                <input type="radio" name="UpdateMember[gender]" value="<?= PAYPAL_METHOD ?>" <?= (isset($model['gender']) && $model['gender'] == PAYPAL_METHOD ? 'checked' : '') ?> <?= (isset($model['gender']) && $model['gender'] == '' ? 'checked' : '') ?>/>
                                                <span><?php echo Yii::t('yii', 'Paypal'); ?></span>
                                                <input type="radio" name="UpdateMember[gender]" value="<?= BANK_TRANSFER ?>" <?= (isset($model['gender']) && $model['gender'] == BANK_TRANSFER ? 'checked' : '') ?> />
                                                <span><?php echo Yii::t('yii', 'Bank Transfer'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="fullwidth">					
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
                <p><?php echo Yii::t('yii', 'For each booking, '); ?> <strong><?php echo (isset($commission['admin_fee']) && $commission['admin_fee'] > 0 ? floatval($commission['admin_fee']) : 1); ?>%</strong>  <?php echo Yii::t('yii', ' of the booking amount will go to the admin as commission fees'); ?></p>
                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><i class="close">Ok</i></button>
            </div>
        </div>
    </div>
</div>
