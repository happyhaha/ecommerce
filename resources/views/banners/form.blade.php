@extends('admin::base')

@section('main-before')
    {!! Form::model($model, [
        'method' => ($model->exists) ? 'PUT' : 'POST',
        'route' => [
            admin_prefix($target),
            ($model->exists) ? $model->id : ''
        ],
    ]) !!}
@endsection

@section('sidebar')
    <div class="wrapper">

    @include('ecommerce::_form/image',[
        'image' => (isset($image)?$image:null),
        'cropped_coords' => (isset($cropped_coords)?$cropped_coords:null),
        'model' => $model
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

            @include('ecommerce::_form/group',[
                'label' => trans('ecommerce::default.'.$codename.'.fields.name'),
                'input' => Form::text('Banner[name]', $model->name, ['class' => 'form-control']),
            ])
            @include('ecommerce::_form/group',[
                'label' => trans('ecommerce::default.'.$codename.'.fields.link'),
                'input' => Form::text('Banner[link]', $model->link, ['class' => 'form-control']),
            ])
            @include('ecommerce::_form/group',[
                'label' => trans('ecommerce::default.'.$codename.'.fields.is_blank'),
                'input' => Form::hidden('Banner[is_blank]',0)
                .Form::checkbox('Banner[is_blank]', 1, $model->is_blank?true:false, ['style'=>'margin-top: 11px;']),
            ])
            @include('ecommerce::_form/group',[
                'label' => trans('ecommerce::default.'.$codename.'.fields.width'),
                'input' => Form::text('Banner[width]', $model->width, ['class' => 'form-control']),
            ])
            @include('ecommerce::_form/group',[
                'label' => trans('ecommerce::default.'.$codename.'.fields.height'),
                'input' => Form::text('Banner[height]', $model->height, ['class' => 'form-control']),
            ])
            @include('ecommerce::_form/group',[
                'label' => trans('ecommerce::default.'.$codename.'.fields.code'),
                'input' => Form::textarea('Banner[code]', $model->code, ['class' => 'form-control']),
            ])
            @include('ecommerce::_form/group',[
                'label' => trans('ecommerce::default.'.$codename.'.fields.max_views'),
                'input' => Form::text('Banner[max_views]', $model->max_views, ['class' => 'form-control']),
            ])
            @include('ecommerce::_form/group',[
                'label' => trans('ecommerce::default.'.$codename.'.fields.current_views'),
                'input' => Form::text('Banner[current_views]', $model->current_views, ['class' => 'form-control']),
            ])
            @include('ecommerce::_form/group',[
                'label' => trans('ecommerce::default.'.$codename.'.fields.untill_at'),
                'input' => Form::text('Banner[untill_at]', ($model->untill_at?$model->untill_at->format('d/m/Y'):''), ['class' => 'form-control']),
            ])
            @include('ecommerce::_form/group',[
                'label' => trans('ecommerce::default.'.$codename.'.fields.status'),
                'input' => Form::hidden('Banner[status]',0)
                .Form::checkbox('Banner[status]', 1, $model->status?true:false, ['style'=>'margin-top: 11px;']),
            ])

            @foreach(config('app.locales') as $localeIndex => $locale)
                    <div role="tabpanel" class="tab-pane{{ ($localeIndex==0) ? ' active' : '' }}" id="lang-{{ $locale }}">


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
<link rel="stylesheet" href="/vendor/ecommerce/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" type="text/css"></link>
<script src="/vendor/ecommerce/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="/vendor/ecommerce/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.ru.min.js"></script>
<script src="/vendor/ecommerce/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.kk.min.js"></script>
<script>
    $('input[name="Banner[untill_at]"]').datepicker({
        format: "dd/mm/yyyy",
        language: "ru",
        weekStart: 1,
        todayHighlight: true,
        defaultViewDate: {
            year:{{date('Y')}},
            month:{{date('m')}},
            day:{{date('d')}}
        }
    });
</script>

@include('media::manager.modal',['image_ids'=>[''],'params' => ['multiple' => 0]])
@endsection
