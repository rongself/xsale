require(['knockout',
        'viewmodel/stockRecord',
        'viewmodel/stockProduct',
        'module/sku.autocomplete',
        'module/image.uploader',
        'datetimepicker',
        'underscore',
        'lib/json2']
    , function (ko, StockRecordViewModel, StockProductViewModel,SkuAutoComplete,ImageUploader) {
        var stockRecord = new StockRecordViewModel();
        var stockProduct = new StockProductViewModel(stockRecord);

        $('#startTime').datetimepicker({pickTime: false,language: 'zh-CN'});
        $('#startTime').on('dp.change', function(e){
            stockRecord.stockTime(moment(e.date).format('YYYY-MM-DD'));
        });

        var uploader = new ImageUploader({observableArray:stockProduct.pictures});
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
        ko.applyBindings(stockProduct,$('#stockProduct').get(0));
        ko.applyBindings(stockRecord,$('#stockRecord').get(0));
        ko.applyBindings(stockRecord,$('#stockRecordSubmit').get(0));
        ko.applyBindings(stockRecord,$('#recordInfo').get(0));
        //form submit
    });
