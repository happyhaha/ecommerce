<?php

namespace Ibec\Ecommerce\Database;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Ibec\Translation\HasNode;
use Ibec\Translation\Nodeable;

class Filter extends BaseModel implements Nodeable
{
    use HasNode;
    use MiscTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'filters';

    /**
     * Mass-assignable attributes
     *
     * @var array
     */
    protected $fillable = ['filter_group_id','sort_order'];

    /**
     * FQ Node class name
     * @return string
     */
    public function getNodeClass()
    {
        return 'Ibec\Ecommerce\Database\FilterNode';
    }

    /**
     * @see \Ibec\Ecommerce\Database\BaseModel::attributeHints()
     * @return array
     */
    public static function attributeHints()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок фильтра который будет отображаться на сайте',
        ];
    }

    public function scopeItemsCount($query)
    {
        $query->leftJoin('filter_product', 'filters.id', '=', 'filter_product.filter_id')
        ->selectRaw('filters.*, count(filter_product.product_id) as product_count')
        ->groupBy('filters.id');
    }

}
