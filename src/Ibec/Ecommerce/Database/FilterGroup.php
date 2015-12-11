<?php

namespace Ibec\Ecommerce\Database;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Ibec\Translation\HasNode;
use Ibec\Translation\Nodeable;

class FilterGroup extends BaseModel implements Nodeable
{
    use HasNode;
    use MiscTrait;

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
    protected $fillable = ['product_category_id','type','postfix','sort_order'];

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
}
