/**
 * Created by Ron on 14-3-1.
 */
define(['knockout','lib/jquery.fileupload'],function(ko){
    //for image upload
    return function(){
        var self = this;
        self.uploadViewModel = {
            showProgress :ko.observable(false)
        }
        self.url ='/FileUploader/image-uploader';
        $('#fileupload').fileupload({
            url: self.url,
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
        ko.applyBindings(self.uploadViewModel);
    }
});