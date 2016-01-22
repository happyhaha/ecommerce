<?php

namespace Ibec\Ecommerce\Database;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Ibec\Translation\HasNode;
use Ibec\Translation\Nodeable;

class SpecialOffer extends BaseModel implements Nodeable
{
    use HasNode;
    use MiscTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'special_offers';

    /**
     * Mass-assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'status',
    ];

    /**
     * FQ Node class name
     * @return string
     */
    public function getNodeClass()
    {
        return 'Ibec\Ecommerce\Database\SpecialOfferNode';
    }
}
