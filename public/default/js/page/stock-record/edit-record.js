require(['knockout',
        'viewmodel/editStockRecord',
        'viewmodel/stockProduct',
        'module/sku.autocomplete',
        'module/image.uploader',
        'message',
        'module/number',
        'datetimepicker',
        'underscore',
        'lib/json2']
    , function (ko,EditStockRecord, StockProduct,SkuAutoComplete,ImageUploader,message) {
        var stockRecord = new EditStockRecord();
        var stockProduct = new StockProduct(stockRecord);
        stockProduct.itemId = ko.observable();
        //for edit
        stockRecord.editItem = function (product){
            if(!stockProduct.sku()){
                stockRecord.removeItem(product);
                stockProduct.itemId(product.itemId());
                stockProduct.sku(product.sku());
                stockProduct.name(product.name());
                stockProduct.cost(product.cost());
                stockProduct.stock(product.stock());
                var pictures = product.pictures();
                for(var key in pictures){
                    console.log(pictures[key]);
                    stockProduct.pictures.push(pictures[key]);
                }
                stockProduct.price(product.price());
                stockProduct.description(product.description());
            }else{
                message.info('请先保存或清空正在添加的产品')
            }
        }

        $('#startTime').datetimepicker({pickTime: false,language: 'zh-CN'});
        $('#startTime').on('dp.change', function(e){
            stockRecord.stockTime(moment(e.date).format('YYYY-MM-DD'));
        });

        var uploader = new ImageUploader({observableArray:stockProduct.pictures});

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
        $(function(){
            ko.applyBindings(stockProduct,$('#stockProduct').get(0));
            ko.applyBindings(stockRecord,$('#stockRecord').get(0));
            ko.applyBindings(stockRecord,$('#stockRecordSubmit').get(0));
            ko.applyBindings(stockRecord,$('#recordInfo').get(0));
        });
        //form submit
    });
