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

    public $timestamps = false;

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

    public function product()
    {
        return $this->hasOne('Ibec\Ecommerce\Database\Product', 'id', 'product_id');
    }

    public function order()
    {
        return $this->hasOne('Ibec\Ecommerce\Database\Order', 'id', 'order_id');
    }
}
