<?php

namespace Ibec\Ecommerce;

use Ibec\Ecommerce\Database\SpecialOffer as MainModel;

/**
 * SpecialOfferRepository - класс репозитория для всех запросов моделей на стороне контроллера админки
 */
class SpecialOfferRepository extends BaseRepository
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
        $mainData = array_get($input, 'SpecialOffer', []);
        if ($model->validate($mainData)) {
            $model->fill($mainData);
            $model->save();
            $this->saveNodes($model, 'special_offer_id', $mainData);

            return true;
        }

        return false;
    }
}
