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


    public static $activeCategory;


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

    public function getProductFilters($count = 0)
    {
        $i = 0;
        $filters = [];
        foreach($this->filters as $filter)
        {
            if($filter->filter_group->status > 0)
            {
                while($i != $count)
                {
                    $filters[] = $filter;
                    $i++;
                }

            }
        }
        return $filters;

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


    public function brand()
    {
        return $this->belongsTo(ProductBrand::class, 'id');
    }


    public function getRecordUrl($abs = true)
    {
        if (self::$activeCategory) {
            $category = self::$activeCategory;
        } else {
            $cats = $this->categories;
            if ($cats) {
                $category = $cats->first();
            }
        }

        if ($category) {
            $rootCats = $category->ancestors()->get();
        }


        if (isset($rootCats) && $rootCats->count()) {
            $rootCategoryUrl = [];

            foreach ($rootCats as $root) {
                $rootCategoryUrl[] = $root->slug;
            }

            $rootCategoryUrl = implode('/', $rootCategoryUrl);
            $rootCategoryUrl .= '/';

            return route('catalog.show.nested', [
                'rootCategory' => $rootCategoryUrl,
                'product' => $this->slug,
                'category' => $category?$category->slug:'',
            ]);
        } else {
            return route('catalog.show', [
                'product' => $this->slug,
                'category' => $category?$category->slug:''
            ]);
        }
    }

    public static function getProductsCategories($items)
    {
        foreach ($items as $item) {
            if(!empty($item->categories[0]))
            {
                $resultArray[] = $item->categories[0]->id;
            }
        }

        if (!empty($resultArray)) {
            return \App\Models\ProductCategory::whereIn('id',array_unique($resultArray))->get();
        }
    }

    
}
