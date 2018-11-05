"use strict";

(function($){
    $(function(){
        var initAssetFileUploadWidget = function () {
            var widget = $(this);
            widget.sidusFileUpload({
                dropZone: widget,
                done: function (e, data) {
                    widget.find('.alert').html('').hide();
                    if (data.result.files && data.result.files[0] && data.result.files[0].error) {
                        var error = data.result.files[0].error;
                        dump(error);
                        if (data._error_messages[error]) {
                            error = data._error_messages[error];
                        }
                        widget.find('.progress').hide();
                        widget.find('.alert').html(error).show();
                        return;
                    }
                    var file = data.result[0];
                    widget.find('input[type="hidden"]').val(file.identifier);
                    widget.find('.help-block').remove();
                    widget.find('.fileupload-file').attr('href', data.result.link);
                    widget.find('.fileupload-img').attr('src', data.result.thumbnailPath);
                    widget.find('.fileupload-file').show();
                    widget.find('.progress').hide();
                },
            });
        };
        $(document).on('global.event', function (e) {
            // override File upload widget for asset
            $(e.target).find('.asset-fileupload-widget').each(initAssetFileUploadWidget);
        });

        $('.asset-fileupload-widget').each(initAssetFileUploadWidget);
    });
})(jQuery);