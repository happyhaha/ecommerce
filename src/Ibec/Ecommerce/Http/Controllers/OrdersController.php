<?php

namespace Ibec\Ecommerce\Http\Controllers;

use Ibec\Admin\Services\Document\Document;
use Illuminate\Contracts\Auth\Guard;
use Ibec\Ecommerce\OrderRepository;
use Symfony\Component\HttpFoundation\Request;

class OrdersController extends BaseController
{
    protected $codename = 'orders';

    public function __construct(
        Document $document,
        Guard $auth,
        OrderRepository $repository
    ) {
        $this->repository = $repository;

        parent::__construct($document, $auth);
    }

    public function getInfo(Request $request)
    {
        $ret = [
            'items' => []
        ];

        $ret['item_status_list'] = [
            '0' => 'Состоит в заказе',
            '1' => 'Отменен',
        ];

        if ($request->get('id')) {
            $ret['id'] = $request->get('id');
            $model = $this->repository->findByPk($request->get('id'));
        }
        return $ret;
    }
}
