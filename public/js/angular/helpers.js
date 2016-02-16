/*global $, jQuery, alert, console, alert, angular*/
(function() {
  "use strict";
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
      } else {
        return 0;
      }
    };
  });

  angular.module('app').directive('eatClick', function() {
    return function(scope, element, attrs) {
      $(element).click(function(event) {
        event.preventDefault();
      });
    };
  });

  angular.module('app').filter('to_trusted', ['$sce', function($sce){
    return function(text) {
      return $sce.trustAsHtml(text);
    };
  }]);

  angular.module('app').directive('changedDirective', function() {
    return {
      restrict:'A',
      scope:{
        ev:'=ev'
      },
      link: function ($scope, element, attrs) {
        element.on('change',function(e){
          $scope.$apply(function(){
            $scope.$emit($scope.ev,{value: element.val()});
          });
        });
      }
    };
  });

  angular.module('app').directive('autocompleteModal', ['$timeout', '$http', function($timeout, $http) {
    return {
      restrict:'A',
      scope:{
        callback:'=callback'
      },
      templateUrl: '/vendor/ecommerce/js/angular/autocompleteDirective.html',
      link: function ($scope, element, attrs) {
        // modal_id
        // modal_title
        // modal_hint
        // results
        // choosed
        // search_input

        $scope.modal_id = attrs.id;
        $scope.modal_title = attrs.title;
        $scope.modal_hint = attrs.hint;

        var ajaxRequestUrl = attrs.url;

        var tm = null;
        $scope.$watch('search_input', function(newValue, oldValue) {
          if (tm !== null) {
            $timeout.cancel(tm);
          }
          tm = $timeout(function() {
            if (ajaxRequestUrl) {
              var params = {
                query: newValue
              };
              $scope.results = [];
              $http({method: 'GET', url: ajaxRequestUrl, params: params})
                .success(function (data, status, headers, config) {
                  $scope.results = data.items;
                });
            }
          }, 300);
        });

        $scope.actions = {
          selectItem: function(item) {
            if ($scope.choosed == item) {
              $scope.choosed = null;
            } else {
              $scope.choosed = item;
            }
          },
          finish: function() {
            if (typeof $scope.callback == 'function') {
              $scope.callback($scope.choosed);
              element.find('.modal').modal('hide');
            }
          }
        };
      }
    };
  }]);
}).call(this);
