@foreach(config('app.locales') as $localeIndex => $locale)
    <div role="tabpanel" class="tab-pane" id="lang-{{ $locale }}">

        @include('ecommerce::_form/group',[
            'label' => trans('ecommerce::default.'.$codename.'.fields.title'),
            'input' => Form::text('Product['.$locale.'][title]', $model->getNodeValue('title',$locale), ['class' => 'form-control']),
            'hint' => trans('ecommerce::default.'.$codename.'.hints.title'),
        ])

        @include('ecommerce::_form/group',[
            'label' => trans('ecommerce::default.'.$codename.'.fields.content'),
            'input' => Form::textarea('Product['.$locale.'][content]', $model->getNodeValue('content',$locale), ['class' => 'form-control', 'ui-jq' => 'ckeditor', 'ui-options' => json_encode($ckeditorBasic)]),
        ])

        @include('ecommerce::_form/group',[
            'label' => trans('ecommerce::default.'.$codename.'.fields.delivery'),
            'input' => Form::text('Product['.$locale.'][delivery]', $model->getNodeValue('delivery',$locale), ['class' => 'form-control']),
            'hint' => trans('ecommerce::default.'.$codename.'.hints.delivery'),
        ])
        @include('ecommerce::_form/group',[
            'label' => trans('ecommerce::default.'.$codename.'.fields.preparing'),
            'input' => Form::text('Product['.$locale.'][preparing]', $model->getNodeValue('preparing',$locale), ['class' => 'form-control']),
        ])
        @include('ecommerce::_form/group',[
            'label' => trans('ecommerce::default.'.$codename.'.fields.review'),
            'input' => Form::textarea('Product['.$locale.'][review]', $model->getNodeValue('review',$locale), ['class' => 'form-control', 'ui-jq' => 'ckeditor', 'ui-options' => json_encode($ckeditorBasic)]),
        ])
        @include('ecommerce::_form/group',[
            'label' => trans('ecommerce::default.'.$codename.'.fields.warranty_short'),
            'input' => Form::text('Product['.$locale.'][warranty_short]', $model->getNodeValue('warranty_short',$locale), ['class' => 'form-control']),
        ])
        @include('ecommerce::_form/group',[
            'label' => trans('ecommerce::default.'.$codename.'.fields.warranty'),
            'input' => Form::textarea('Product['.$locale.'][warranty]', $model->getNodeValue('warranty',$locale), ['class' => 'form-control', 'ui-jq' => 'ckeditor', 'ui-options' => json_encode($ckeditorBasic)]),
        ])
        @include('ecommerce::_form/group',[
            'label' => trans('ecommerce::default.'.$codename.'.fields.additional'),
            'input' => Form::textarea('Product['.$locale.'][additional]', $model->getNodeValue('additional',$locale), ['class' => 'form-control', 'ui-jq' => 'ckeditor', 'ui-options' => json_encode($ckeditorBasic)]),
        ])

        @include('ecommerce::_form/group',[
            'label' => trans('ecommerce::default.'.$codename.'.fields.seo_title'),
            'input' => Form::text('Product['.$locale.'][seo_title]', $model->getNodeValue('seo_title',$locale), ['class' => 'form-control']),
        ])

        @include('ecommerce::_form/group',[
            'label' => trans('ecommerce::default.'.$codename.'.fields.seo_description'),
            'input' => Form::text('Product['.$locale.'][seo_description]', $model->getNodeValue('seo_description',$locale), ['class' => 'form-control']),
        ])

        @include('ecommerce::_form/group',[
            'label' => trans('ecommerce::default.'.$codename.'.fields.seo_keywords'),
            'input' => Form::text('Product['.$locale.'][seo_keywords]', $model->getNodeValue('seo_keywords',$locale), ['class' => 'form-control']),
        ])

    </div>
@endforeach
