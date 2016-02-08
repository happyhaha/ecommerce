<?php
    if (!isset($statusList)) {
        $statusList = ['1' => 'approved', '0' => 'discarded'];
    }
?>
<div class="">
    <div class="m-b-sm text-md">{{ trans('content::default.posts.moderation') }}</div>
    <div>
        @foreach($statusList as $key => $status)
            <div class="radio">
                <label class="i-checks">
                    {!! Form::radio($name, $key, ($key == $model->status ? true : false)) !!}
                    <i></i>
                    {{ trans('social::default.moderation.'.$status) }}
                </label>
            </div>
        @endforeach
    </div>
</div>
