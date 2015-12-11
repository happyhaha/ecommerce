(function() {

  angular.module('app').controller('ProductCtrl', ProductCtrl);
  ProductCtrl.$inject = ['$scope','ProductService'];
  function ProductCtrl($scope, ProductCategoryService) {
    var vm = this;

    vm.service = ProductCategoryService;

    vm.models = {
      categories: [],
      selected_categories_count: 0,
      selected_categories: {},
      filters: [],
      filter_values: {}
    };

    vm.actions = {
      init: function (id) {
        vm.service.getInfo(id).then(function (data) {
          data = data.data;
          vm.models.categories = data.categories;
          if (typeof data.filter_values !== 'undefined') {
            vm.models.filter_values = data.filter_values;
          }
          vm.actions.categoryChecked();

        });
      },
      removeItem: function(item,path) {
        var target = vm.models;
        var road = path.split('.');
        for(var i in road) {
          if (typeof target[road[i]] == 'object') {
            target = target[road[i]];
          } else if (typeof target[road[i]] == 'undefined') {
            if ((i+1)==road.length) {
              target[road[i]] = [];
            } else {
              target[road[i]] = {};
            }
            target = target[road[i]];
          }
        }
        var index = target.indexOf(item);
        if (index!=-1) {
          target.splice(index,1);
        }
      },
      categoryChecked: function() {
        var counter = 0;
        var catIds = {};
        var normalFilters = [];
        angular.forEach(vm.models.categories,function(row, rowIndex){
          if(row.checked && row.checked==1) {
            counter++;
            catIds[row.id] = true;
            normalFilters.push({
              title: row.title,
              items: row.filters
            });
          }
        });
        vm.models.selected_categories_count = counter;
        vm.models.filters = normalFilters;
      },
      fillFeature: function(filterGroupId, fillId, items) {
        var newValue = '';
        angular.forEach(items, function(row, index){
          console.log(row, fillId);
          if (row.id == fillId) {
            newValue = row.title;
          }
        });
        vm.models.filter_values[filterGroupId] = newValue;
      }
    };
  }
}).call(this);
