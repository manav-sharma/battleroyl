<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\db\Query;

$query = new Query;
$query->select('contentImage')->from('contentimages')->where("status = '2'");   
$contentImage = $query->createCommand()->queryOne();
if(isset($contentImage['contentImage']) && !empty($contentImage['contentImage'])) {
	$aboutBImage = CONTENT_IMAGE_PATH.$contentImage['contentImage'];
} else {
	$aboutBImage =  Yii::getAlias('@webThemeUrl/images').'/formgirl.jpg';
}

$this->title = "Contact Us";
$this->params['breadcrumbs'][] = $this->title;
?>


<section>
    <?php echo $this->render('//common/searchbox'); ?>
    <div class="form1">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <div class="callnow"> <img src="<?= $aboutBImage; ?>" alt="cal"> </div>
                </div>
                <div class="col-xs12 col-sm-8 col-md-8">
                    <div class="callnowtext">
                       <h1>Address</h1>
                       <!-- <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="detail"> 
                                    <span>
                                        #482, Lorem Ipsum,<br/>
                                        Dolrem 17th Cross Road,<br/>
                                        WA, Ehmabhari
                                    </span> 
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="detail"> <span>Tel: 9876543210<span> </div>
                            </div>
                        </div> -->
                          <div class="row">
                            <div class="col-xs12 col-sm-8 col-md-8">
                                <div class="detail"><span>For any information, please contact us at <a href="mailto:info@myguyde.com">info@myguyde.com</a></span> </div>
                            </div>
                        </div>                         
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-md-12 col-sm-12">
                    <div class="formcustomer"> 

                      <!-- Tab panes -->

                        <div class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-12">
                                    <h2>Have a question or comment?</h2>
                                    
                                    <?php if (Yii::$app->session->getFlash('message')): ?>                                    
                                            <div class="alert alert-grey alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <i class="glyphicon glyphicon-ok"></i><?php echo Yii::$app->session->getFlash('message'); ?>
                                            </div>															
                                    <?php endif; ?>
                                    
                                </div> 
                                
                                
                                
                                <!-- form starts-->     
                                <?php
                                $form = ActiveForm::begin(
                                    [
                                        'id' => 'contactUsForm',
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
                                    <div class="fullwidth">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <?php
                                            echo $form->field($model, 'fname', ['inputOptions' => [
                                                'class' => "form-control textfeild",
                                            ]])->textInput(['maxlength' => 60, 'autofocus' => true])->label('First Name <span>*</span>');
                                            ?>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <?php
                                            echo $form->field($model, 'lname', ['inputOptions' => [
                                                'class' => "form-control textfeild",
                                            ]])->textInput(['maxlength' => 60, 'autofocus' => true])->label('Last Name <span>*</span>');
                                            ?>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <?php
                                            echo $form->field($model, 'email', ['inputOptions' => [
                                                'class' => "form-control",
                                            ]])->textInput(['maxlength' => 80, 'autofocus' => true])->label('Email Address <span>*</span>');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="fullwidth">
                                        
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <?php
                                            $country = ArrayHelper::map(common\models\Country::find()->all(), 'name', 'name');
                                            echo $form->field($model, 'country')->dropDownList($country, ['prompt' => 'Select Country'])->label('Country *');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="fullwidth">
                                        <div class="col-xs-12">
                                            <?php
                                            echo $form->field($model, 'message', ['inputOptions' => [
                                                'class' => "form-control textarea textfeild",
                                            ]])->textarea(['rows' => 4, 'maxlength' => 255, 'autofocus' => true])
                                                ->label('Message <span>*</span>');
                                            ?>
                                        </div>
                                    </div>
                                    
                                    <div class="fullwidth">
                                        <div class="col-xs-12">
                                            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary orangebtn', 'name' => 'contactus-submit', 'id' => 'contactus-submit']) ?>
                                        </div>
                                    </div>
                                <?php ActiveForm::end(); ?>
                                <!--form ends-->
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</section>
