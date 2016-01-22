<div role="tabpanel" class="tab-pane active" id="tab-price-info">
    @include('ecommerce::_form/group',[
        'label' => trans('ecommerce::default.'.$codename.'.fields.product_brand_id'),
        'input' => Form::select('Product[product_brand_id]', $repository->getBrandList(), $model->product_brand_id, ['class' => 'form-control']),
    ])
    @include('ecommerce::_form/group',[
        'label' => trans('ecommerce::default.'.$codename.'.fields.article_number'),
        'input' => Form::text('Product[article_number]', $model->article_number, ['class' => 'form-control']),
    ])
    @include('ecommerce::_form/group',[
        'label' => trans('ecommerce::default.'.$codename.'.fields.price'),
        'input' => Form::text('Product[price]', $model->price, ['class' => 'form-control']),
    ])
    @include('ecommerce::_form/group',[
        'label' => trans('ecommerce::default.'.$codename.'.fields.price_new'),
        'input' => Form::text('Product[price_new]', $model->price_new, ['class' => 'form-control']),
    ])
    @include('ecommerce::_form/group',[
        'label' => trans('ecommerce::default.'.$codename.'.fields.quantity'),
        'input' => Form::text('Product[quantity]', $model->quantity, ['class' => 'form-control']),
    ])
    @include('ecommerce::_form/group',[
        'label' => trans('ecommerce::default.'.$codename.'.fields.type'),
        'input' => Form::select('Product[type]', $model->getTypeList(), $model->type, ['class' => 'form-control']),
    ])
    @include('ecommerce::_form/group',[
        'label' => trans('ecommerce::default.'.$codename.'.fields.rating'),
        'input' => '<label style="margin-right: 10px;">'.Form::radio('Product[rating]', 1, $model->rating==1?true:false).' 1</label>'
            .'<label style="margin-right: 10px;">'.Form::radio('Product[rating]', 2, $model->rating==2?true:false).' 2</label>'
            .'<label style="margin-right: 10px;">'.Form::radio('Product[rating]', 3, $model->rating==3?true:false).' 3</label>'
            .'<label style="margin-right: 10px;">'.Form::radio('Product[rating]', 4, $model->rating==4?true:false).' 4</label>'
            .'<label style="margin-right: 10px;">'.Form::radio('Product[rating]', 5, $model->rating==5?true:false).' 5</label>',
    ])
    @include('ecommerce::_form/group',[
        'label' => trans('ecommerce::default.'.$codename.'.fields.is_hot'),
        'input' => Form::hidden('Product[is_hot]',0)
        .Form::checkbox('Product[is_hot]', 1, $model->is_hot?true:false),
    ])
    @include('ecommerce::_form/group',[
        'label' => trans('ecommerce::default.'.$codename.'.fields.status'),
        'input' => Form::hidden('Product[status]',0)
        .Form::checkbox('Product[status]', 1, $model->status?true:false),
    ])
</div>
