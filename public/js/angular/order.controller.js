(function() {
  angular.module('app').controller('OrderCtrl', ProductCtrl);
  ProductCtrl.$inject = ['$scope','OrderService'];
  function ProductCtrl($scope, OrderService) {
    var vm = this;
    vm.service = OrderService;
    vm.models = {
      items: [],
      item_status_list: []
    };
    vm.actions = {
      // Выполнение запроса при загрузке страницы
      init: function (id) {
        vm.service.getInfo(id).then(function (data) {
          data = data.data;
          vm.models.items = data.items;
          vm.models.item_status_list = data.item_status_list;
        });
      },
      addItem: function() {
        vm.models.items.push({
          status: '0',
          count: 1
        });
      },
      removeItem: function(item) {
        var index = vm.models.items.indexOf(item);
        vm.models.items.splice(index, 1);
      }
    };
  }
}).call(this);
