<?php

namespace Ibec\Ecommerce\Database;

use Baum\Node as BaseModel;
use Ibec\Translation\HasNode;
use Ibec\Translation\Nodeable;
use Ibec\Ecommerce\Database\SpecialOffer;
use Ibec\Media\HasImage;
use Ibec\Media\HasFile;
use \DB;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class ProductCategory extends BaseModel implements Nodeable, SluggableInterface
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

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_categories';

    /**
     * Mass-assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'slug',
        'status'
    ];

    /**
     * FQ Node class name
     * @return string
     */
    public function getNodeClass()
    {
        return 'Ibec\Ecommerce\Database\ProductCategoryNode';
    }

    public function filters()
    {
        return $this->hasMany('Ibec\Ecommerce\Database\FilterGroup')->orderBy('position', 'asc');
    }

    public function products()
    {
        return $this->belongsToMany(
            'Ibec\Ecommerce\Database\Product',
            'product_product_category',
            'product_category_id',
            'product_id'
        );
    }


    public function setParentIdAttribute($value)
    {
        $this->attributes['parent_id'] = $value ?: null;
    }

    public function parentFilters()
    {
        $ancestors = $this->ancestors()->with(['filters'])->get();
        $filters = null;
        foreach ($ancestors as $ancestor) {
            if ($filters === null) {
                $filters = $ancestor->filters;
            } else {
                $filters = $filters->merge($ancestor->filters);
            }
        }
        return $filters;
    }

    public function parentFiltersAndSelf()
    {
        //формирование массива с фильтрами
        //если продукт НЕ имеет фильтра, то он не будет отображен

        $filters = $this->filters;

        $parentFilters = $this->parentFilters();
        if (is_array($parentFilters)) {
            $filters = $filters->merge($parentFilters);
        }

        return $filters;
    }

    public function getFilters($items)
    {
        //формирование массива с фильтрами
        //если продукт НЕ имеет фильтра, то он не будет отображен
        $filters = [];
        foreach ($items->items() as $item) {
            foreach ($item->filters as $filter) {
                $filters[] = $filter->filter_group;
            }
        }

        $filters = array_unique($filters);
        $parentFilters = $this->parentFilters();
        if (is_array($parentFilters)) {
//            $filters = $filters->merge($parentFilters);
            $filters = array_merge($filters,$parentFilters);
        }

        return $filters;
    }

    public function makeTree($nodeList)
    {
        $mapper = new SortedMapper($this);
        return $mapper->map($nodeList);
    }
}
