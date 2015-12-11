<?php

namespace Ibec\Ecommerce\Database;

use Ibec\Translation\LanguageDependent;
use Illuminate\Database\Eloquent\Model;

class FilterGroupNode extends Model
{

    use LanguageDependent;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'filter_group_nodes';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'filter_group_id';

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
    protected $fillable = ['title', 'language_id'];
}
