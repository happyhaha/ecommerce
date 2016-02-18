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


    public static function getPaymentTypeList()
    {
        return [
            0 => 'Оплата картой',
            1 => 'Оплата наличными',
        ];
    }

    public static function getDeliveryTypeList()
    {
        return [
            0 => 'Доставка курьером',
            1 => 'Самовывоз',
        ];
    }

    public static function getStatusList()
    {
        return [
            0 => 'Новый',
            5 => 'Принят',
            10 => 'В обработке',
            15 => 'В доставке',
            20 => 'Доставлен',
        ];
    }

    public static function getPaymentStatusList()
    {
        return [
            0 => 'Не оплачено',
            1 => 'Оплачено',
        ];
    }

    public function getOrderStatus()
    {
        $list = self::getStatusList();
        return $list[$this->status];
    }

    public function getOrderPaymentStatus()
    {
        $list = self::getPaymentStatusList();
        return $list[$this->payment_status];
    }

    public function getOrderPaymentType()
    {
        $list = self::getPaymentTypeList();
        return $list[$this->payment_type];
    }

    public function getOrderDeliveryType()
    {
        $list = self::getDeliveryTypeList();
        return $list[$this->delivery_type];
    }

}
