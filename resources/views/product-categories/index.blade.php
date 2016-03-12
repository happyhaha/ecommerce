@extends('admin::base')

@section('title-right')
    {!! Html::link(
        admin_route('ecommerce.'.$codename.'.create'),
        trans('admin::default.actions.create'),
        ['class' => 'btn btn-success'])
    !!}
@endsection

@section('sidebar')
<div class="wrapper"></div>
@endsection

@section('content')
    <div class="wrapper-md" data-ng-controller="MenuTreeCtrl"
       ng-init="url = '{{ admin_route('categories.tree.all') }}'; ">
        <div class="panel panel-default">
            <div class="panel-heading">
                @include('ecommerce::_index/bunch_actions', ['codename' => $codename])
                <div class="table-responsive">
                    <table class="table table-striped b-t b-light">
                        <thead>
                        <tr>
                            <th><label  class="i-checks m-b-none js-check-checkbox"><input onchange="applyBulkCheck($(this))" type="checkbox"><i></i></label></th>
                            <th>{{ trans('ecommerce::default.filters.fields.id') }}</th>
                            <th>{{ trans('ecommerce::default.filters.fields.title') }}</th>
                            <th>{{ trans('admin::default.actions.label') }}</th>
                        </tr>
                        </thead>
                        @if(count($items))
                        <div class="panel-body">
                            <div ui-jq="nestable" ui-callback="collapseNestable" class="dd">
                                @include('ecommerce::product-categories._tree', ['items' => $items])
                            </div>
                        </div>
                            
                        @else
                        <tbody>

                            <tr>
                                <td colspan="5">{{ trans('ecommerce::default.filters.empty') }}</td>
                            </tr>
                        </tbody>
                            
                        @endif
                    </table>
                </div>
                <div class="row wrapper">
                    <div class="col-sm-4 hidden-xs js__disabledManipulation">
                        <select class="input-sm form-control w-sm inline v-middle">
                            <option value="delete">
                                {{ trans('ecommerce::default.actions.delete_selected') }}
                            </option>
                        </select>
                        <button data-action="batchAction" data-url="{{ '' }}" class="btn btn-sm btn-default apply_bulk">
                            {{ trans('ecommerce::default.actions.apply') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        collapseNestable = function(nestable) {
            $(nestable).nestable('collapseAll');
        }
    </script>
@endsection
