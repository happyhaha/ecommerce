<?php

namespace Ibec\Ecommerce\Database;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Order extends BaseModel
{
    use MiscTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

    protected $dates = ['created_at', 'updated_at'];

    /**
     * Mass-assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'payment_type',
        'delivery_type',
        'delivery_price',
        'city',
        'address',
        'comment',
        // 'total_price',
        'payment_status',
        'status',
    ];

    public function user()
    {
        return $this->hasOne('Ibec\Acl\User', 'id', 'user_id');
    }

    public function orderItems()
    {
        return $this->hasMany('Ibec\Ecommerce\Database\OrderItem', 'order_id');
    }

    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = $value ?: null;
    }


    public function getPaymentTypeList()
    {
        return [
            0 => 'Оплата картой',
            1 => 'Оплата наличными',
        ];
    }

    public function getDeliveryTypeList()
    {
        return [
            0 => 'Доставка курьером',
            1 => 'Самовывоз',
        ];
    }

    public function getStatusList()
    {
        return [
            0 => 'Новый',
            5 => 'Принят',
            10 => 'В обработке',
            15 => 'В доставке',
            20 => 'Доставлен',
        ];
    }

    public function getPaymentStatusList()
    {
        return [
            0 => 'Не оплачено',
            1 => 'Оплачено',
        ];
    }
}
