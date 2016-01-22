<div class="form-group">
    <label class="col-sm-2 control-label">
        {{ $label }}
    </label>
    <div class="col-sm-10">
        {!! $input !!}
        @if(isset($hint))
            <div class="text-muted">{{ $hint }}</div>
        @endif
        @if(isset($errors) && $errors)
            <div class="error text-danger">
                @foreach($errors as $error)
                    <div>{{$error}}</div>
                @endforeach
            </div>
        @endif
    </div>
</div>
<div class="line line-dashed b-b line-lg pull-in"></div>
