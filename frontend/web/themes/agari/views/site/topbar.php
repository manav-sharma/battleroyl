<div class="container">
      <div class="row">
        <div class="col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0">
          <form method="post" action="searchresult.php" class="ng-pristine ng-valid ng-valid-required ng-valid-date">
            <div class="input-group view">
              <input type="text" placeholder="Destination" id="exampleInputAmount" class="form-control placeholder">
              <span class="input-group-addon"><i aria-hidden="true" class="fa fa-map-marker"></i> </span> </div>
            <div ng-controller="DatepickerDemoCtrl" class="input-group date ng-scope">
                	 <input type="text" alt-input-formats="altInputFormats" close-text="Close" ng-required="true" datepicker-options="dateOptions" is-open="popup1.opened" ng-model="dt" uib-datepicker-popup="dd-MMMM-yyyy" class="form-control ng-pristine ng-untouched ng-valid ng-isolate-scope ng-not-empty ng-valid-required ng-valid-date" required="required"><div uib-datepicker-popup-wrap="" ng-model="date" ng-change="dateSelection(date)" template-url="uib/template/datepickerPopup/popup.html" class="ng-not-empty ng-valid">
  <!-- ngIf: isOpen -->
</div>
                <span ng-click="open1()" class="input-group-addon"><i aria-hidden="true" class="fa fa-calendar"></i> </span>
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