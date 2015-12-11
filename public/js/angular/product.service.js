angular.module('app').service('ProductService', ProductService);
ProductService.$inject = ['$http','$q','$timeout'];
function ProductService ($http, $q, $timeout) {
  var vm = this;

  vm.getInfo = function(id) {
    var params = {id: id};
    return $http({
      method: 'GET',
      url: '/admin/ecommerce/products/get-info',
      params: params
    });
  }
}
