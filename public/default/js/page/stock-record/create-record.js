require(['knockout',
        'viewmodel/stockRecord',
        'viewmodel/stockProduct',
        'typeahead',
        'underscore',
        'lib/json2',
        'module/image.uploader']
    , function (ko, stockRecordViewModel, stockProductViewModel) {

        stockRecord = new stockRecordViewModel();
        stockProduct = new stockProductViewModel();
        // ko.applyBindings(stockRecord);

        //set a validation need stockRecord instance
        stockProduct.sku.extend({
            validation: { validator: uniqueInObservableArray, message: '该产品已存在于进货单中', params: stockRecord.stockProducts()}
        });
        //for sku autocomplete
        var products = [];
        $('#SKUInput').typeahead({
            source: function (query, process) {
                if(typeof products == 'object' && products.length <= 0){
                    $.getJSON('/Product/get-products-json',function(data){
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
            },
            highlighter: function (selectedSKU) {
                var product = _.find(products, function (item) {
                    return item.sku == selectedSKU;
                });
                return '<img class="pull-left" style="margin-top: 4px;margin-right: 10px;" src="' + PRODUCT_IMAGE_PATH + 'thumbnail/'+(product.picture?product.picture:'default.jpg') + '" alt="" width="40px" height="40px">' +
                    '<div class="pull-left">' +
                        '<div>' + product.sku + '</div>' +
                        '<div style="color:#cccccc">' + product.name + '</div>' +
                    '</div>' +
                    '<div class="clearfix"></div>';
            },
            updater: function (selectedSKU) {
                var product = _.find(products, function (item) {
                    return item.sku == selectedSKU;
                });
                stockProduct.name(product.name);
                stockProduct.cost(product.cost);
                stockProduct.pictures.removeAll();
//                $(product.productImages).each(function(){
//                    stockProduct.pictures.push(this);
//                });
                stockProduct.price(product.price);
                stockProduct.description(product.description);
                $('#quantity').focus();
                return selectedSKU;
            }
        });

        //form submit
    });
