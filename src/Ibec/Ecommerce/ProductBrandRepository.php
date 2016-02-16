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
        $mainData = array_get($input, 'ProductBrand', []);
        if ($model->validate($mainData)) {
            $model->fill($mainData);
            if (!$model->exists) {
                $model->slug = $model->createSlug($mainData['ru']['title']);
            }
            $model->save();

            $this->saveNodes($model, 'product_brand_id', $mainData);

            if ($this->hasImages($model)) {
                $this->saveImage($model, $input);
            }

            return true;
        }

        return false;
    }
}
