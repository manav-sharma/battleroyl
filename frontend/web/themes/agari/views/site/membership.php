<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Country;

$this->title = Yii::t('yii','Membership Plan');
$this->params['breadcrumbs'][] = $this->title;
echo'<pre>'; print_r($data); exit();
?>  <section class="headinginner">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <div class="centertext">
            <h1>Membership Plan</h1>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <section>
      <div class="container">
        
       <div class="row"> <div class="col-xs-12">
        <p>Duis et mauris ut magna faucibus tempus vel et tellus. Suspendisse turpis nunc, tristique ut hendrerit eu, sollicitudin et tortor. Maecenas vestibulum nisi ac massa volutpat aliquam at at orci. Vestibulum fermentum condimentum eros, id laoreet mi condimentum id.</p>
      </div>
      
      
      <div class="col-xs-12">
        <div class="threeBox">
          <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 full">
              <div class="col">
                <div class="tophead">Basic</div>
                <div class="price01">$10.99/Month</div>
                <div class="boxInfo">
                  <div class="phead">Five Photos Only</div>
                  <div class="phead">No Videos</div>
                  <div class="phead">No 360 degree views</div>
                  <div class="phead">Map locations (accurate to 1000 m)</div>
                  <div class="phead">Unlimited Advanced Searches</div>
                   <div class="phead">Unlimited Views of Properties</div>
                  
                  <div class="centerButton"><a class="desbttn" title="" href="loggedin-basic/myprofile.php">Select plan</a></div> </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 full">
              <div class="col">
                <div class="tophead">Premium</div>
                <div class="price01">$50.99/Month</div>
                <div class="boxInfo">
				<div class="phead">Access to All user pages</div>
				<div class="phead">Access to All Premium Sections</div>
				<div class="phead">Access Unlimited Number of Photos</div>
				<div class="phead">Access Unlimited Number of Videos</div>  
				<div class="phead">Access All 360 degree views</div>
				<div class="phead">Access to unlimited uploads</div>
                 
                  <div class="centerButton"><a class="desbttn" title="" href="loggedin-basic/myprofile.php">Select plan</a></div> </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
              <div class="col newgreen">
                <div class="tophead">Platinum</div>
                <div class="price01">$100.99/Month</div>
                <div class="boxInfo">
                <div class="phead">Access to All user pages</div>
				<div class="phead">Access to All Premium Sections</div>
				<div class="phead">Access Unlimited Number of Photos</div>
				<div class="phead">Access Unlimited Number of Videos</div>  
				<div class="phead">Access All 360 degree views</div>
                <div class="phead">Access to agencies & special organizations </div>
                  <div class="centerButton"><a class="desbttn" title="" href="loggedin-basic/myprofile.php">Select plan</a></div> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
      </div>
    </section>
    <section>
    </section>
  </section>
