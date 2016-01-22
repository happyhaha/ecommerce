<?php

namespace Ibec\Ecommerce\Http\Controllers;

use Ibec\Admin\Services\Document\Document;
use Illuminate\Contracts\Auth\Guard;
use Ibec\Ecommerce\BannerRepository;

class BannersController extends BaseController
{
    protected $codename = 'banners';

    public function __construct(
        Document $document,
        Guard $auth,
        BannerRepository $repository
    ) {
        $this->repository = $repository;

        parent::__construct($document, $auth);
    }

}
