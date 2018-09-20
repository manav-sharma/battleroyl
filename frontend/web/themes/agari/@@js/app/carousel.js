angular.module('ui.bootstrap.demo').controller('CarouselDemoCtrl', function ($scope,$http) {
  $scope.myInterval = 4000;
  $scope.noWrapSlides = false;
  $scope.active = 0;
  var slides = $scope.slides = [];
  var currIndex = 0;
  //var bannerImagesBasepath =  'http://localhost/projects/myguyde/development/common/uploads/banner/';
  var bannerImagesBasepath =  siteUrl+'/common/uploads/banner/';
  var bannerImages = [];

    $http.get(siteUrl+'/cms/getimages')
      .success(function(response) {

    //  result =  JSON.parse(response);
         angular.forEach(response, function(val,index){
       
            bannerImages.push(bannerImagesBasepath+val.bannerImage);
            $scope.addSlide();

      }); 

    });

$scope.addSlide = function() {
    var newWidth = 600 + slides.length + 1;
     
    slides.push({
      
      image: bannerImages
     /* [ 
      'http://localhost/projects/myguyde/development/frontend/web/themes/myguyde/images/banner1.jpg', 
      'http://localhost/projects/myguyde/development/frontend/web/themes/myguyde/images/banner2.jpg', 
      'http://localhost/projects/myguyde/development/frontend/web/themes/myguyde/images/banner3.jpg', 
      'http://localhost/projects/myguyde/development/frontend/web/themes/myguyde/images/banner4.jpg',
      'http://localhost/projects/myguyde/development/frontend/web/themes/myguyde/images/banner5.jpg']*/
      [slides.length % 5],
     	id: currIndex++,
    });
  };

  $scope.randomize = function() {
    var indexes = generateIndexesArray();
    assignNewIndexesToSlides(indexes);
  };

 /* for (var i = 0; i < 5; i++) {
    $scope.addSlide();
  }*/

  // Randomize logic below

  function assignNewIndexesToSlides(indexes) {
    for (var i = 0, l = slides.length; i < l; i++) {
      slides[i].id = indexes.pop();
    }
  }

  function generateIndexesArray() {
    var indexes = [];
    for (var i = 0; i < currIndex; ++i) {
      indexes[i] = i;
    }
    return shuffle(indexes);
  }

  // http://stackoverflow.com/questions/962802#962890
  function shuffle(array) {
    var tmp, current, top = array.length;

    if (top) {
      while (--top) {
        current = Math.floor(Math.random() * (top + 1));
        tmp = array[current];
        array[current] = array[top];
        array[top] = tmp;
      }
    }

    return array;
  }
});
