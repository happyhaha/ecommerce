<?php

namespace Ibec\Ecommerce\Database;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Ibec\Translation\HasNode;
use Ibec\Translation\Nodeable;
use Ibec\Media\HasImage;
use Ibec\Media\HasFile;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class ProductBrand extends BaseModel implements Nodeable, SluggableInterface
{
    use HasNode, MiscTrait, HasImage, HasFile;
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'node.title',
        'save_to'    => 'slug',
        'separator'       => '-',
        'unique'          => true,
        'on_update'       => true,
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_brands';

    /**
     * Mass-assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'slug'
    ];

    protected function getRules()
    {
        return [
            'ru.title' => 'required',
        ];
    }

    /**
     * FQ Node class name
     * @return string
     */
    public function getNodeClass()
    {
        return 'Ibec\Ecommerce\Database\ProductBrandNode';
    }
}
