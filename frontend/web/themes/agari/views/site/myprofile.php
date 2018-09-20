<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;  
use yii\helpers\ArrayHelper;

$this->title = 'My Profile';
$this->params['breadcrumbs'][] = $this->title;

$attributes = Yii::$app->user->identity->getattributes();
$profile_picture = $attributes['usrProfileImage'];
$profile_pic = (isset($profile_picture) ? PROFILE_IMAGE_PATH.$profile_picture : NO_IMAGE);
?>
<section>


<div class="mainheading">
   <div class="container">
      <div class="row">
         <div class="col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0">
            <form method="post" action="searchresult.php" class="ng-pristine ng-valid ng-valid-required ng-valid-date">
            <div class="input-group view">
               <input type="text" placeholder="Destination" id="exampleInputAmount" class="form-control placeholder">
               <span class="input-group-addon"><i aria-hidden="true" class="fa fa-map-marker"></i> </span> 
            </div>
            <div ng-controller="DatepickerDemoCtrl" class="input-group date ng-scope">
               <input type="text" alt-input-formats="altInputFormats" close-text="Close" ng-required="true" datepicker-options="dateOptions" is-open="popup1.opened" ng-model="dt" uib-datepicker-popup="dd-MMMM-yyyy" class="form-control ng-pristine ng-untouched ng-valid ng-isolate-scope ng-not-empty ng-valid-required ng-valid-date" required="required">
               <div uib-datepicker-popup-wrap="" ng-model="date" ng-change="dateSelection(date)" template-url="uib/template/datepickerPopup/popup.html" class="ng-not-empty ng-valid">
            <!-- ngIf: isOpen -->
               </div>
               <span ng-click="open1()" class="input-group-addon"><i aria-hidden="true" class="fa fa-calendar"></i> 
               </span>
            </div>
            <select class="travellers">
               <option value="2 Travelers">2 Travelers</option>
               <option value="3 Travelers">3 Travelers</option>
            </select>
            <button class="btn btn-primary" type="submit">Search</button>
            </form>
         </div>
      </div>
   </div>
   <div class="bordertopwhite">
      <div class="container">
         <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 ">
               <div class="headinginner">My profile </div>
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
         <div class="detailright">
            <div class="profiledetail">
                  <div class="media">
                     <div class="media-left pull-left">
                        <div class="profilewrapper"> <img src="<?php echo $profile_pic; ?>" alt="#"> 
                        </div>
                     </div>
                     <div class="media-body">
                        <h2><?php echo $attributes['usrFirstname']; ?> <?php echo $attributes['usrLastname']; ?></h2>
                        <h6><i aria-hidden="true" class="fa fa-map-marker"></i><?php echo $attributes['usrCountry']; ?></h6>
                        <div class="rating3">
                           <ul>
                           <li><a href="javascript:void(0)"><i aria-hidden="true" class="fa fa-star"></i></a></li>
                           <li><a href="javascript:void(0)"><i aria-hidden="true" class="fa fa-star"></i></a></li>
                           <li><a href="javascript:void(0)"><i aria-hidden="true" class="fa fa-star"></i></a></li>
                           <li><a href="javascript:void(0)"><i aria-hidden="true" class="fa fa-star"></i></a></li>
                           <li class="unrating"> <a href="javascript:void(0)"><i aria-hidden="true" class="fa fa-star"></i></a></li>
                           </ul>
                           <h6><a href="javascript:void(0)">26 reviews</a></h6>
                        </div>
                        <a class="editprofile" href="<?php echo Yii::$app->homeUrl; ?>site/settings"><i class="fa fa-cog" aria-hidden="true"></i>Edit profile</a> </div>
                     </div>
               </div>
            <div class="detailwhite">
                     <h6>Personal information</h6>
                        <div class="table-responsive">
                           <table class="table">
							   <tbody>
								   <tr>
									   <td>
										   <span>First name</span><br/>
										   <?php echo (isset($attributes['usrFirstname']) ? ucfirst($attributes['usrFirstname']) : ''); ?>
									   </td>
									   <td>
										   <span>Last name</span><br/>
										   <?php echo (isset($attributes['usrLastname']) ? ucfirst($attributes['usrLastname']) : '');?>
									   </td>
									   <td>
										   <span>email</span><br/>
											<?php echo (isset($attributes['email']) ? $attributes['email'] : '');?>
									   </td>
								   </tr>
								   <tr>
									   <td>
										   <span>Birth date</span><br/>
										   <?php echo (isset($attributes['dob']) && $attributes['dob'] != '0000-00-00' && $attributes['dob'] != '' ? $attributes['dob'] : 'N/A');?>
									   </td>
									   <td>
										   <span>Gender </span><br/>
										   <?php echo (isset($attributes['gender']) ? ucfirst($attributes['gender']) : '');?>
									   </td>
									   <td>
										   <span>Country</span><br/>
										   <?php echo (isset($attributes['usrCountry']) ? ucfirst($attributes['usrCountry']) : '');?>
									   </td>
								   </tr>
								   <tr>
									   <td>
											<span>State</span><br/>
											<?php echo (isset($attributes['usrState']) ? ucfirst($attributes['usrState']) : '');?>
									   </td>
									   <td>
										   <span>City </span><br/>
										   <?php echo (isset($attributes['usrCity']) ? ucfirst($attributes['usrCity']) : '');?>
									   </td>
									   <td></td>
								   </tr>
							   </tbody>
                           </table>
                        </div>
                    </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
</section>
