<?php

namespace Ibec\Ecommerce\Http\Controllers;

use Ibec\Admin\Services\Document\Document;
use Illuminate\Contracts\Auth\Guard;
use Response;
use Illuminate\Http\Request;
use Ibec\Ecommerce\ProductRepository;
use Ibec\Ecommerce\ProductCategoryRepository;
use Ibec\Ecommerce\ProductSectorRepository;
use Ibec\Ecommerce\SpecialOfferRepository;
use DB;

class ProductsController extends BaseController
{
    protected $codename = 'products';

    protected $categoryRepository;
    protected $sectorRepository;
    protected $specialRepository;

    public function __construct(
        Document $document,
        Guard $auth,
        ProductRepository $repository,
        ProductCategoryRepository $catRepository,
        ProductSectorRepository $sectorRepository,
        SpecialOfferRepository $specialRepository
    ) {
        $this->repository = $repository;
        $this->categoryRepository = $catRepository;
        $this->sectorRepository = $sectorRepository;
        $this->specialRepository = $specialRepository;

        parent::__construct($document, $auth);
    }

    public function getInfo(Request $request)
    {
        $ret = [];
        $ret['categories'] = [];

        $existingCats = [];
        $filterValues = [];
        $existingSectors = [];
        $existingSpecials = [];

        if ($request->get('id')) {
            // 2 запроса в БД
            $model = $this->repository->findByPk($request->get('id'));

            // 2 запроса в БД: Собираем выбранные категории
            $cats = $model->categories;
            foreach ($cats as $cat) {
                $existingCats[$cat->id] = $cat;
            }

            // 2 запроса в БД: Собираем выбранные, заполненные фильтры для данного товара
            $filters = $model->filters;
            foreach ($filters as $filter) {
                $filterValues[(string)$filter->filter_group_id] = $filter->getNodeValue('title', 'ru');
            }
            if ($filterValues) {
                $ret['filter_values'] = $filterValues;
            }

            $productSectors = $model->sectors;
            foreach ($productSectors as $sector) {
                $existingSectors[$sector->id] = $sector;
            }

            $productSpecials = $model->specialOffers;
            foreach ($productSpecials as $special) {
                $existingSpecials[$special->id] = $special;
            }
        }

        $categoriesBuilder = $this->categoryRepository->getPlainTree();

        // 4 запроса в БД: 2 запроса за категориями, 2 за группами фильтров;
        $categories = $categoriesBuilder->with(['filters', 'filters.filters'])->get();
        // 1 запрос в БД
        $filtersStat = $this->repository->getFiltersStat();

        $categoryGroupsList = [];

        foreach ($categories as $cat) {
            $filtersArr = [];
            // Достаем группы фильтров присвоенные к данной категории
            // $filterGroups = $cat->parentFiltersAndSelf();
            $filterGroups = $cat->filters;
            if ($cat->parent_id && $categoryGroupsList[$cat->parent_id]) {
                $filterGroups = $categoryGroupsList[$cat->parent_id]->merge($filterGroups);
            }
            $categoryGroupsList[$cat->id] = $filterGroups;
            foreach ($filterGroups as $filterGroup) {
                $groupArr = [
                    'group_id' => (string)$filterGroup->id,
                    'type' => (string)$filterGroup->type,
                    'postfix' => (string)$filterGroup->postfix,
                    'title' => (string)$filterGroup->getNodeValue('title', 'ru'),
                    'available_values' => [],
                ];

                // Собираем возможные варианты значений для данной группы фильтров
                foreach ($filterGroup->filters as $filterItem) {
                    $productCount = (isset($filtersStat[$filterItem->id])?$filtersStat[$filterItem->id]:0);
                    $groupArr['available_values'][] = [
                        'id' => $filterItem->id,
                        'full_title' => $filterItem->getNodeValue('title', 'ru'). ' ( '.(int)$productCount.' )',
                        'title' => $filterItem->getNodeValue('title', 'ru'),
                        'count' => $productCount,
                    ];
                }

                $filtersArr[] = $groupArr;
            }
            $categoryTitle = (string)$cat->getNodeValue('title', 'ru');
            $arr = [
                'id' => (string)$cat->id,
                'parent_id' => (string)$cat->parent_id,
                'title' => $categoryTitle,
                'depth' => (int)$cat->depth,
                'filters' => $filtersArr,
                'checked' => (isset($existingCats[$cat->id])?'1':'0')
            ];
            $ret['categories'][] = $arr;
        }

        $sectors = $this->sectorRepository->all(['limit'=>1000]);
        $ret['sectors'] = [];
        foreach ($sectors as $sector) {
            $ret['sectors'][] = [
                'id' => (string)$sector->id,
                'title' => (string)$sector->getNodeValue('title', 'ru'),
                'checked' => (isset($existingSectors[$sector->id])?'1':'0')
            ];
        }

        $specials = $this->specialRepository->all(['limit'=>1000]);
        $ret['specials'] = [];
        foreach ($specials as $special) {
            $ret['specials'][] = [
                'id' => (string)$special->id,
                'title' => (string)$special->getNodeValue('title', 'ru'),
                'checked' => (isset($existingSpecials[$special->id])?'1':'0')
            ];
        }

        return $ret;
    }

    public function getRelatedProducts(Request $request)
    {
        $input = $request->input('term');

        $query = '
        SELECT product_nodes.product_id as id, CONCAT(product_nodes.title, \', №\', products.article_number) AS label, products.article_number as value FROM product_nodes
        JOIN products ON products.id = product_nodes.product_id
        WHERE product_nodes.title LIKE \'%'.$input.'%\' OR products.article_number LIKE \'%'.$input.'%\' ORDER BY product_nodes.title, products.article_number';
        $res = DB::select($query);


        return json_encode($res);
    }

    public function relatedProducts(Request $request)
    {
        $query = '
        SELECT products.id as id, CONCAT(product_nodes.title, \', №\', products.article_number) AS label, products.article_number as value FROM product_nodes
        JOIN products ON products.id = product_nodes.product_id
        WHERE products.id IN (SELECT product_related.related_product_id FROM product_related
            JOIN products ON products.id = product_related.product_id
            WHERE product_related.product_id = '.$_POST['id'].')';

        return json_encode(DB::select($query));
    }
}
