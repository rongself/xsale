/**
 * Created by Administrator on 14-5-13.
 */
require(['viewmodel/editProduct','knockout','imageUploader'],function(editProduct,ko,ImageUploader){
    var product = new editProduct();
    ko.applyBindings(product);
    var imageUploader = new ImageUploader();
});
