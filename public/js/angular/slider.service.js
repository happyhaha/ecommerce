/*global $:false, angular:false */
(function(){
  'use strict';

  angular.module('app').service('SliderService', SliderService);
  SliderService.$inject = ['$http','$q','$timeout'];
  function SliderService ($http, $q, $timeout) {
    var vm = this;

    vm.getInfo = function(id) {
      var params = {id: id};
      return $http({
        method: 'GET',
        url: '/admin/ecommerce/sliders/get-info',
        params: params
      });
    }

    vm.getRows = function(model_type) {
      var params = {model_type: model_type};
      return $http({
        method: 'GET',
        url: '/admin/ecommerce/sliders/get-rows',
        params: params
      });
    }
  }
})();
