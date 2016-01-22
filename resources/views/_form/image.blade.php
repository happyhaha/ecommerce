<div class="">
    <div class="m-b-sm text-md">{{ trans('content::default.posts.image') }}</div>
    @if (isset($cropped_coords) && isset($image) && $cropped_coords)
        <img id="img" class="img-thumbnail img-responsive" src="{{ '/'.config('media.policies.uploads.images.src_path').'/'.$image->id.'?'.$cropped_coords}}"/>
    @else
        <img id="img" class="img-thumbnail img-responsive" src="{{isset($image)?$image->path:''}}"/>
    @endif
    <label style="{{ isset($image)?'':'display:none' }}" for="image_title" class="control-label image_title">{{ trans('content::default.posts.image_title') }}</label>
    {!! Form::text('image_title', isset($image)&&!Input::old()?$image->pivot->title:'', ['class' => 'form-control image_title','style' => isset($image)?'':'display:none']) !!}
    <label style="{{ isset($image)?'':'display:none' }}" for="image_alt" class="control-label image_alt">{{ trans('content::default.posts.image_alt') }}</label>
    {!! Form::text('image_alt', isset($image) && !Input::old()?$image->pivot->alt:''  , ['class' => 'form-control image_alt', 'style' => isset($image)?'':'display:none']) !!}
    <br>
    <a style="margin-bottom:20px;" href="#" class="btn add_image btn-primary btn-block btn-addon add_button" data-toggle="modal" data-type="images" data-target="#add_image" data-input="some_input">
        @if(isset($image))
            <i class="fa fa-cogs"></i>Change
        @else
            <i class="fa fa-plus"></i>Add Image
        @endif
    </a>
    <a onclick="deleteImageFromPreview($(this))" style="margin-bottom:20px;{{isset($image)?'':'display:none'}}" href="#" class="btn  btn-block btn-danger btn-addon delete_button">
        <i class="fa fa-trash"></i>Delete</a>
    <input type="hidden" name="image_id" id="image_id" value="{{isset($image)?$image->id:''}}">
    <input type="hidden" name="cropped_coords" id="cropped_coords" value="{{isset($cropped_coords)?$cropped_coords:''}}">
</div>
<div class="line line-dashed b-b line-lg"></div>
