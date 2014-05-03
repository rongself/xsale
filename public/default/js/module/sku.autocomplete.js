define(['jquery','typeahead','underscore','lib/json2'],function($){
    return function(updaterCallback){
        //for sku autocomplete
        var products = [];
        $('#SKUInput').typeahead({
            items:5,
            source: function (query, process) {
                if(typeof products == 'object' && products.length <= 0){
                    $.getJSON('/Product/get-products-json',{query:query},function(data){
                        products = data;
                        var results = _.map(products, function (product) {
                            return product.sku;
                        });
                        process(results);
                    });
                }else{
                    var results = _.map(products, function (product) {
                        return product.sku;
                    });
                    process(results);
                }
//                $.getJSON('/Product/get-products-json',{query:query},function(data){
//                    products = data;
//                    var results = _.map(products, function (product) {
//                        return product.sku;
//                    });
//                    process(results);
//                });
            },
            highlighter: function (selectedSKU) {
                var product = _.find(products, function (item) {
                    return item.sku == selectedSKU;
                });
                return '<img class="pull-left" style="margin-top: 4px;margin-right: 10px;" src="' +xsaleConfig.thumbnailPath+(product.picture?product.picture:'default.jpg') + '" alt="" width="40px" height="40px">' +
                    '<div class="pull-left">' +
                    '<div>' + product.sku + '</div>' +
                    '<div style="color:#cccccc">' + product.name + '</div>' +
                    '</div>' +
                    '<div class="clearfix"></div>';
            },
            updater: function(selectedItem){
                return updaterCallback(selectedItem,products);
            }
        });
    }
});
