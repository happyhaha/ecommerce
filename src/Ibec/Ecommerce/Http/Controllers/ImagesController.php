<?php

namespace Ibec\Ecommerce\Http\Controllers;

use Ibec\Admin\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Input;
use Ibec\Media\File;
use Ibec\Media\Image;

class ImagesController extends Controller
{
    public function index(Request $request)
    {
        $itemIds = $request->get('items', []);
        if (!is_array($itemIds)) {
            $itemIds = (array)$itemIds;
        }

        if ($itemIds) {
            $images = Image::query()->whereIn('id', $itemIds)->get();
        }

        $ajax = true;

        return view('ecommerce::_form.images', compact('images', 'ajax'));
    }
}
