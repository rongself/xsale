/**
 * Created by Ron on 14-3-1.
 */
require(['knockout',
      'viewmodel/saleRecord',
      'viewmodel/saleProduct',
      'typeahead',
      'underscore',
      'module/image.uploader']
    ,function(ko,saleRecordViewModel,saleProductViewModel){
        saleRecord = new saleRecordViewModel();
        saleProduct = new saleProductViewModel(saleRecord.saleProducts());
        //ko.applyBindings(saleRecord);

        //for sku autocomplete
        var products = [];
        $('#SKUInput').typeahead({
            source: function (query, process) {
                products = [
                    {sku: '#4322', name: 'one asda one asdaone asda', cost: '233', quantity: '2', picture: '/mac/img/user.jpg', price: '244', description: 'this is a product'},
                    {sku: '#4321', name: 'one asda one asdaone asda', cost: '233', quantity: '2', picture: '/mac/img/user.jpg', price: '244', description: 'this is a product'}
                ];
                var results = _.map(products, function (product) {
                    return product.sku;
                });
                process(results);
            },
            highlighter: function (selectedSKU) {
                var product = _.find(products, function (item) {
                    return item.sku = selectedSKU;
                });
                return '<img class="pull-left" style="margin-top: 4px;margin-right: 10px;" src="' + product.picture + '" alt="" width="40px" height="40px">' +
                    '<div class="pull-right">' +
                    '<div>' + product.sku + '</div>' +
                    '<div style="color:#cccccc">' + product.name + '</div>' +
                    '</div>' +
                    '<div class="clearfix"></div>';
            },
            updater: function (selectedSKU) {
                var product = _.find(products, function (item) {
                    return item.sku = selectedSKU;
                });
                saleProduct.price(product.price);
                $('#quantity').focus();
                return selectedSKU;
            }
        });
});
