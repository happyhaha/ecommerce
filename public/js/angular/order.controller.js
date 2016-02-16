/*global $, jQuery, alert, console, alert, angular*/
(function() {
  "use strict";
  angular.module('app').controller('OrderCtrl', ProductCtrl);
  ProductCtrl.$inject = ['$scope','OrderService'];
  function ProductCtrl($scope, OrderService) {
    var vm = this;
    vm.service = OrderService;
    vm.models = {
      items: [],
      item_status_list: [],
      user: null
    };
    vm.actions = {
      // Выполнение запроса при загрузке страницы
      init: function (id) {
        vm.service.getInfo(id).then(function (data) {
          data = data.data;
          vm.models.items = data.items;
          vm.models.item_status_list = data.item_status_list;
          if (data.user) {
            vm.models.user = data.user;
          }
        });
      },
      addItem: function() {
        vm.models.items.push({
          status: '1',
          count: 1
        });
      },
      removeItem: function(item) {
        var index = vm.models.items.indexOf(item);
        vm.models.items.splice(index, 1);
      },
      autocompleteSelected: function(vl) {
        var obj = angular.copy(vl);
        obj.status = '1';
        obj.count = 1;
        vm.models.items.push(obj);
      },
      userSelected: function(user) {
        vm.models.user = user;
      }
    };
  }
}).call(this);
