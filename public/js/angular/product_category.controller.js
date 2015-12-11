(function() {

    angular.module('app').controller('ProductCategoryCtrl', ProductCategoryCtrl);
    ProductCategoryCtrl.$inject = ['$scope','ProductCategoryService'];
    function ProductCategoryCtrl($scope, ProductCategoryService) {
        var vm = this;

        vm.service = ProductCategoryService;

        vm.models = {
            filters: [],
            parent_filters: [],
            filter_types: [
              {id: '1', title: 'Галочки'},
              {id: '2', title: 'Дропдаун'},
              {id: '3', title: 'Ползунок'}
            ]
        };

        vm.actions = {
            init: function (id) {
                vm.service.getFilters(id).then(function (data) {
                    data = data.data;
                    vm.models.filters = data.filters;
                    vm.models.parent_filters = data.parent_filters;
                });
            },
            addFilter:function() {
                vm.models.filters.push({});
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
            parentChanged: function(id) {
                vm.service.getParentFilters(id).then(function (data) {
                    data = data.data;
                    vm.models.parent_filters = data.parent_filters;
                });
            }
        };

        $scope.$on('auuu',function(event,vl){
            vm.actions.parentChanged(vl.value);
        })
    }
}).call(this);
