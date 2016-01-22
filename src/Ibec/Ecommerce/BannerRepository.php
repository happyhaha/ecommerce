<?php

namespace Ibec\Ecommerce;

use Ibec\Ecommerce\Database\Banner as MainModel;

/**
 * BannerRepository - класс репозитория для всех запросов моделей на стороне контроллера админки
 */
class BannerRepository extends BaseRepository
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
        $mainData = array_get($input, 'Banner', []);
        if ($model->validate($mainData)) {
            $model->fill($mainData);
            $model->save();

            if ($this->hasImages($model)) {
                $this->saveImage($model, $input);
            }

            return true;
        }

        return false;
    }
}
