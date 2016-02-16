<?php
if(isset($image->id))
    $params['image_id'] = $image->id;
?>

<input id="image_upload"  class="hidden" value="{{ (isset($image->id)) ? $image->id : implode ($image_ids,',')}}" autocomplete="off"  />
<div class="modal fade" id="add_image" tabindex="-1" role="dialog" aria-labelledby="Choose file" aria-hidden="true">
    <div class="modal-dialog" style="width: 1280px;">
        <div class="modal-content">
            <iframe id="uploader_frame" src="" width="100%" height="630" ></iframe>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>

<script>
    var multiple = parseInt( {{isset($params['multiple'])?$params['multiple']:0}} );
    var semimultiple = parseInt( {{isset($params['semimultiple']) ? $params['semimultiple'] : null}} );
    var mediaType = "{{ isset($params['mediaType']) ? $params['mediaType'] : '' }}";
    var currFile = '';
    var isChangeAction = '';
    var currImage = '';
    var currImageDiv = '';

    var triggerButton;
    var mediaWidgetOpts = {
        modal: '#add_image',
        widget: '.media-files-widget',
        holder: '.media-files-holder',
        item: '.media-files-item',
        addBtn: '.media-add-item',
        deleteBtn: '.media-delete-item',
        changeClass: 'media-change-item'
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    function save_data (arr, data, path) {
        $('#add_image').modal('hide');

        document.getElementById('uploader_frame').src = '';

        if (mediaType == 'images' || mediaType == 'videos' || true) {
            // var files = $('#image_upload').val().split(',');
            var files = arr;
            var widget = triggerButton.parents(mediaWidgetOpts.widget);

            // send_data('{{@$url}}', files, path);
            var queryParams = {
                items: files
            };
            if (widget.data('type')) {
                queryParams.type = widget.data('type');
            }

            if (widget.data('urlField')) {
                queryParams.urlField = widget.data('urlField');
            }

            $.ajax({
                method: "GET",
                url: '/{{ config('admin.uri') }}/ecommerce/images',
                data: queryParams,
                dataType: 'html',
                success: function (response) {


                    // Изменение
                    if (triggerButton.hasClass(mediaWidgetOpts.changeClass)) {
                        var holder = triggerButton.parents(mediaWidgetOpts.item);
                        holder.after(response);
                        holder.remove();
                    } else {
                        var holder = triggerButton.parents(mediaWidgetOpts.widget)
                                .find(mediaWidgetOpts.holder);
                        holder.append(response);
                        if (!widget.data('multiple')) {
                            widget.find(mediaWidgetOpts.addBtn).hide();
                        }
                    }
                }
            });
        }
    }

    $(document).ready(function(){

        $(document).on('click', '.add_image', function () {
            isChangeAction = $(this).find('i').hasClass('fa-cogs');

            switch( $(this).data('type') ){
                case 'files': mediaType = 'files';
                    break;
                case 'videos': mediaType = 'videos';
                    break;
                default: mediaType = 'images';
                    break;
            }
            if(mediaType == 'files')
                currFile = $(this).next('.hidden_file');
            else{
                mediaType = 'images';
                currImageDiv = $(this).closest('div');
            }
        });

        $('#add_image').on('shown.bs.modal', function(e) {
            triggerButton = $(e.relatedTarget);

            multiple = Number(triggerButton.parents(mediaWidgetOpts.widget).data('multiple'));
            var iframeUrl = '{{ action('\Ibec\Media\Http\Controllers\ManagerController@getFrame') }}';
            var queryParams = [];
            if(mediaType == 'files' || 1) {
                queryParams.push('mediaType='+mediaType);
            } else if(mediaType == 'videos') {
                queryParams.push('mediaType='+mediaType);
            } else {
                mediaType = 'images';
            }

            if (multiple) {
                queryParams.push('multiple=1');
            } else {
                queryParams.push('multiple=0');
            }

            if (queryParams.length) {
                iframeUrl += '?'+queryParams.join('&');
            }

            document.getElementById('uploader_frame').src = iframeUrl;
        }).on('hidden.bs.modal', function(e) {
            var widget = triggerButton.parents(mediaWidgetOpts.widget);
        });

        /**
         * Удаление медиа элемента
         */
        $('body').on('click', mediaWidgetOpts.deleteBtn, function(e) {
            e.preventDefault();
            var el = $(this);
            var target = el.parents(mediaWidgetOpts.item);
            var widget = el.parents(mediaWidgetOpts.widget);
            target.remove();
            if (!widget.data('multiple')) {
                widget.find(mediaWidgetOpts.addBtn).show();
            }
        });
    });
</script>
