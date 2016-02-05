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

    public function save(&$model, $mainData)
    {
        $input = array_get($mainData, 'ProductBrand', []);
        if ($model->validate($input)) {
            $model->fill($input);
            if (!$model->exists) {
                $model->slug = $model->createSlug($input['ru']['title']);
            }
            $model->save();

            $this->saveNodes($model, 'product_brand_id', $input);

            if ($this->hasImages($model)) {
                $this->saveImage($model, $mainData);
            }

            return true;
        }

        return false;
    }
}
