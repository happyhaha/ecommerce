<?php

namespace Ibec\Ecommerce\Database;

use Ibec\Translation\LanguageDependent;
use Illuminate\Database\Eloquent\Model;

class ProductSectorNode extends Model
{

    use LanguageDependent;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_sector_nodes';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'product_sector_id';

    /**
     * Indicates if the IDs are not auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'language_id',
        'content',
        'seo_description',
        'seo_title',
        'seo_keywords'
    ];
}
