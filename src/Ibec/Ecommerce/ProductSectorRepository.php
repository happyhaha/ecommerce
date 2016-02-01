<?php

namespace Ibec\Ecommerce;

use Ibec\Ecommerce\Database\ProductSector as MainModel;

/**
 * ProductSectorRepository - класс репозитория для всех запросов моделей на стороне контроллера админки
 */
class ProductSectorRepository extends BaseRepository
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
        $mainData = array_get($input, 'ProductSector', []);
        if ($model->validate($mainData)) {
            $model->fill($mainData);
            if (!$model->exists) {
                $model->slug = $model->createSlug($mainData['ru']['title']);
            }
            $model->save();
            $this->saveNodes($model, 'product_sector_id', $mainData);

            return true;
        }

        return false;
    }
}
