<?php

namespace Ibec\Ecommerce\Database;

use Ibec\Translation\LanguageDependent;
use Illuminate\Database\Eloquent\Model;

class SpecialOfferNode extends Model
{

    use LanguageDependent;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'special_offer_nodes';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'special_offer_id';

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
        'language_id',
        'title',
        'content',
        'seo_description',
        'seo_title',
        'seo_keywords'
    ];
}
