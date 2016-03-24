<?php

namespace Ibec\Ecommerce\Database;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Ibec\Translation\HasNode;
use Ibec\Translation\Nodeable;

class FilterGroup extends BaseModel implements Nodeable
{
    use HasNode;
    use MiscTrait;

    const TYPE_CHECKBOX = 1;
    const TYPE_DROPDOWN = 2;
    const TYPE_SLIDER = 3;

    protected function getRules()
    {
        return [
            'ru.title' => 'required',
        ];
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'filter_group';

    /**
     * Mass-assignable attributes
     *
     * @var array
     */
    protected $fillable = ['product_category_id', 'type', 'postfix', 'sort_order', 'status','position'];

    /**
     * FQ Node class name
     * @return string
     */
    public function getNodeClass()
    {
        return 'Ibec\Ecommerce\Database\FilterGroupNode';
    }

    public function filters()
    {
        return $this->hasMany('Ibec\Ecommerce\Database\Filter', 'filter_group_id');
    }

    public function getMinFilter()
    {
        $min = null;
        $ret = null;
        $filters = $this->filters;
        foreach ($filters as $filter) {
            if ($min===null || $min > (double)$filter->node->title) {
                $min = (double)$filter->node->title;
                $ret = $filter;
            }
        }

        return $ret;
    }

    public function getMaxFilter()
    {
        $max = null;
        $ret = null;
        $filters = $this->filters;
        foreach ($filters as $filter) {
            if ($max===null || $max < (double)$filter->node->title) {
                $max = (double)$filter->node->title;
                $ret = $filter;
            }
        }
        return $ret;
    }
}
