<?php

namespace Ibec\Ecommerce;

use Ibec\Ecommerce\Database\ProductCategory as MainModel;
use Ibec\Ecommerce\Database\FilterGroup;

/**
 * Класс репозитория для всех запросов моделей на стороне контроллера админки
 */
class ProductCategoryRepository extends BaseRepository
{

    /**
     * Перечисление атрибутов позволенных для фильтрации
     */
    public $paramRules = [
        'id' => '=',
        'title' => 'like',
    ];

    public function __construct(MainModel $model)
    {
        $this->modelName = get_class($model);
    }

    public function save(&$model, $inputData)
    {
        $mainData = $inputData['ProductCategory'];
        if ($model->validate($mainData)) {

            $model->fill($mainData);
            if (!$model->exists) {
                $model->slug = $model->createSlug($mainData['ru']['title']);
            }
            $model->save();
            $this->saveNodes($model, 'product_category_id', $mainData);

            if ($this->hasImages($model)) {
                $this->saveImage($model, $inputData);
            }

            $filters = array_get($inputData, 'FilterGroup', []);

            $filterIds = [];
            foreach ($filters as $filterData) {
                if (isset($filterData['id']) && $filterData['id']!='') {
                    $filterGroup = FilterGroup::find($filterData['id']);
                    $filterGroup->update($filterData);
                } else {
                    $filterGroup = new FilterGroup();
                    $filterGroup->fill($filterData);
                    $filterGroup->product_category_id = $model->id;
                    if ($filterGroup->validate($filterData)) {
                        $filterGroup->save();
                    }
                }

                if ($filterGroup->id) {
                    $filterIds[] = $filterGroup->id;
                    $this->saveNodes($filterGroup, 'filter_group_id', $filterData);
                }
            }

            FilterGroup::where('product_category_id', '=', $model->id)->whereNotIn('id', $filterIds)->delete();

            return true;
        }

        return false;
    }

    /**
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getTree($id = "")
    {
        if(!empty($id)) //не выводить в селекте самого себя
        {
            $models = MainModel::where('id', '>', 0)->whereNotIn('id', [$id])->orderBy('lft', 'asc')->get();    
        }
        else
        {
            $models = MainModel::where('id', '>', 0)->orderBy('lft', 'asc')->get();
        }
        

        $html = [
            '' => 'Главная категория',
        ];
        foreach ($models as $model) {
            $html[$model->id] = str_repeat("&mdash;", $model->depth).$model->getNodeValue('title', 'ru');
            if ( array_key_exists('children', $model) ) {
                $html.= toSelect($model['children'], $model->depth);
            }
        }
        

        return $html;
    }

    public function getPlainTree()
    {
        $models = MainModel::where('id', '>', 0)->orderBy('lft', 'asc');

        return $models;
    }
}
