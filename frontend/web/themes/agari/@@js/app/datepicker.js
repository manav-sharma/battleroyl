angular.module('ui.bootstrap.demo').controller('DatepickerDemoCtrl', function ($scope) {
  var today = new Date();
  $scope.today = function() {
    $scope.dt = new Date();
  };
  $scope.today();

  $scope.clear = function() {
    $scope.dt = null;
  };

  $scope.inlineOptions = {
    customClass: getDayClass,
    minDate: new Date(),
    showWeeks: true
  };

  $scope.dateOptions = {
    //dateDisabled: disabled,
    formatYear: 'yy',
    maxDate: new Date(today.getFullYear(),today.getMonth() , today.getDate()),
    minDate: new Date(),
    startingDay: 1
  };

  // Disable weekend selection
  function disabled(data) {
    var date = data.date,
      mode = data.mode;
    return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
  }

  $scope.toggleMin = function() {
    $scope.inlineOptions.minDate = $scope.inlineOptions.minDate ? null : new Date();
    $scope.dateOptions.minDate = $scope.inlineOptions.minDate;
  };

  $scope.toggleMin();

  $scope.open1 = function() {
    $scope.popup1.opened = true;
  };

  $scope.open2 = function() {
    $scope.popup2.opened = true;
  };

  $scope.setDate = function(year, month, day) {
    $scope.dt = new Date(year, month, day);
  };

  $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
  $scope.format = $scope.formats[0];
  $scope.format_p = "YYYY-MM-DD";
  $scope.altInputFormats = ['M!/d!/yyyy'];

  $scope.popup1 = {
    opened: false
  };

  $scope.popup2 = {
    opened: false
  };

  var tomorrow = new Date();
  tomorrow.setDate(tomorrow.getDate() + 1);
  var afterTomorrow = new Date(tomorrow);
  afterTomorrow.setDate(tomorrow.getDate() + 1);
  $scope.events = [
    {
      date: tomorrow,
      status: 'full'
    },
    {
      date: afterTomorrow,
      status: 'partially'
    }
  ];

	$scope.formatDate = function(dt){
		
		return dt.getFullYear()+'-'+parseInt(dt.getMonth())+1+'-'+dt.getDate();
	};


	$scope.selectDate = function(dt) {
		console.log(dt);
		console.log($scope.formatDate(dt));
	
		searchPost.date = $('#filterByDate').val();
		filterSearchResult();
	};
	
	

  function getDayClass(data) {
    var date = data.date,
      mode = data.mode;
    if (mode === 'day') {
      var dayToCheck = new Date(date).setHours(0,0,0,0);

      for (var i = 0; i < $scope.events.length; i++) {
        var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);

        if (dayToCheck === currentDay) {
          return $scope.events[i].status;
        }
      }
    }

    return '';
  }
});

angular.module('ui.bootstrap.demo').controller('DatepickerDemoCtrlSearch', function ($scope) {
  var today = new Date();
  $scope.today = function() {
    $scope.dt = new Date();
    //$scope.dtStart = new Date();
    //$scope.dtTo = new Date();
    $scope.dtStart = new Date(today.getFullYear(),today.getMonth() , today.getDate()+4);
    $scope.dtTo = new Date(today.getFullYear(),today.getMonth() , today.getDate()+4);  
  };
  $scope.today();

  $scope.clear = function() {
    $scope.dt = null;
    $scope.dtStart = null;
    $scope.dtTo = null;
  };

  $scope.inlineOptions = {
    customClass: getDayClass,
    minDate: new Date(),
    showWeeks: true
  };

  $scope.dateOptions = {
    //dateDisabled: disabled,
    formatYear: 'yy',
    maxDate: new Date(today.getFullYear()+1,today.getMonth() , today.getDate()),
    minDate: new Date(today.getFullYear(),today.getMonth() , today.getDate()),
    //minDate: today,
    startingDay: 1
  };

  // Disable weekend selection
  function disabled(data) {
    var date = data.date,
      mode = data.mode;
    return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
  }

  $scope.toggleMin = function() {
    $scope.inlineOptions.minDate = $scope.inlineOptions.minDate ? null : new Date();
    $scope.dateOptions.minDate = $scope.inlineOptions.minDate;
  };
  $scope.tp = new Date();
  //$scope.toggleMin();
	
  $scope.open1 = function() {
    $scope.popup1.opened = true;
  };

  $scope.open2 = function() {
    $scope.popup2.opened = true;
  };

  $scope.setDate = function(year, month, day) {
    $scope.dt = new Date(year, month, day);
  };

  $scope.formats = ['dd-MMM-yyyy','dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
  $scope.format = $scope.formats[0];
  $scope.altInputFormats = ['M!/d!/yyyy'];

  $scope.popup1 = {
    opened: false
  };

  $scope.popup2 = {
    opened: false
  };

  var tomorrow = new Date();
  tomorrow.setDate(tomorrow.getDate() + 1);
  var afterTomorrow = new Date(tomorrow);
  afterTomorrow.setDate(tomorrow.getDate() + 1);
  $scope.events = [
    {
      date: tomorrow,
      status: 'full'
    },
    {
      date: afterTomorrow,
      status: 'partially'
    }
  ];

	$scope.formatDate = function(dt){
		
		return dt.getFullYear()+'-'+parseInt(dt.getMonth())+1+'-'+dt.getDate();
	};

	$scope.changeDate = function(dt) {
		
		$scope.dtStart = null;
		$scope.dtStart = dt;
		
		//$scope.dtTo = new Date();
	};
  
	$scope.onSelectDate = function(dt) {
		 setTimeout(function() {
			$scope.changeDate(dt);
			$scope.$apply();
		}, 0);
		
		updateToMinDate(dt);
	};
	$scope.onSelectToDate = function(dt) {
		if($scope.dtTo > $scope.dtStart){
			//alert('Hide');
			hideNoOfHours();	
		}else {
			//alert('Show');
			showNoOfHours();
		}
	};
	
	$scope.selectDate = function(dt) {
		console.log(dt);
		console.log($scope.formatDate(dt));
	
		searchPost.date = $('#filterByDate').val();
		filterSearchResult();
	};
	

  function getDayClass(data) {
    var date = data.date,
      mode = data.mode;
    if (mode === 'day') {
      var dayToCheck = new Date(date).setHours(0,0,0,0);

      for (var i = 0; i < $scope.events.length; i++) {
        var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);

        if (dayToCheck === currentDay) {
          return $scope.events[i].status;
        }
      }
    }

    return '';
  }
});

/*#######= Notification count =###########*/ 
angular.module('ui.bootstrap.demo').controller('notificationCrtl', function ($scope,$http,$interval) {
	$scope.count = '';
		var dataObj = {
				name : 'abc',
		};
		$scope.callAtInterval = function() {
			$http.post(siteUrl+'/'+language+'/ajax/get-messages-count',dataObj).
				success(function(data, status, headers, config) { 
					if(data > 0) {
						$( ".notificationnumber" ).replaceWith( '<div class="notificationnumber">'+data+'</div>' );
						$( ".numbermsg" ).replaceWith( '<span class="numbermsg">'+data+'</span>' );
						//$scope.count = data;
					}
				});
		}

    $interval( function(){ $scope.callAtInterval(); }, 8000);
});
