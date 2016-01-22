<?php

namespace Ibec\Ecommerce\Database;

use Illuminate\Database\Eloquent\Model as BaseModel;

class OrderItem extends BaseModel
{
    use MiscTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_items';

    /**
     * Mass-assignable attributes
     *
     * @var array
     */

    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'count',
        'status',
    ];
}
