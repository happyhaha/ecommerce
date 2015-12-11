<div role="tabpanel" class="tab-pane" id="tab-categories-info">
    <div class="form-group">
        <label class="col-sm-2 control-label">
            Категории
        </label>
        <div class="col-sm-10">
            <div class="" data-ng-repeat="item in Prod.models.categories" style="margin-left: @{{10*item.depth}}px;">
                <label>
                    <input type="checkbox"
                           data-ng-model="item.checked"
                           data-ng-true-value="'1'"
                           data-ng-false-value="'0'"
                           data-ng-change="Prod.actions.categoryChecked(item)">
                    <span data-ng-bind-template="@{{item.title}}"></span>
                </label>
                <input type="text" name="ProductCategories[@{{$index}}][id]"
                       data-ng-model="item.id" style="display:none;"/>
                <input type="text" name="ProductCategories[@{{$index}}][checked]"
                       data-ng-model="item.checked" style="display:none;"/>
            </div>
        </div>
    </div>
</div>
<div role="tabpanel" class="tab-pane" id="tab-filters-info">
    <div data-ng-if="Prod.models.filters.length">
        <div class="" data-ng-repeat="filterGroup in Prod.models.filters">
            <div style="margin-bottom: 15px;">
                <strong data-ng-bind="filterGroup.title"></strong>
            </div>
            <div data-ng-repeat="filter in filterGroup.items" style="margin-bottom: 15px;">
                <div class="form-group">
                    <label class="col-md-2 control-label" data-ng-bind="filter.title"></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="Filter[@{{ $parent.$index }}][@{{$index}}][value]"
                               data-ng-model="Prod.models.filter_values[filter.group_id]" />
                        <input type="text" name="Filter[@{{ $parent.$index }}][@{{$index}}][group_id]"
                               data-ng-model="filter.group_id" style="display:none;" />
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" data-ng-model="autofill"
                                data-ng-change="Prod.actions.fillFeature(filter.group_id, autofill, filter.available_values)"
                                data-ng-options="vl.id as vl.full_title for vl in filter.available_values">
                            <option value="">Существующие варианты</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
        </div>
    </div>

    <div data-ng-if="!Prod.models.filters.length">
        <div class="" style="margin-bottom: 20px;">
            <div class="alert alert-warning" role="alert">
                Пожалуйста, выберите категорию товара, чтобы заполнить характеристики.
            </div>
        </div>
    </div>
</div>
