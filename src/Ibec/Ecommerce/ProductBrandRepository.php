<?php

namespace Ibec\Ecommerce;

use Ibec\Ecommerce\Database\ProductBrand as MainModel;

/**
 * ProductBrandRepository - класс репозитория для всех запросов моделей на стороне контроллера админки
 */
class ProductBrandRepository extends BaseRepository
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
        $input = array_get($input, 'ProductBrand', []);
        if ($model->validate($input)) {

            // $model->fill($input);
            $model->save();
            $this->saveNodes($model, 'product_brand_id', $input);

            return true;
        }

        return false;
    }
}
