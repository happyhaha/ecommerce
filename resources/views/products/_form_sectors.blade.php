<div role="tabpanel" class="tab-pane" id="tab-sectors-info">
    <div class="form-group">
        <label class="col-sm-2 control-label" style="padding-top: 0;">
            Отрасли
        </label>
        <div class="col-sm-10">
            <div class="" data-ng-repeat="item in Prod.models.sectors">
                <label>
                    <input type="checkbox"
                           data-ng-model="item.checked"
                           data-ng-true-value="'1'"
                           data-ng-false-value="'0'"
                    >
                    <span data-ng-bind-template="@{{item.title}}"></span>
                </label>
                <input type="text" name="ProductSector[@{{$index}}][id]"
                       data-ng-model="item.id" style="display:none;"/>
                <input type="text" name="ProductSector[@{{$index}}][checked]"
                       data-ng-model="item.checked" style="display:none;"/>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" style="padding-top: 0;">
            Акции
        </label>
        <div class="col-sm-10">
            <div class="" data-ng-repeat="item in Prod.models.specials">
                <label>
                    <input type="checkbox"
                           data-ng-model="item.checked"
                           data-ng-true-value="'1'"
                           data-ng-false-value="'0'"
                    >
                    <span data-ng-bind-template="@{{item.title}}"></span>
                </label>
                <input type="text" name="SpecialOffer[@{{$index}}][id]"
                       data-ng-model="item.id" style="display:none;"/>
                <input type="text" name="SpecialOffer[@{{$index}}][checked]"
                       data-ng-model="item.checked" style="display:none;"/>
            </div>
            <div data-ng-if="!Prod.models.specials.length">Нет ни одной акции на данный момент</div>
        </div>
    </div>
</div>
