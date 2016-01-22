<?php

namespace Ibec\Ecommerce\Http\Controllers;

use Ibec\Admin\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Input;
use Ibec\Media\File;
use Ibec\Media\Image;

abstract class BaseController extends Controller
{
    protected $codename;
    protected $repository;

    /*
        GET         /base              index       base.index
        GET         /base/create       create      base.create
        POST        /base              store       base.store
        GET         /base/{base}       show        base.show
        GET         /base/{base}/edit  edit        base.edit
        PUT/PATCH   /base/{base}       update      base.update
        DELETE      /base/{base}       destroy     base.destroy
     */

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->document->breadcrumbs([
            trans('ecommerce::default.'.$this->codename.'.index') => '',
        ]);

        $this->document->page->title(' > '.trans('ecommerce::default.'.$this->codename.'.index'));

        $items = $this->repository->all($request->all());

        return view('ecommerce::'.$this->codename.'.index', [
            'items' => $items,
            'codename' => $this->codename,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = $this->repository->getNew();

        $this->document->breadcrumbs([
            trans('ecommerce::default.'.$this->codename.'.index') => admin_route('ecommerce.'.$this->codename.'.index'),
            trans('ecommerce::default.'.$this->codename.'.create') => '',
        ]);

        $this->document->page->title(
            trans('ecommerce::default.'.$this->codename.'.index')
            .' > '
            .trans('ecommerce::default.'.$this->codename.'.create')
        );

        return view('ecommerce::'.$this->codename.'.form', [
            'model' => $model,
            'target' => 'ecommerce.'.$this->codename.'.store',
            'codename' => $this->codename,
            'repository' => $this->repository,
        ]);
    }

    /**
     * Зачастую не используется
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request    $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = $this->repository->getNew();

        $data = $request->all();

        if ($this->repository->save($model, $data)) {
            return redirect(admin_route('ecommerce.'.$this->codename.'.index'));
        } else {
            return redirect()->back()->withErrors($model->errors());
        }

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param integer     $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->repository->findByPk($id);

        $this->document->breadcrumbs([
            trans('ecommerce::default.'.$this->codename.'.index') => admin_route('ecommerce.'.$this->codename.'.index'),
            trans('ecommerce::default.'.$this->codename.'.edit') => '',
        ]);

        $this->document->page->title(
            trans('ecommerce::default.'.$this->codename.'.index')
            .' > '
            .trans('ecommerce::default.'.$this->codename.'.edit')
        );

        $hasImages = $this->repository->hasImages($model);
        $viewParams = [
            'model' => $model,
            'target' => 'ecommerce.'.$this->codename.'.update',
            'codename' => $this->codename,
            'repository' => $this->repository,
        ];
        if ($hasImages) {
            $mediaInfo = $this->getImageInfo($model);
            $viewParams = array_merge($viewParams, $mediaInfo);
        }
        return view('ecommerce::'.$this->codename.'.form', $viewParams);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param integer                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model = $this->repository->findByPk($id);
        $data = $request->all();

        if ($this->repository->save($model, $data)) {
            return redirect(admin_route('ecommerce.'.$this->codename.'.index'));
        } else {
            return redirect()->back()->withErrors($model->errors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        return redirect(admin_route('ecommerce.'.$this->codename.'.index'));
    }

    public function deleteBatch(Request $request, $action = null)
    {

        $ids = $request->input('selected', []);
        if ($ids) {
            $items = $this->repository->query()->whereIn('id', $ids)->get();
            //foreach ($items as $item) {
                //$item->images()->detach();
                //$item->tags()->detach();
                //$item->files()->detach();
            //}
            $this->repository->delete($ids);
        }
    }

    protected function getImageInfo($model)
    {
//        $files = $model->files->keyBy('pivot.field_slug');
        $files = [];

        $image = $model->images()->withPivot('title', 'alt', 'cropped_coords')->first();
        $cropped_coords = $image ?$image->pivot->cropped_coords :null;

        if (Input::old()) {
//            $fileInput = array_filter(Input::old('fields.files', []), 'strlen');
//            if ($fileInput) {
//                $files = [];
//                $collection = File::whereIn('id', $fileInput)->get()->keyBy('id');
//                foreach ($fileInput as $field_slug => $id) {
//                    $files [$field_slug] = $collection [$id];
//                }
//                $files = collect($files);
//            }

            $image = Image::where('id', Input::old('image_id'))->first();
            $cropped_coords = Input::old('cropped_coords');
        }

        return [
            'image' => $image,
            'files' => $files,
            'cropped_coords' => $cropped_coords
        ];
    }

}
