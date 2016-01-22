@extends('admin::base')

@section('main-before')
    {!! Form::model($model, [
        'method' => ($model->exists) ? 'PUT' : 'POST',
        'route' => [
            admin_prefix($target),
            ($model->exists) ? $model->id : ''
        ],
        'data-ng-controller' => 'OrderCtrl as Order',
        'data-ng-init' => 'Order.actions.init('.$model->id.')',
    ]) !!}
@endsection

@section('content')
@if($errors)
    <div>
        <ul>
        @foreach($errors->all('<li>:message</li>') as $error)
                {!! $error !!}
            @endforeach
        </ul>
    </div>
@endif
<div class="wrapper-md">
    <div class="tab-container">
        <div class="form-horizontal">
            <div class="tab-content">
                @include('ecommerce::_form/group',[
                    'label' => trans('ecommerce::default.'.$codename.'.fields.user_id'),
                    'input' => Form::text('Order[user_id]', $model->user_id, ['class' => 'form-control']),
                ])
                @include('ecommerce::_form/group',[
                    'label' => trans('ecommerce::default.'.$codename.'.fields.payment_type'),
                    'input' => Form::select('Order[payment_type]', $model->getPaymentTypeList(), $model->payment_type, ['class' => 'form-control']),
                ])
                @include('ecommerce::_form/group',[
                    'label' => trans('ecommerce::default.'.$codename.'.fields.delivery_type'),
                    'input' => Form::select('Order[delivery_type]', $model->getDeliveryTypeList(), $model->delivery_type, ['class' => 'form-control']),
                ])
                @include('ecommerce::_form/group',[
                    'label' => trans('ecommerce::default.'.$codename.'.fields.delivery_price'),
                    'input' => Form::text('Order[delivery_price]', $model->delivery_price, ['class' => 'form-control']),
                ])
                @include('ecommerce::_form/group',[
                    'label' => trans('ecommerce::default.'.$codename.'.fields.city'),
                    'input' => Form::text('Order[city]', $model->city, ['class' => 'form-control']),
                ])
                @include('ecommerce::_form/group',[
                    'label' => trans('ecommerce::default.'.$codename.'.fields.address'),
                    'input' => Form::text('Order[address]', $model->address, ['class' => 'form-control']),
                ])
                @include('ecommerce::_form/group',[
                    'label' => trans('ecommerce::default.'.$codename.'.fields.comment'),
                    'input' => Form::textarea('Order[comment]', $model->comment, ['class' => 'form-control']),
                ])
                @include('ecommerce::_form/group',[
                    'label' => trans('ecommerce::default.'.$codename.'.fields.payment_status'),
                    'input' => Form::select('Order[payment_status]', $model->getPaymentStatusList(), $model->payment_status, ['class' => 'form-control']),
                ])
                @include('ecommerce::_form/group',[
                    'label' => trans('ecommerce::default.'.$codename.'.fields.status'),
                    'input' => Form::select('Order[status]', $model->getStatusList(), $model->status, ['class' => 'form-control']),
                ])

                <div class="form-group">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Наименование</th>
                                    <th>Кол-во</th>
                                    <th>Статус</th>
                                    <th>
                                        <button class="btn btn-xs btn-success" type="button" data-ng-click="Order.actions.addItem()">
                                            &nbsp;+&nbsp;
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-ng-repeat="item in Order.models.items">
                                    <td data-ng-bind="item.id"></td>
                                    <td data-ng-bind="item.title"></td>
                                    <td>
                                        <input type="number" class="form-control" data-ng-model="item.count" style="max-width:80px;" />
                                    </td>
                                    <td>
                                        <select data-ng-model="item.status" data-ng-options="key as value for (key,value) in Order.models.item_status_list" class="form-control">

                                        </select>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-xs btn-danger" data-ng-click="Order.actions.removeItem(item)">
                                            &nbsp;X&nbsp;
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody data-ng-if="!Order.models.items.length">
                                <tr>
                                    <td colspan="5">
                                        Нет товаров в данном заказе
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        {!! Form::submit(
                            trans('admin::default.actions.save'),
                            ['class' => 'btn btn-primary']
                        ) !!}
                        {!! Html::link(
                            admin_route('ecommerce.'.$codename.'.index'),
                            trans('admin::default.actions.back'),
                            ['class' => 'btn btn-sm btn-default']
                        ) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="/vendor/ecommerce/js/angular/helpers.js"></script>
    <script src="/vendor/ecommerce/js/angular/order.controller.js"></script>
    <script src="/vendor/ecommerce/js/angular/order.service.js"></script>
@endsection

@section('main-after')
{!! Form::close() !!}
@endsection
