<?php

namespace Ibec\Ecommerce\Http\Controllers;

use Ibec\Admin\Services\Document\Document;
use Illuminate\Contracts\Auth\Guard;
use Response;
use Illuminate\Http\Request;
use Ibec\Ecommerce\ProductBrandRepository;

class ProductBrandsController extends BaseController
{
    protected $codename = 'product-brands';

    public function __construct(Document $document, Guard $auth, ProductBrandRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct($document, $auth);
    }
}
