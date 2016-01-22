<?php

namespace Ibec\Ecommerce\Database;

use Illuminate\Database\Eloquent\Model as BaseModel;

class BannerLocation extends BaseModel
{
    use MiscTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'banners';

    /**
     * Mass-assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'banner_id',
        'location',
    ];
}
