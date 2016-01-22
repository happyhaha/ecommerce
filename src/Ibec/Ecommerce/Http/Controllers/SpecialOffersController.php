<?php

namespace Ibec\Ecommerce\Http\Controllers;

use Ibec\Admin\Services\Document\Document;
use Illuminate\Contracts\Auth\Guard;
use Response;
use Illuminate\Http\Request;
use Ibec\Ecommerce\SpecialOfferRepository;

class SpecialOffersController extends BaseController
{
    protected $codename = 'special-offers';

    public function __construct(Document $document, Guard $auth, SpecialOfferRepository $repository)
    {
        $this->repository = $repository;

        parent::__construct($document, $auth);
    }
}
