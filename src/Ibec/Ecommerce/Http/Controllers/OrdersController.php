<?php

namespace Ibec\Ecommerce\Http\Controllers;

use Ibec\Admin\Services\Document\Document;
use Illuminate\Contracts\Auth\Guard;
use Ibec\Ecommerce\OrderRepository;
use Ibec\Ecommerce\ProductRepository;
use Illuminate\Http\Request;
use Ibec\Acl\User;

class OrdersController extends BaseController
{
    protected $codename = 'orders';

    protected $productRepository = null;

    public function __construct(
        Document $document,
        Guard $auth,
        OrderRepository $repository,
        ProductRepository $productRepository
    ) {
        $this->repository = $repository;
        $this->productRepository = $productRepository;

        parent::__construct($document, $auth);
    }

    public function getInfo(Request $request)
    {
        $ret = [
            'items' => []
        ];

        $ret['item_status_list'] = [
            '1' => 'Состоит в заказе',
            '2' => 'Отменен',
        ];

        if ($request->get('id')) {
            $ret['id'] = $request->get('id');
            $model = $this->repository->findByPk($request->get('id'));
            $orderItems = $model->orderItems;

            foreach ($orderItems as $item) {
                $pr = $item->product;
                $ret['items'][] = [
                    'id' => (int)$item->product_id,
                    'title' => ($pr)?$pr->node->title:'',
                    'count' => (int)$item->count,
                    'price' => (int)$item->price,
                    'status' => (string)$item->status,
                ];
            }

            $user = $model->user;
            if ($user) {
                $ret['user'] = [
                    'id' => $user->id,
                    'title' => $user->name.' ('.$user->email.')',
                ];
            }

        }
        return response()->json($ret);
    }

    public function autocomplete(Request $request)
    {
        $ret = [
            'items' => [],
        ];
        $searchQuery = $request->get('query');
        if ($searchQuery) {
            $builder = $this->productRepository->query();
            $builder->where(function ($q) use ($searchQuery) {
                if (is_numeric($searchQuery)) {
                    $q->whereHas('nodes', function ($q) use ($searchQuery) {
                        $q->where('title', 'like', '%'.$searchQuery.'%');
                    })->orWhere('id', $searchQuery);
                } else {
                    $q->whereHas('nodes', function ($q) use ($searchQuery) {
                        $q->where('title', 'like', '%'.$searchQuery.'%');
                    });
                }
            });

            $items = $builder->limit(15)->get();
            foreach ($items as $item) {
                $arr = [
                    'id' => $item->id,
                    'title' => $item->node->title,
                    'description' => '',
                    'price' => (int)$item->price,
                ];
                $ret['items'][] = $arr;
            }
        }
        return response()->json($ret);
    }

    public function userAutocomplete(Request $request)
    {
        $ret = [
            'items' => [],
        ];
        $searchQuery = $request->get('query');
        if ($searchQuery) {
            $builder = User::query();
            $builder->where(function ($q) use ($searchQuery) {
                $q->where('name', 'like', '%'.$searchQuery.'%')
                    ->orWhere('email', 'like', '%'.$searchQuery.'%')
                    ->orWhere('id', $searchQuery);
            });

            $items = $builder->limit(15)->get();
            foreach ($items as $item) {
                $arr = [
                    'id' => $item->id,
                    'title' => $item->name.' ('.$item->email.')',
                    'description' => '',
                ];
                $ret['items'][] = $arr;
            }
        }
        return response()->json($ret);
    }
}
