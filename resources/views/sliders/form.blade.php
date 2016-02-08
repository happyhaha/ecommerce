@extends('admin::base')

@section('main-before')
    {!! Form::model($model, [
        'method' => ($model->exists) ? 'PUT' : 'POST',
        'route' => [
            admin_prefix($target),
            ($model->exists) ? $model->id : ''
        ],
        'data-ng-controller' => 'SliderCtrl as Slider',
        'data-ng-init' => 'Slider.actions.init('.$model->id.')',
    ]) !!}
@endsection

@section('sidebar')
    <div class="wrapper">

        @include('ecommerce::_form/statuses', [
            'model' => $model,
            'name' => 'Slider[status]',
        ])

        <div class="line line-dashed b-b line-lg"></div>

        @include('ecommerce::_form/images',[
            'images' => (isset($images)?$images:null),
            'multiple' => 1,
            'model' => $model,
            'urlField' => true,
            'type' => 'image',
        ])

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
                    'label' => trans('ecommerce::default.'.$codename.'.fields.model_type'),
                    'input' => Form::select('model_type', ['' => 'Ничего не выбрано'], '', [
                        'class' => 'form-control',
                        'data-ng-model' => 'Slider.models.model_type',
                        'data-ng-options' => 'item.id as item.title for item in Slider.models.items',
                        'data-ng-change' => 'Slider.actions.typeChanged()',
                    ]).' '.
                    Form::text('Slider[model_type]', '', ['style' => 'display:none;', 'data-ng-model' => 'Slider.models.model_type'])
                ])

                <div data-ng-hide="!Slider.models.current_type || Slider.models.current_type.static">
                    @include('ecommerce::_form/group',[
                        'label' => trans('ecommerce::default.'.$codename.'.fields.model_id'),
                        'input' => Form::select('Slider[model_id]', ['' => 'Ничего не выбрано'], '', [
                            'class' => 'form-control',
                            'data-ng-model' => 'Slider.models.model_id',
                            'data-ng-options' => 'item.id as item.title for item in Slider.models.model_items',
                        ]).' '.
                        Form::text('Slider[model_id]', '', ['style' => 'display:none;', 'data-ng-model' => 'Slider.models.model_id']),
                    ])
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

@section('main-after')
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script src="/vendor/ecommerce/js/angular/helpers.js"></script>
    <script src="/vendor/ecommerce/js/angular/slider.controller.js"></script>
    <script src="/vendor/ecommerce/js/angular/slider.service.js"></script>

    @include('ecommerce::_form.media_modal',['image_ids'=>['']])
@endsection
