<?php

namespace Ibec\Ecommerce\Http\Controllers;

use App\Models\Product;
use Ibec\Admin\Services\Document\Document;
use Ibec\Ecommerce\Database\Filter;
use Illuminate\Contracts\Auth\Guard;
use Response;
use Illuminate\Http\Request;
use Ibec\Ecommerce\ProductCategoryRepository;
use Ibec\Ecommerce\Database\ProductCategory;
use DB;
use App\Models\Tag;

class ProductCategoriesController extends BaseController //temporary BaseController
{

    protected $codename = 'product-categories';

    public function __construct(Document $document, Guard $auth, ProductCategoryRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct($document, $auth);
    }

    //перезаписанный метод, для того чтобы изменить вью именно модуля Категорий(index)

    public function index(Request $request)
    {
        $this->document->breadcrumbs([
            trans('ecommerce::default.'.$this->codename.'.index') => '',
        ]);

        $this->document->page->title(' > '.trans('ecommerce::default.'.$this->codename.'.index'));

        $items = ProductCategory::all()->toHierarchy();


        return view('ecommerce::'.$this->codename.'.index',[
            'items' => $items,
            'codename' => $this->codename,
            ]);
    }
    public function getTags(Request $request)
    {
        $id = $request->get('id');
        $ret['id'] = $id;
        $model = $this->repository->findByPk($id);

        if ($model) {
            $tags = $model->tags;
            $ret['filters'] = $tags;
        }

        return $ret;
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
        else
        {
                $filters = [];

                $filter->id = 1000;
                $filter->type = 3;
                $filter->postfix = "KZT";
                $filter->status = 1;
                $filter->position = 1000;
                $ret['filters'] = $this->compactFilters();
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
                    'position' => (string) $filter->position
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

        // Product::
        $id = $request->get('id');
        $model = $this->repository->findByPk($id);
        $ret = [];
        $parentFilters = $model->parentFiltersAndSelf();
        $ret['parent_filters'] = $this->compactFilters($parentFilters);

        return $ret;
    }

    public function putTree(Request $request)
    {
        $tree = $request->input('tree', []);

        ProductCategory::buildTree($tree);

        return ['status' => 'success'];
    }
}
