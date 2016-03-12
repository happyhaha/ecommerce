<?php

namespace Ibec\Ecommerce\Database;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Ibec\Translation\HasNode;
use Ibec\Translation\Nodeable;
use Ibec\Media\HasImage;
use Ibec\Media\HasFile;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Product extends BaseModel implements Nodeable, SluggableInterface
{
    use HasNode;
    use MiscTrait;
    use SluggableTrait;
    use HasImage, HasFile;

    protected $sluggable = [
        'build_from' => 'node.title',
        'save_to'    => 'slug',
//        'max_length'      => null,
//        'method'          => null,
        'separator'       => '-',
        'unique'          => true,
//        'include_trashed' => false,
        'on_update'       => true,
//        'reserved'        => null,
    ];

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

    protected function getRules()
    {
        return [
            'ru.title' => 'required',
        ];
    }

    protected function getRulesMessages()
    {
        return [
            'ru.title.required' => 'Заголовок на русском обязательное поле к заполнению',
        ];
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

    public function setProductBrandIdAttribute($value)
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

    public function tags()
    {
        return $this->belongsToMany(
            'App\Models\Tag',
            'tag_product',
            'product_id',
            'tag_id'
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

    public function sectors()
    {
        return $this->belongsToMany(
            'Ibec\Ecommerce\Database\ProductSector',
            'product_product_sector',
            'product_id',
            'product_sector_id'
        );
    }

    public function specialOffers()
    {
        return $this->belongsToMany(
            'Ibec\Ecommerce\Database\SpecialOffer',
            'product_special_offer',
            'product_id',
            'special_offer_id'
        );
    }
}
