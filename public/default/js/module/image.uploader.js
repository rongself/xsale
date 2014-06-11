/**
 * Created by Ron on 14-3-1.
 */
define(['knockout','lib/jquery.fileupload'],function(ko){
    //for image upload
    return function(options){
        var defaultOptions = {
            observableArray:'',
            url:'/FileUploader/image-uploader'
        };
        options = $.extend(defaultOptions,options);
        var self = this;
        $('[data-file-upload]').fileupload({
            url: options.url,
            dataType: 'json',
            done: function (e, data) {
                if(options.observableArray!=''){
                    $.each(data.files, function (index, file) {
                        options.observableArray.push(file.name);
                    });
                }
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css('width',0).css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');
        $(document).on({
            'mouseenter':function(e){
                $(this).prev().removeClass('dp-none');
                return false;
            }
        },'.product-picture');
        $(document).on({
            'mouseleave':function(e){
                $(this).addClass('dp-none');
                return false;
            }
        },'.del-btn');
    }
});