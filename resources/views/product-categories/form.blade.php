@extends('admin::base')

@section('main-before')
    {!! Form::model($model, [
        'method' => ($model->exists) ? 'PUT' : 'POST',
        'route' => [
            admin_prefix($target),
            ($model->exists) ? $model->id : ''
        ],
        'data-ng-controller' => 'ProductCategoryCtrl as PCat',
        'data-ng-init' => 'PCat.actions.init('.$model->id.')',
    ]) !!}
@endsection

@section('sidebar')
    <div class="wrapper">

        @include('ecommerce::_form/statuses', [
            'model' => $model,
            'name' => 'ProductCategory[status]',
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
    <div class="wrapper-md">
        <div class="tab-container">
            <ul class="nav nav-tabs" role="tablist">
                @foreach(config('app.locales') as $localeIndex => $locale)
                    <li class="{{ ($localeIndex==0) ? 'active' : '' }}">
                        <a href="#lang-{{ $locale }}" role="tab" data-toggle="tab">
                            {{ $locale }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="form-horizontal">
                <div class="tab-content">

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="{{ $locale }}_title">
                            {{ trans('ecommerce::default.'.$codename.'.fields.parent_id') }}
                        </label>
                        <div class="col-sm-10">
                            {!! Form::select('ProductCategory[parent_id]', $repository->getTree(), $model->parent_id, [
                                'class' => 'form-control',
                                'data-changed-directive' => '',
                                'data-ev' => '\'auuu\'',
                            ]) !!}
                            <div class="text-muted">{{  '' }}</div>
                        </div>
                    </div>


                    <div class="line line-dashed b-b line-lg pull-in"></div>

                    @foreach(config('app.locales') as $localeIndex => $locale)
                        <div role="tabpanel" class="tab-pane{{ ($localeIndex==0) ? ' active' : '' }}" id="lang-{{ $locale }}">

                            @include('ecommerce::_form/group',[
                                'label' => trans('ecommerce::default.'.$codename.'.fields.title'),
                                'input' => Form::text('ProductCategory['.$locale.'][title]', $model->getNodeValue('title',$locale), ['class' => 'form-control']),
                                'errors' => $errors->get($locale.'.title')
                            ])

                            {{--@include('ecommerce::_form/group',[--}}
                                {{--'label' => trans('ecommerce::default.'.$codename.'.fields.slug'),--}}
                                {{--'input' => Form::text('ProductCategory['.$locale.'][slug]', $model->getNodeValue('slug',$locale), ['class' => 'form-control']),--}}
                            {{--])--}}

                            @include('ecommerce::_form/group',[
                                'label' => trans('ecommerce::default.'.$codename.'.fields.content'),
                                'input' => Form::textarea('ProductCategory['.$locale.'][content]', $model->getNodeValue('content',$locale), ['class' => 'form-control', 'ui-jq' => 'ckeditor', 'ui-options' => json_encode($ckeditorBasic)]),
                            ])

                            @include('ecommerce::'.$codename.'/_form_filters',[
                                'codename' => $codename,
                                'model' => $model,
                            ])



                            @include('ecommerce::_form/group',[
                                'label' => trans('ecommerce::default.'.$codename.'.fields.seo_title'),
                                'input' => Form::text('ProductCategory['.$locale.'][seo_title]', $model->getNodeValue('seo_title',$locale), ['class' => 'form-control']),
                            ])

                            @include('ecommerce::_form/group',[
                                'label' => trans('ecommerce::default.'.$codename.'.fields.seo_description'),
                                'input' => Form::text('ProductCategory['.$locale.'][seo_description]', $model->getNodeValue('seo_description',$locale), ['class' => 'form-control']),
                            ])

                            @include('ecommerce::_form/group',[
                                'label' => trans('ecommerce::default.'.$codename.'.fields.seo_keywords'),
                                'input' => Form::text('ProductCategory['.$locale.'][seo_keywords]', $model->getNodeValue('seo_keywords',$locale), ['class' => 'form-control']),
                            ])

                        </div>
                    @endforeach
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
    <script src="/vendor/ecommerce/js/angular/product_category.controller.js"></script>
    <script src="/vendor/ecommerce/js/angular/product_category.service.js"></script>
@endsection

