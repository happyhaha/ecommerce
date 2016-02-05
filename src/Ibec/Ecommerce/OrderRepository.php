<?php

namespace Ibec\Ecommerce;

use Ibec\Ecommerce\Database\Order as MainModel;

/**
 * OrderRepository - класс репозитория для всех запросов моделей на стороне контроллера админки
 */
class OrderRepository extends BaseRepository
{

    /**
     * Перечисление атрибутов позволенных для фильтрации
     */
    public $paramRules = [
        'id' => '=',
    ];

    public function __construct(MainModel $model)
    {
        $this->modelName = get_class($model);
    }

    public function save(&$model, $input)
    {
        $mainData = array_get($input, 'Order', []);
        if ($model->validate($mainData)) {
            $model->fill($mainData);
            $model->save();

            return true;
        }

        return false;
    }
}