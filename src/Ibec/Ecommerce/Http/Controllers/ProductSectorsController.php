<?php

namespace Ibec\Ecommerce\Http\Controllers;

use Ibec\Admin\Services\Document\Document;
use Illuminate\Contracts\Auth\Guard;
use Response;
use Illuminate\Http\Request;
use Ibec\Ecommerce\ProductSectorRepository;

class ProductSectorsController extends BaseController
{
    protected $codename = 'product-sectors';

    public function __construct(Document $document, Guard $auth, ProductSectorRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct($document, $auth);
    }
}
