(function() {
  function configProvider($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
  }
  //configProvider.$inject = ['$interpolateProvider'];
  //angular.module('app').config(configProvider);

  angular.module('app').filter('nicePrice',function(){
    return function(input){
      if (input) {
        input = input.toString();
        return input.replace(/\B(?=(\d{3})+(?!\d))/g,' ');
      }else{
        return 0;
      }
    };
  });

  angular.module('app').directive('eatClick', function() {
    return function(scope, element, attrs) {
      $(element).click(function(event) {
        event.preventDefault();
      });
    }
  });

  angular.module('app').filter('to_trusted', ['$sce', function($sce){
    return function(text) {
      return $sce.trustAsHtml(text);
    };
  }]);

  angular.module('app').directive('changedDirective', function() {
    return {
      restrict:'A'
      ,scope:{
        ev:'=ev'
      }
      , link: function ($scope, element, attrs) {
        element.on('change',function(e){
          $scope.$apply(function(){
            $scope.$emit($scope.ev,{value: element.val()});
          });
        });
      }
    }
  });
}).call(this);
