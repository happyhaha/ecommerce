@extends('admin::base')

@section('main-before')
    {!! Form::model($model, [
        'method' => ($model->exists) ? 'PUT' : 'POST',
        'route' => [
            admin_prefix($target),
            ($model->exists) ? $model->id : ''
        ],
        'data-ng-controller' => 'ProductCtrl as Prod',
        'data-ng-init' => 'Prod.actions.init('.$model->id.')',
    ]) !!}
@endsection

@section('sidebar')
    <div class="wrapper">

        <div class="">
            <div class="m-b-sm text-md">{{ trans('content::default.posts.moderation') }}</div>
            <div>
                @foreach(['1' => 'approved', '0' => 'discarded'] as $key => $status)
                    <div class="radio">
                        <label class="i-checks">
                            {!! Form::radio('Product[status]', $key, ($key==$model->status?true:false)) !!}
                            <i></i>
                            {{ trans('social::default.moderation.'.$status) }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="line line-dashed b-b line-lg"></div>

        @include('ecommerce::_form/images',[
            'images' => (isset($images)?$images:null),
            'multiple' => 1,
            'model' => $model
        ])

        <div class="line line-dashed b-b line-lg"></div>

        <div class="">
            <div class="m-b-sm text-md">{{ trans('admin::default.actions.label') }}</div>
            {!! Form::submit(
                trans('admin::default.actions.save'),
                ['class' => 'btn btn-block btn-primary']
            ) !!}
            {!! Html::link(
                admin_route('ecommerce.'.$codename.'.index'),
                trans('admin::default.actions.back'),
                ['class' => 'btn btn-sm btn-block btn-default']
            ) !!}
        </div>
    </div>
@endsection


@section('content')

    @if($errors)
        <div class="text-danger">
            <ul style="margin-top: 10px;">
            @foreach($errors->all('<li>:message</li>') as $error)
                    {!! $error !!}
                @endforeach
            </ul>
        </div>
    @endif
    <div class="wrapper-md">
        <div class="tab-container">
            <ul class="nav nav-tabs" role="tablist">
                <li class="active">
                    <a href="#tab-price-info" role="tab" data-toggle="tab">
                        Основные параметры
                    </a>
                </li>
                @foreach(config('app.locales') as $localeIndex => $locale)
                    <li class="">
                        <a href="#lang-{{ $locale }}" role="tab" data-toggle="tab">
                            Описание: {{ $locale }}
                        </a>
                    </li>
                @endforeach
                <li class="">
                    <a href="#tab-categories-info" role="tab" data-toggle="tab">
                        Категории
                        <span class="label label-success" data-ng-bind="Prod.models.selected_categories_count"></span>
                        /
                        <span class="label label-info" data-ng-bind="Prod.models.categories.length"></span>
                    </a>
                </li>
                <li class="">
                    <a href="#tab-filters-info" role="tab" data-toggle="tab">
                        Характеристики
                    </a>
                </li>
                <li class="">
                    <a href="#tab-sectors-info" role="tab" data-toggle="tab">
                        Отрасли и Акции
                    </a>
                </li>
            </ul>
            <div class="form-horizontal">
                <div class="tab-content">

                    @include('ecommerce::'.$codename.'/_form_main',[
                        'ckeditorBasic' => $ckeditorBasic,
                        'repository' => $repository,
                        'model' => $model,
                        'codename' => $codename,
                    ])

                    @include('ecommerce::'.$codename.'/_form_nodes',[
                        'ckeditorBasic' => $ckeditorBasic,
                        'repository' => $repository,
                        'model' => $model,
                        'codename' => $codename,
                    ])

                    @include('ecommerce::'.$codename.'/_form_categories',[
                        'repository' => $repository,
                        'model' => $model,
                        'codename' => $codename,
                    ])

                    @include('ecommerce::'.$codename.'/_form_sectors',[
                        'repository' => $repository,
                        'model' => $model,
                        'codename' => $codename,
                    ])

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

@section('main-after')
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script src="/vendor/ecommerce/js/angular/helpers.js"></script>
    <script src="/vendor/ecommerce/js/angular/product.controller.js"></script>
    <script src="/vendor/ecommerce/js/angular/product.service.js"></script>

    @include('ecommerce::_form.media_modal',['image_ids'=>[''],'params' => ['multiple' => 0]])
@endsection
