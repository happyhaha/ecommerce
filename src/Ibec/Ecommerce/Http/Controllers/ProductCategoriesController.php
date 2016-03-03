<?php

namespace Ibec\Ecommerce\Http\Controllers;

use App\Models\Product;
use Ibec\Admin\Services\Document\Document;
use Illuminate\Contracts\Auth\Guard;
use Response;
use Illuminate\Http\Request;
use Ibec\Ecommerce\ProductCategoryRepository;

class ProductCategoriesController extends BaseController
{

    protected $codename = 'product-categories';

    public function __construct(Document $document, Guard $auth, ProductCategoryRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct($document, $auth);
    }

    public function getFilters(Request $request)
    {
        $id = $request->get('id');
        $parentId = $request->get('parent_id');

        $ret['id'] = $id;
        $ret['parent_id'] = $parentId;

        $model = $this->repository->findByPk($id);

        if ($model) {
            $filters = $model->filters;
            $ret['filters'] = $this->compactFilters($filters);
            $parentFilters = $model->parentFilters();
            $ret['parent_filters'] = $this->compactFilters($parentFilters);
        }

        return $ret;
    }

    protected function compactFilters($filters = [])
    {
        $ret = [];
        if ($filters) {
            foreach ($filters as $filter) {
                $nodes = $filter->nodes;
                $arr = [
                    'id' => (string)$filter->id,
                    'type' => (string)$filter->type,
                    'postfix' => (string)$filter->postfix,
                    'status' => (string)($filter->status?$filter->status:0),
                ];
                foreach (config('app.locales') as $locale) {
                    $node = array_get($nodes, $locale, null);
                    if ($node) {
                        $arr[$locale] = ['title' => $node->title];
                    }
                }
                $ret[] = $arr;
            }
        }

        return $ret;
    }


    public function getParentFilters(Request $request)
    {

        Product::
        $id = $request->get('id');
        $model = $this->repository->findByPk($id);
        $ret = [];
        $parentFilters = $model->parentFiltersAndSelf();
        $ret['parent_filters'] = $this->compactFilters($parentFilters);

        return $ret;
    }
}
