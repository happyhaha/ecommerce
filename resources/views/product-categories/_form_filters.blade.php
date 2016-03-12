
<div class="form-group">
    <div class="col-sm-12">
        <h3>
            {{ trans('ecommerce::default.'.$codename.'.fields.filters') }}
        </h3>
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
                                Выводить в каталоге?
                            </th>
                            <th>
                                <a href="#" data-eat-click data-ng-click="PCat.actions.addFilter()" class="btn btn-info btn-sm">
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
                                           placeholder="{{ trans('ecommerce::default.'.$codename.'.hints.filter_title')  }}">
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
                                <input type="text" name="FilterGroup[@{{ $index }}][postfix]" data-ng-model="item.postfix" class="form-control" placeholder="Например: кДж.">
                            </td>
                            <td>
                                <input type="checkbox" data-ng-model="item.status" data-ng-checked="item.status=='1'" data-ng-true-value="'1'" data-ng-false-value="'0'">
                                <input type="text" name="FilterGroup[@{{ $index }}][status]" data-ng-model="item.status" style="display:none;">
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
