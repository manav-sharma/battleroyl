<?php $page = $_SERVER['REQUEST_URI']; 
if(strpos($page,'loggedin') === false) {
?>
 <div class="mainheading <?php if((strpos($page,'searchresult.php') !== false)||(strpos($page,'guideProfile.php') !== false)) { echo ''; }  ?>">
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0">
          <form>
            <div class="input-group view">
              <input type="text" class="form-control" id="exampleInputAmount" placeholder="Destination">
              <span class="input-group-addon"><i class="fa fa-map-marker" aria-hidden="true"></i> </span> </div>
            <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy" >
              <input class="form-control" type="text" placeholder="Date" readonly  />
              <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i> </span> </div>
            <select class="travellers">
              <option>2 Travelers</option>
              <option>3 Travelers</option>
			  <option>4 Travelers</option>
			  <option>5 Travelers</option>
			  <option>6 Travelers</option>
			  <option>7+ Travelers</option>
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
            <div class="headinginner">Search results for “Paris” </div>
          </div>
        </div>
      </div>
    </div>
    <div class="bordertopwhite">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12 ">
            <div class="headinginner">
			<?php
				echo 'Become an Insider';
			 ?>
			</div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } else{ ?>
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
