<?php

namespace Ibec\Ecommerce;

use DB;
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
            $model->fill($mainData);
            if (!$model->exists) {
                $model->slug = $model->createSlug($mainData['ru']['title']);
            }
            $model->save();
            $this->saveNodes($model, 'product_id', $mainData);

            if ($this->hasImages($model)) {
                $this->saveImage($model, $input);
            }

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

            // Привязываем отрасли
            $sectorIds = [];
            $sectorData = array_get($input, 'ProductSector', []);
            foreach ($sectorData as $item) {
                if ($item['checked']==1) {
                    $sectorIds[] = $item['id'];
                }
            }
            if ($sectorIds) {
                $model->sectors()->sync($sectorIds);
            } else {
                $model->sectors()->detach();
            }

            // Привязываем акции
            $specialIds = [];
            $specialData = array_get($input, 'SpecialOffer', []);
            foreach ($specialData as $item) {
                if ($item['checked']==1) {
                    $specialIds[] = $item['id'];
                }
            }
            if ($specialIds) {
                $model->specialOffers()->sync($specialIds);
            } else {
                $model->specialOffers()->detach();
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

    public function getFiltersStat()
    {
        $stat = DB::table('filter_product')
            ->selectRaw('filter_product.filter_id, count(filter_product.product_id) as product_count')
            ->groupBy('filter_product.filter_id')->get();
        $ret = [];
        foreach ($stat as $row) {
            $ret[$row->filter_id] = $row->product_count;
        }

        return $ret;
    }
}
