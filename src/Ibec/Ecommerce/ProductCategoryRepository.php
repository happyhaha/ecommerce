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
        $input = $inputData['ProductCategory'];
        if ($model->validate($input)) {

            $model->fill($input);
            $model->save();
            $this->saveNodes($model, 'product_category_id', $input);

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
                    $filterGroup->save();
                }

                $filterIds[] = $filterGroup->id;

                $this->saveNodes($filterGroup, 'filter_group_id', $filterData);
            }

            FilterGroup::where('product_category_id', '=', $model->id)->whereNotIn('id', $filterIds)->delete();

            return true;
        }

        return false;
    }

    /**
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getTree()
    {
        $models = MainModel::where('id', '>', 0)->orderBy('lft', 'asc')->get();

        $ret = [
            '' => 'Главная категория',
        ];

        foreach ($models as $model) {
            $ret[$model->id] = $model->getNodeValue('title', 'ru');
        }

        return $ret;
    }

    public function getPlainTree()
    {
        $models = MainModel::where('id', '>', 0)->orderBy('lft', 'asc');

        return $models;
    }
}
