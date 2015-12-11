<?php

namespace Ibec\Ecommerce\Database;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Ibec\Translation\HasNode;
use Ibec\Translation\Nodeable;

class Product extends BaseModel implements Nodeable
{
    use HasNode;
    use MiscTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * Mass-assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'product_brand_id',
        'slug',
        'article_number',
        'price',
        'price_new',
        'quantity',
        'type',
        'rating',
        'is_hot',
        'status',
    ];

    /**
     * FQ Node class name
     * @return string
     */
    public function getNodeClass()
    {
        return 'Ibec\Ecommerce\Database\ProductNode';
    }

    public static function getTypeList()
    {
        return [
            0 => 'Не выбрано',
            1 => 'Новинка',
            2 => 'Хит продаж',
            3 => 'Лучшая цена',
        ];
    }

    public function setParentIdAttribute($value)
    {
        $this->attributes['product_brand_id'] = $value ?: null;
    }

    public function categories()
    {
        return $this->belongsToMany(
            'Ibec\Ecommerce\Database\ProductCategory',
            'product_product_category',
            'product_id',
            'product_category_id'
        );
    }

    public function filters()
    {
        return $this->belongsToMany(
            'Ibec\Ecommerce\Database\Filter',
            'filter_product',
            'product_id',
            'filter_id'
        );
    }

}
