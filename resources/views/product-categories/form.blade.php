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
        'data-ng-controller' => 'ProductCategoryCtrl as PCat',
        'data-ng-init' => 'PCat.actions.init('.$model->id.')',
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

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="{{ $locale }}_title">
                            {{ trans('ecommerce::default.product-categories.fields.parent_id') }}
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
                                'label' => trans('ecommerce::default.product-categories.fields.title'),
                                'input' => Form::text('ProductCategory['.$locale.'][title]', $model->getNodeValue('title',$locale), ['class' => 'form-control']),
                            ])

                            @include('ecommerce::_form/group',[
                                'label' => trans('ecommerce::default.product-categories.fields.slug'),
                                'input' => Form::text('ProductCategory['.$locale.'][slug]', $model->getNodeValue('slug',$locale), ['class' => 'form-control']),
                            ])

                            @include('ecommerce::_form/group',[
                                'label' => trans('ecommerce::default.product-categories.fields.content'),
                                'input' => Form::textarea('ProductCategory['.$locale.'][content]', $model->getNodeValue('content',$locale), ['class' => 'form-control', 'ui-jq' => 'ckeditor', 'ui-options' => json_encode($ckeditorBasic)]),
                            ])

                            <div class="form-group">
                                <label class="col-sm-2 control-label" style="margin-top:11px;">
                                    {{ trans('ecommerce::default.product-categories.fields.filters') }}
                                </label>
                                <div class="col-sm-10">

                                    <div role="tabpanel">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active">
                                                <a href="#filters_tab_own" aria-controls="filters_tab_own" role="tab" data-toggle="tab">
                                                    Фильтры этой категории &nbsp; - &nbsp;
                                                    <span class="label label-success" data-ng-bind="PCat.models.filters.length"></span>
                                                </a>
                                            </li>
                                            <li role="presentation" data-ng-if="PCat.models.parent_filters.length">
                                                <a href="#filters_tab_parent" aria-controls="filters_tab_parent" role="tab" data-toggle="tab">
                                                    Фильтры родительский категорий &nbsp; - &nbsp;
                                                    <span class="label label-info" data-ng-bind="PCat.models.parent_filters.length"></span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="filters_tab_own">
                                                <table class="table table-stripped">
                                                    <thead>
                                                        <tr>
                                                            @foreach(config('app.locales') as $localeIndex => $locale)
                                                            <th>Название фильтра {{strtoupper($locale)}}</th>
                                                            @endforeach
                                                            <th>
                                                                Тип
                                                            </th>
                                                            <th>
                                                                Префикс значения <br/>
                                                                (Дж., тг., Кв., Кг.)
                                                            </th>
                                                            <th>
                                                                <a href="#" data-ng-click="PCat.actions.addFilter()" class="btn btn-info btn-sm">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody data-ng-if="PCat.models.filters.length>0">
                                                        <tr data-ng-repeat="item in PCat.models.filters">
                                                            @foreach(config('app.locales') as $localeIndex => $locale)
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                       name="FilterGroup[@{{ $index}}][{{$locale}}][title]"
                                                                       data-ng-model="item.{{$locale}}.title"
                                                                       placeholder="{{ trans('ecommerce::default.product-categories.hints.filter_title')  }}">
                                                            </td>
                                                            @endforeach
                                                            <td>
                                                                <select class="form-control"
                                                                        data-ng-model="item.type"
                                                                        data-ng-options="type.id as type.title for type in PCat.models.filter_types">
                                                                    <option value="">Пожалуйста, выберите тип</option>
                                                                </select>
                                                                <input type="text" name="FilterGroup[@{{ $index }}][id]" data-ng-model="item.id" style="display:none;">
                                                                <input type="text" name="FilterGroup[@{{ $index }}][type]" data-ng-model="item.type" style="display:none;">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="FilterGroup[@{{ $index }}][postifx]" data-ng-model="item.postifx" class="form-control" placeholder="Например: кДж.">
                                                            </td>
                                                            <td>
                                                                <a href="#" data-ng-click="PCat.actions.removeItem(item,'filters')" class="btn btn-danger btn-sm">X</a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody data-ng-if="!PCat.models.filters.length">
                                                        <tr>
                                                            <td colspan="2">
                                                                В этой категории нет фильтров на данный момент
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="text-muted">
                                                    * Название фильтра - будет отображаться на сайте, как заголовок группы фильтров. Например: <strong>Мощность двигателя</strong><br/>
                                                    * Тип - будет влиять на внешний вид фильтров в группе. Галочки будут выводить
                                                        фильтры в виде чекбоксов, дропдаун в виде выпадающего меню,
                                                        ползунок сответственно в виде перетаскиваемых границ на фильтре <br/>
                                                    * Префикс - необходим для специфических групп фильтров, чтобы их можно было фильтровать.
                                                        Например: если фильтр Вес, префикс у него должен быть <b>кг.</b> или <b>т.</b>,
                                                        и в товарах уже нужно будет писать только цифры, без указания <b>кг.</b>

                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="filters_tab_parent">
                                                <table class="table table-stripped">
                                                    <thead>
                                                        @foreach(config('app.locales') as $localeIndex => $locale)
                                                            <th>Название фильтра {{strtoupper($locale)}}</th>
                                                            @endforeach
                                                    </thead>
                                                    <tbody>
                                                        <tr data-ng-repeat="item in PCat.models.parent_filters">
                                                            @foreach(config('app.locales') as $localeIndex => $locale)
                                                            <td>
                                                                <div data-ng-bind="item.{{$locale}}.title"></div>
                                                            </td>
                                                            @endforeach
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="line line-dashed b-b line-lg pull-in"></div>

                            @include('ecommerce::_form/group',[
                                'label' => trans('ecommerce::default.product-categories.fields.seo_title'),
                                'input' => Form::text('ProductCategory['.$locale.'][seo_title]', $model->getNodeValue('seo_title',$locale), ['class' => 'form-control']),
                            ])

                            @include('ecommerce::_form/group',[
                                'label' => trans('ecommerce::default.product-categories.fields.seo_description'),
                                'input' => Form::text('ProductCategory['.$locale.'][seo_description]', $model->getNodeValue('seo_description',$locale), ['class' => 'form-control']),
                            ])

                            @include('ecommerce::_form/group',[
                                'label' => trans('ecommerce::default.product-categories.fields.seo_keywords'),
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
                                admin_route('ecommerce.product-categories.index'),
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

@section('scripts')
    <script src="/vendor/ecommerce/js/angular/helpers.js"></script>
    <script src="/vendor/ecommerce/js/angular/product_category.controller.js"></script>
    <script src="/vendor/ecommerce/js/angular/product_category.service.js"></script>
@endsection

