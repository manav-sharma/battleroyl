<?php $page = $_SERVER['REQUEST_URI']; 
if(strpos($page,'loggedin') === false){
	?>
 <div class="mainheading <?php if((strpos($page,'searchresult.php') !== false)||(strpos($page,'guideProfile.php') !== false)) { echo 'nogaparea'; }  ?>">
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0">
          <form action="searchresult.php" method="post">
            <div class="input-group view">
              <input type="text" class="form-control" id="exampleInputAmount" placeholder="Destination">
              <span class="input-group-addon"><i class="fa fa-map-marker" aria-hidden="true"></i> </span> </div>
            <div  class="input-group date" ng-controller="DatepickerDemoCtrl">
                	 <input type="text" class="form-control" uib-datepicker-popup="{{format}}" ng-model="dt" is-open="popup1.opened" datepicker-options="dateOptions" ng-required="true" close-text="Close" alt-input-formats="altInputFormats" />
                <span class="input-group-addon" ng-click="open1()"><i class="fa fa-calendar" aria-hidden="true"></i> </span>
              </div>
            <select class="travellers">
              <option>2 Travelers</option>
              <option>3 Travelers</option>
            </select>
            <button type="submit" class="btn btn-primary">Search</button>
          </form>
        </div>
      </div> 
    </div>
    <div class="bordertopwhite">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12 ">
            <div class="headinginner">
			<?php if(strpos($page,'register.php')) {
				echo 'Register';
			}
			if(strpos($page,'login.php')){
				echo 'Login';
			} 
			if(strpos($page,'about.php')){
				echo 'About Us';
			}
			if(strpos($page,'sitemap.php') !== false){
				echo 'Sitemap';
			} 
			if(strpos($page,'howitworks.php') !== false){
				echo 'How it works';
			} 
			if(strpos($page,'partner.php') !== false){
				echo 'Partner with Us';
			} 
			if(strpos($page,'trust.php') !== false){
				echo 'Trust & Safety';
			} 
			if(strpos($page,'guide-aggreement.php') !== false){
				echo 'Guide Agreement';
			} 
			if(strpos($page,'career.php') !== false){
				echo 'Career';
			} 
			if(strpos($page,'findguide.php') !== false){
				echo 'Find Guide';
			} 
			if(strpos($page,'contactus.php') !== false){
				echo 'Contact Us';
			} 
			if(strpos($page,'guidePolicy.php') !== false){
				echo 'Guide Policy';
			} 
			if(strpos($page,'travelPolicy.php') !== false){
				echo 'Travelers Policy';
			} 
			if(strpos($page,'terms.php') !== false){
				echo 'Terms & Conditions';
			} 
			if(strpos($page,'faq.php') !== false){
				echo 'FAQ';
			} 
			if(strpos($page,'becomeGuide.php') !== false){
				echo 'Become An Insider';
			} 
			 ?>
			</div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } else{  ?>
          <form action="searchresult.php" method="post">
            <div class="input-group view">
              <input type="text" class="form-control" id="exampleInputAmount" placeholder="Destination">
              <span class="input-group-addon"><i class="fa fa-map-marker" aria-hidden="true"></i> </span> </div>
            <div  class="input-group date" ng-controller="DatepickerDemoCtrl">
                	 <input type="text" class="form-control" uib-datepicker-popup="{{format}}" ng-model="dt" is-open="popup1.opened" datepicker-options="dateOptions" ng-required="true" close-text="Close" alt-input-formats="altInputFormats" />
                <span class="input-group-addon" ng-click="open1()"><i class="fa fa-calendar" aria-hidden="true"></i> </span>
              </div>
            <select class="travellers">
              <option>2 Travelers</option>
              <option>3 Travelers</option>
            </select>
            <button type="submit" class="btn btn-primary">Search</button>
          </form>
  
<?php } ?>
