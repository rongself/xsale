require(['knockout',
        'viewmodel/stockRecord',
        'viewmodel/stockProduct',
        'module/sku.autocomplete',
        'module/image.uploader',
        'underscore',
        'lib/json2']
    , function (ko, StockRecordViewModel, StockProductViewModel,SkuAutoComplete,ImageUploader) {

        stockRecord = new StockRecordViewModel();
        stockProduct = new StockProductViewModel();
        uploader = new ImageUploader();

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
