/**
 * Created by Ron on 14-3-1.
 */
require(['knockout','lib/jquery.fileupload'],function(ko){
    //for image upload
    // Change this to the location of your server-side upload handler:
    var uploadViewModel = {
        showProgress :ko.observable(false)
    }
    ko.applyBindings(uploadViewModel);
    var url ='/FileUploader/image-uploader';
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.files, function (index, file) {
                stockProduct.pictures.push(file.name);
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css('width',0).css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');
});