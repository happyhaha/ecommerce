@extends('admin::base')

@section('main-before')
@endsection

@section('content')
    {!! Form::model($model, [
        'method' => ($model->exists) ? 'PUT' : 'POST',
        'route' => [
            admin_prefix($target),
            ($model->exists) ? $model->id : ''
        ],
    ]) !!}
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
                                'input' => Form::text('ProductSector['.$locale.'][title]', $model->getNodeValue('title',$locale), ['class' => 'form-control']),
                            ])

                            @include('ecommerce::_form/group',[
                                'label' => trans('ecommerce::default.'.$codename.'.fields.content'),
                                'input' => Form::textarea('ProductSector['.$locale.'][content]', $model->getNodeValue('content',$locale), ['class' => 'form-control', 'ui-jq' => 'ckeditor', 'ui-options' => json_encode($ckeditorBasic)]),
                            ])

                            @include('ecommerce::_form/group',[
                                'label' => trans('ecommerce::default.'.$codename.'.fields.seo_title'),
                                'input' => Form::text('ProductSector['.$locale.'][seo_title]', $model->getNodeValue('seo_title',$locale), ['class' => 'form-control']),
                            ])

                            @include('ecommerce::_form/group',[
                                'label' => trans('ecommerce::default.'.$codename.'.fields.seo_description'),
                                'input' => Form::text('ProductSector['.$locale.'][seo_description]', $model->getNodeValue('seo_description',$locale), ['class' => 'form-control']),
                            ])

                            @include('ecommerce::_form/group',[
                                'label' => trans('ecommerce::default.'.$codename.'.fields.seo_keywords'),
                                'input' => Form::text('ProductSector['.$locale.'][seo_keywords]', $model->getNodeValue('seo_keywords',$locale), ['class' => 'form-control']),
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
    {!! Form::close() !!}
@endsection
