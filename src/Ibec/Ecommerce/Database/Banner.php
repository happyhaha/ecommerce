<?php

namespace Ibec\Ecommerce\Database;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Carbon\Carbon;
use Ibec\Media\HasImage;
use Ibec\Media\HasFile;

class Banner extends BaseModel
{
    use MiscTrait, HasFile, HasImage;


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

    protected $dates = ['created_at', 'updated_at', 'untill_at'];

    protected $fillable = [
        'name',
        'link',
        'is_blank',
        'width',
        'height',
        'code',
        'max_views',
        'current_views',
        'untill_at',
        'status',
    ];

    public function setUntillAtAttribute($value)
    {
        if ($value) {
            $this->attributes['untill_at'] = Carbon::createFromFormat('d/m/Y', $value);
        } else {
            $this->attributes['untill_at'] = null;
        }
    }
}
