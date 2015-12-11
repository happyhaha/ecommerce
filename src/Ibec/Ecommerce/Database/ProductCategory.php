<?php

namespace Ibec\Ecommerce\Database;

use Baum\Node as BaseModel;
use Ibec\Translation\HasNode;
use Ibec\Translation\Nodeable;

class ProductCategory extends BaseModel implements Nodeable
{
    use HasNode;
    use MiscTrait;

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
    protected $fillable = ['parent_id'];

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
        return $this->hasMany('Ibec\Ecommerce\Database\FilterGroup');
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
        $filters = $this->filters;
        $parentFilters = $this->parentFilters();
        if ($parentFilters) {
            $filters = $filters->merge($parentFilters);
        }
        return $filters;
    }

    public function makeTree($nodeList)
    {
        $mapper = new SortedMapper($this);
        return $mapper->map($nodeList);
    }
}
