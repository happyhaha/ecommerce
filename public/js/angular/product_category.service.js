angular.module('app').service('ProductCategoryService', ProductCategoryService);
ProductCategoryService.$inject = ['$http','$q','$timeout'];
function ProductCategoryService ($http, $q, $timeout) {
    var vm = this;

    vm.getFilters = function(id) {
        var params = {id:id};
        return $http({
            method: 'GET',
            url: '/admin/ecommerce/product-categories/get-filters',
            params: params
        });
    }

    vm.getParentFilters = function(id) {
        var params = {id:id};
        return $http({
            method: 'GET',
            url: '/admin/ecommerce/product-categories/get-parent-filters',
            params: params
        });
    }

    return vm;
}
