@extends('admin::base')
@section('content')
  <div class="wrapper-md" data-ng-controller="MenuTreeCtrl"
       ng-init="url = '{{ admin_route('menu.tree.all', [$root->id]) }}'; storeUrl = '{{ admin_route('menu.tree.menu.store', [$root->id]) }}'"
    >
    <div class="row">
      <div class="col-sm-11">
        <div class="panel panel-default">
          <div class="panel-heading">
            Structure
          </div>
          <div class="panel-body">
            <div ui-jq="nestable" ui-callback="collapseNestable" class="dd">
              @include('menu::roots._tree', ['items' => $tree, 'root' => $root])
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
@endsection
@section('scripts')
    <script>
        collapseNestable = function(nestable) {
            $(nestable).nestable('collapseAll');
        }
    </script>
@endsection