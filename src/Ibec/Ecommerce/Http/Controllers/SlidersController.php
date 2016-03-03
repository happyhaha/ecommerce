<?php

namespace Ibec\Ecommerce\Http\Controllers;

use Ibec\Admin\Services\Document\Document;
use Illuminate\Contracts\Auth\Guard;
use Ibec\Ecommerce\SliderRepository;
use \Request;

class SlidersController extends BaseController
{
    protected $codename = 'sliders';

    public function __construct(
        Document $document,
        Guard $auth,
        SliderRepository $repository
    ) {
        $this->repository = $repository;

        parent::__construct($document, $auth);
    }

    public function getModulesList()
    {
        return [
            ['id' => 'MainPage', 'static' => true, 'title' => 'Главная страница'],
            [
                'id' => \Ibec\Ecommerce\Database\ProductCategory::class,
                'static' => false,
                'title' => 'Категории',
                'queryCallback' => function ($q) {
                    $q->orderBy('lft', 'asc');
                }
            ],
        ];
    }

    public function getInfo(Request $request)
    {
        $ret = [];

        if (isset($_GET['id'])) {
            $ret['id'] = $_GET['id'];
            $model = $this->repository->findByPk((int)$_GET['id']);
            $ret['model_type'] = $model->model_type;
            $ret['model_id'] = $model->model_id;
        }
        /*
         * Список модулей для формы слайдера.
         * static - означает что это не модель и не нужно подгружать список записей,
         * если static false, при выборе этого модуля в дропдауне, будет сделан запрос на получение списка записей
         */
        $modulesList = $this->getModulesList();
        $ret['items'] = [];
        foreach ($modulesList as $module) {
            $ret['items'][] = [
                'id' => $module['id'],
                'title' => $module['title'],
                'static' => $module['static']
            ];
        }

        return $ret;
    }

    public function getModelItems(Request $request)
    {
        $ret = [
            'model_items' => [],
        ];

        $items = $this->getModulesList();
        $modelRequest = $_GET['model_type'];
        if ($modelRequest) {
            foreach ($items as $item) {
                if ($item['id'] == $modelRequest && $item['static'] == false) {
                    $arr = [];
                    $query = $modelRequest::query();
                    if (isset($item['queryCallback']) && is_callable($item['queryCallback'])) {
                        call_user_func($item['queryCallback'], $query);
                    }
                    $rows = $query->get();
                    foreach ($rows as $row) {
                        $ret['model_items'][] = [
                            'id' => $row->id,
                            'title' => $row->node->title
                        ];
                    }
                }
            }

        }

        return $ret;
    }

    public function setBackground(Request $request)
    {

    }
}
