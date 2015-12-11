<?php

namespace Ibec\Ecommerce\Http\Controllers;

use Ibec\Admin\Services\Document\Document;
use Illuminate\Contracts\Auth\Guard;
use Response;
use Illuminate\Http\Request;
use Ibec\Ecommerce\ProductRepository;
use Ibec\Ecommerce\ProductCategoryRepository;

class ProductsController extends BaseController
{
    protected $codename = 'products';

    protected $categoryRepository;

    public function __construct(Document $document, Guard $auth, ProductRepository $repository, ProductCategoryRepository $catRepository)
    {
        $this->repository = $repository;
        $this->categoryRepository = $catRepository;

        parent::__construct($document, $auth);
    }

    public function getInfo(Request $request)
    {
        $ret = [];
        $ret['categories'] = [];
        $categoriesBuilder = $this->categoryRepository->getPlainTree();
        $categories = $categoriesBuilder->with(['filters'])->get();

        $existingCats = [];
        $filterValues = [];

        if ($request->get('id')) {
            $model = $this->repository->findByPk($request->get('id'));

            // Собираем выбранные категории
            $cats = $model->categories;
            foreach ($cats as $cat) {
                $existingCats[$cat->id] = $cat;
            }

            // Собираем выбранные, заполненные фильтры для данного товара
            $filters = $model->filters;
            foreach ($filters as $filter) {
                $filterValues[(string)$filter->filter_group_id] = $filter->getNodeValue('title', 'ru');
            }

            if ($filterValues) {
                $ret['filter_values'] = $filterValues;
            }
        }

        foreach ($categories as $cat) {
            $filtersArr = [];
            // Достаем группы фильтров присвоенные к данной категории
            $filterGroups = $cat->parentFiltersAndSelf();
            foreach ($filterGroups as $filterGroup) {
                $groupArr = [
                    'group_id' => (string)$filterGroup->id,
                    'type' => (string)$filterGroup->type,
                    'postfix' => (string)$filterGroup->postfix,
                    'title' => (string)$filterGroup->getNodeValue('title', 'ru'),
                    'available_values' => [],
                ];

                // Собираем возможные варианты значений для данной группы фильтров
                $groupItems = $filterGroup->filters()->with(['nodes'])->itemsCount()->get();
                foreach ($groupItems as $filterItem) {
                    $groupArr['available_values'][] = [
                        'id' => $filterItem->id,
                        'full_title' => $filterItem->getNodeValue('title', 'ru'). ' ( '.(int)$filterItem->product_count.' )',
                        'title' => $filterItem->getNodeValue('title', 'ru'),
                        'count' => $filterItem->product_count,
                    ];
                }


                $filtersArr[] = $groupArr;
            }
            $categoryTitle = str_repeat('', $cat->depth);
            $categoryTitle .= (string)$cat->getNodeValue('title', 'ru');
            $arr = [
                'id' => (string)$cat->id,
                'title' => $categoryTitle,
                'depth' => (int)$cat->depth,
                'filters' => $filtersArr,
                'checked' => (isset($existingCats[$cat->id])?'1':'0')
            ];
            $ret['categories'][] = $arr;
        }

        return $ret;
    }
}
