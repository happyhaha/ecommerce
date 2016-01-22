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
      filter_values: {},

      sectors: [],
      specials: [],

      category_references_tree: {} // not for public usage
    };

    vm.actions = {
      // Выполнение запроса при загрузке страницы
      init: function (id) {
        vm.service.getInfo(id).then(function (data) {
          data = data.data;
          vm.models.categories = data.categories;
          vm.models.sectors = data.sectors;
          vm.models.specials = data.specials;
          if (typeof data.filter_values !== 'undefined') {
            vm.models.filter_values = data.filter_values;
          }
          //vm.actions.buildReferenceTree(vm.models.categories);
          vm.actions.recalcCategories();
        });
      },
      // ..__\
      // (o)(o) - велосипедик
      //buildReferenceTree: function(items) {
      //  angular.forEach(items, function(item, itemIndex){
      //    item.children = [];
      //    if (typeof vm.models.category_references_tree[item.id]!='undefined') {
      //      item.children = vm.models.category_references_tree[item.id].children;
      //    }
      //    vm.models.category_references_tree[item.id] = item;
      //
      //    if (item.parent_id!='') {
      //      if(typeof vm.models.category_references_tree[item.parent_id]=='undefined') {
      //        vm.models.category_references_tree[item.parent_id] = {children:[]};
      //      }
      //      vm.models.category_references_tree[item.parent_id].children.push(item);
      //      //item.parent = vm.models.category_references_tree[item.parent_id];
      //    }
      //  });
      //},
      // Удаление из массива, todo: Fix that shit
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
      categoryChecked: function(item) {
        //angular.forEach(item.children,function(child,childIndex){
        //  child.checked = item.checked;
        //  vm.actions.categoryChecked(child);
        //});
        vm.actions.recalcCategories();
      },
      // Событие на пересчет статистики
      recalcCategories: function() {
        var counter = 0;
        var catIds = {};
        var filterGroups = [];
        angular.forEach(vm.models.categories,function(row, rowIndex){
          if(row.checked && row.checked==1) {
            counter++;
            catIds[row.id] = true;
            filterGroups.push({
              title: row.title,
              items: row.filters
            });
          }
        });
        vm.models.selected_categories_count = counter;
        vm.models.filters = filterGroups;
      },
      fillFeature: function(filterGroupId, fillId, items) {
        var newValue = '';
        angular.forEach(items, function(row, index){
          if (row.id == fillId) {
            newValue = row.title;
          }
        });
        vm.models.filter_values[filterGroupId] = newValue;
      }
    };
  }
}).call(this);
