<?php

namespace Ibec\Ecommerce;

use Ibec\Ecommerce\Database\Product as MainModel;
use Ibec\Ecommerce\Database\ProductBrand;
use Ibec\Ecommerce\Database\Filter;

/**
 * ProductsRepository - класс репозитория для всех запросов моделей на стороне контроллера админки
 */
class ProductRepository extends BaseRepository
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

    public function save(&$model, $input)
    {
        $mainData = array_get($input, 'Product', []);
        if ($model->validate($mainData)) {
//            dd($_POST);
            $model->fill($input);
            $model->save();
            $this->saveNodes($model, 'product_id', $mainData);

            // Привязываем категории
            $categoryIds = [];
            $catsData = array_get($input, 'ProductCategories', []);
            foreach ($catsData as $cat) {
                if ($cat['checked']==1) {
                    $categoryIds[] = $cat['id'];
                }
            }
            if ($categoryIds) {
                $model->categories()->sync($categoryIds);
            } else {
                $model->categories()->detach();
            }

            // Привязываем фильтры
            $filterIds = [];
            $categoryFilters = array_get($input, 'Filter', []);
            foreach ($categoryFilters as $filterGroup) {
                if ($filterGroup) {
                    foreach ($filterGroup as $filterRow) {
                        if (isset($filterRow['value']) && trim($filterRow['value'])!='') {
                            $filterValue = trim($filterRow['value']);
                            $groupId = $filterRow['group_id'];

                            // Ищем существующий фильтр
                            $checkFilter = Filter::whereHas('nodes', function ($query) use ($filterValue) {
                                $query->where('title', '=', $filterValue);
                            })->where('filter_group_id', '=', $groupId)->first();

                            if (!$checkFilter) {
                                $checkFilter = new Filter();
                                $checkFilter->filter_group_id = $groupId;
                                $checkFilter->save();

                                $this->saveNodes($checkFilter, 'filter_id', [
                                    'ru' => ['title' => (string)$filterValue],
                                ]);
                            }
                            $filterIds[] = $checkFilter->id;
                        }
                    }
                }
            }

            if ($filterIds) {
                $model->filters()->sync($filterIds);
            } else {
                $model->filters()->detach();
            }

            return true;
        }

        return false;
    }

    public function getBrandList()
    {
        $models = ProductBrand::all();
        $ret = [];
        foreach ($models as $model) {
            $ret[$model->id] = $model->getNodeValue('title', 'ru');
        }

        return $ret;
    }
}
