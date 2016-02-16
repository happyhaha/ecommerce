<?php

namespace Ibec\Ecommerce;

use Ibec\Ecommerce\Database\Order as MainModel;
use Ibec\Ecommerce\Database\OrderItem;

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

            $orderItems = array_get($input, 'OrderItem', []);
            $itemIds = [0];
            foreach ($orderItems as $row) {
                $orderItem = OrderItem::query()->where('product_id', $row['product_id'])
                    ->where('order_id', $model->id)
                    ->first();
                if (!$orderItem) {
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $model->id;
                }

                $orderItem->fill($row);
                $orderItem->save();
                $itemIds[] = $orderItem->id;
            }

            OrderItem::query()
                ->where('order_id', $model->id)
                ->whereNotIn('id', $itemIds)
                ->delete();


            return true;
        }

        return false;
    }
}
