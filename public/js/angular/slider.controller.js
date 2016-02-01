/*global $:false, angular:false, console:false */
(function() {
  'use strict';

  angular.module('app').controller('SliderCtrl', SliderCtrl);
  SliderCtrl.$inject = ['$scope','SliderService'];
  function SliderCtrl($scope, SliderService) {
    var vm = this;
    vm.service = SliderService;
    vm.models = {
      items: [],
      current_type: null,
      model_type: '',
      model_id: '',
      model_items: []
    };
    vm.actions = {
      // Выполнение запроса при загрузке страницы
      init: function (id) {
        vm.service.getInfo(id).then(function (data) {
          data = data.data;
          vm.models.items = data.items;
          vm.models.model_type = data.model_type;
          vm.models.model_id = data.model_id;
          vm.actions.typeChanged();
        });
      },
      typeChanged: function () {
        vm.models.model_id = '';
        angular.forEach(vm.models.items, function (item, index) {
          if (item.id == vm.models.model_type) {
            vm.models.current_type = item;

            if (!item.static) {
              vm.models.model_items = [];
              vm.service.getRows(item.id).then(function (data) {
                data = data.data;
                vm.models.model_items = data.model_items;
              });
            }
          }
        });
      }
    };
  }
}).call(this);
