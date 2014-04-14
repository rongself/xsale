require(['knockout',
        'viewmodel/stockRecord',
        'viewmodel/stockProduct',
        'module/sku.autocomplete',
        'underscore',
        'lib/json2',
        'module/image.uploader']
    , function (ko, StockRecordViewModel, StockProductViewModel,SkuAutoComplete) {

        stockRecord = new StockRecordViewModel();
        stockProduct = new StockProductViewModel();

        // ko.applyBindings(stockRecord);

        //set a validation need stockRecord instance
        stockProduct.sku.extend({
            validation: { validator: uniqueInObservableArray, message: '该产品已存在于进货单中', params: stockRecord.stockProducts()}
        });
        var skuAutoComplete = new SkuAutoComplete(function(selectedSKU,products){
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
        });
        //form submit
    });
