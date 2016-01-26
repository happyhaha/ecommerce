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

                    @foreach(config('app.locales') as $localeIndex => $locale)
                        <div role="tabpanel" class="tab-pane{{ ($localeIndex==0) ? ' active' : '' }}" id="lang-{{ $locale }}">

                            @include('ecommerce::_form/group',[
                                'label' => trans('ecommerce::default.'.$codename.'.fields.title'),
                                'input' => Form::text('ProductBrand['.$locale.'][title]', $model->getNodeValue('title',$locale), ['class' => 'form-control']),
                            ])

                            @include('ecommerce::_form/group',[
                                'label' => trans('ecommerce::default.'.$codename.'.fields.content'),
                                'input' => Form::textarea('ProductBrand['.$locale.'][content]', $model->getNodeValue('content',$locale), ['class' => 'form-control', 'ui-jq' => 'ckeditor', 'ui-options' => json_encode($ckeditorBasic)]),
                            ])

                            @include('ecommerce::_form/group',[
                                'label' => trans('ecommerce::default.'.$codename.'.fields.seo_title'),
                                'input' => Form::text('ProductBrand['.$locale.'][seo_title]', $model->getNodeValue('seo_title',$locale), ['class' => 'form-control']),
                            ])

                            @include('ecommerce::_form/group',[
                                'label' => trans('ecommerce::default.'.$codename.'.fields.seo_description'),
                                'input' => Form::text('ProductBrand['.$locale.'][seo_description]', $model->getNodeValue('seo_description',$locale), ['class' => 'form-control']),
                            ])

                            @include('ecommerce::_form/group',[
                                'label' => trans('ecommerce::default.'.$codename.'.fields.seo_keywords'),
                                'input' => Form::text('ProductBrand['.$locale.'][seo_keywords]', $model->getNodeValue('seo_keywords',$locale), ['class' => 'form-control']),
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
    @include('media::manager.modal',['image_ids'=>[''],'params' => ['multiple' => 0]])
@endsection
