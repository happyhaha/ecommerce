angular.module('app').service('OrderService', OrderService);
OrderService.$inject = ['$http','$q','$timeout'];
function OrderService ($http, $q, $timeout) {
  var vm = this;

  vm.getInfo = function(id) {
    var params = {id: id};
    return $http({
      method: 'GET',
      url: '/admin/ecommerce/orders/get-info',
      params: params
    });
  }
}
