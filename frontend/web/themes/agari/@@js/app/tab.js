angular.module('ui.bootstrap.demo').controller('TabsDemoCtrl', function ($scope, $window) {
  $scope.tabs = [
    { title:'CONTRACTORS', content:'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut pellentesque, est lacinia accumsan bibendum, enim massa feugiat augue, eget euismod enim tellus sed purus. Aenean aliquam quis erat et tincidunt. Nulla blandit est auctor pellentesque condimentum. Cras non lacus volutpat, venenatis est at, dictum ipsum. Suspendisse sit amet auctor ante. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed posuere ac sem eu porttitor. Sed vitae dignissim orci, sed consequat augue. Quisque non rutrum ex. Vivamus tincidunt gravida suscipit. Aliquam tincidunt commodo augue, sed tempus sapien imperdiet vel. ' },
    { title:'SUBCONTRACTORS', content:'Vivamus volutpat urna blandit sem pulvinar, sed lobortis nulla porta. Praesent nisl sapien, gravida at odio sit amet, rhoncus facilisis arcu. Donec nec fermentum arcu. Fusce libero ex, consectetur vel ipsum eget, fringilla aliquet nisl. Morbi eu nulla lacus. Proin augue ipsum, dapibus sed rutrum in, dignissim eget turpis. Ut maximus nunc non mauris tempus, vitae congue risus ornare. Maecenas id imperdiet turpis. Nam hendrerit libero at lacinia venenatis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed suscipit, nisl nec ullamcorper aliquam, dui odio rhoncus enim, non blandit nibh dolor nec lectus. Nam porttitor pretium finibus. Maecenas laoreet mattis lectus. Quisque augue erat, vehicula sit amet imperdiet scelerisque, vestibulum eget lorem. Nam eu urna diam. Lorem ipsum dolor sit amet, consectetur adipiscing elit. ',},
	{ title:'SIGN UP', content:'Donec ut nunc id est scelerisque feugiat vitae eu est. Proin in purus eget erat ultrices condimentum nec id odio. Vestibulum odio nibh, malesuada ut suscipit eu, pulvinar et risus. Aliquam erat volutpat. Ut vitae tristique nibh, aliquet scelerisque metus. Etiam aliquet dui eu gravida efficitur. In ac tempor arcu, id faucibus lacus. Suspendisse luctus vehicula erat, interdum venenatis quam ultricies in. Phasellus posuere, turpis in condimentum elementum, orci sapien aliquam libero, elementum fermentum est justo eget nisi. Nullam vel tortor eget augue placerat feugiat. Donec gravida lacinia aliquam. Vestibulum egestas ullamcorper feugiat. Praesent libero diam, sollicitudin at elementum ac, euismod vel enim. Suspendisse eleifend urna a nibh placerat, sit amet lacinia turpis dignissim. ', }
  ];

  $scope.alertMe = function() {
    setTimeout(function() {
      $window.alert('You\'ve selected the alert tab!');
    });
  };

  $scope.model = {
    name: 'Tabs'
  };
});