<?php

namespace Ibec\Ecommerce\Http\Controllers;

use Ibec\Admin\Services\Document\Document;
use Illuminate\Contracts\Auth\Guard;
use Ibec\Ecommerce\FilterRepository;

class FiltersController extends BaseController
{

    protected $codename = 'filters';

    public function __construct(Document $document, Guard $auth, FilterRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct($document, $auth);
    }
}
