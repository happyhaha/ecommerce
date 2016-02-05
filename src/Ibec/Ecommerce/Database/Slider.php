<?php

namespace Ibec\Ecommerce\Database;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Ibec\Media\HasImage;
use Ibec\Media\HasFile;

class Slider extends BaseModel
{
    use MiscTrait;
    use HasImage, HasFile;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ecommerce_sliders';

    /**
     * Mass-assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'model_id',
        'model_type',
        'status',
    ];

    protected function getRules()
    {
        return [];
    }

    protected function getRulesMessages()
    {
        return [];
    }
}
