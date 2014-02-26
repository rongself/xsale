require(['knockout','validation','typeahead','underscore'], function(ko) {
    ko.validation.rules.pattern.message = 'Invalid.';
    ko.validation.configure({
        registerExtenders: true,
        messagesOnModified: true,
        insertMessages: true,
        parseInputAttributes: true,
        messageTemplate: null
    });

    var uniqueInObservableArray = function(val,observableArray) {
        var exists = ko.utils.arrayFirst(observableArray, function(item) {
            return item.sku() === val;
        })
        return exists === null;
    };
    ko.validation.registerExtenders();
    var stockRecordViewModel = function() {
        var self = this;
        self.stockProducts = ko.observableArray(null);
        self.totalPrice = ko.computed(function() {
            var sum = 0;
            for (var item in self.stockProducts()) {
                sum += parseFloat(self.stockProducts()[item].cost()) * parseInt(self.stockProducts()[item].quantity());
            }
            return sum;
        });
        self.addItem = function(stockProductInstance) {
            var product = new stockProductViewModel();
            product.sku(stockProductInstance.sku());
            product.name(stockProductInstance.name());
            product.cost(stockProductInstance.cost());
            product.quantity(stockProductInstance.quantity());
            product.picture(stockProductInstance.picture());
            product.price(stockProductInstance.price());
            product.description(stockProductInstance.description());
            var exists = ko.utils.arrayFirst(self.stockProducts(),function(item){
                return item.sku() === stockProductInstance.sku();
            })
            if(!exists){
                self.stockProducts.push(product);
            }else{
                self.stockProducts.remove(exists);
                self.stockProducts.push(product);
            }
        }
    }
    var stockProductViewModel = function() {
        var self = this;
        self.sku = ko.observable().extend({
            required: { message: '产品款号不能为空' },
            validation: { validator: uniqueInObservableArray, message: '该产品已存在于进货单中', params: stockRecord.stockProducts() }
        });
        self.name = ko.observable();
        self.cost = ko.observable().extend({
            required: { message: '进货价不能为空' },
            number:{message:'进货价必须为数字'}
        });
        self.quantity = ko.observable().extend({
            required: { message: '数量不能为空' },
            number:{message:'数量必须位数字'}
        });
        self.picture = ko.observable();
        self.price = ko.observable().extend({
            number:{message:'零售价必须为数字'}
        });
        self.description = ko.observable();

        self.reset = function(){
            self.sku('');
            self.name('');
            self.cost('');
            self.quantity('');
            self.picture('');
            self.price('');
            self.description('');
        }
        self.submitTo = function(stockRecordInstance){
            var model = ko.validatedObservable(this);
            if((model.isValid())){
                stockRecordInstance.addItem(this);
                self.reset();
                model.errors.showAllMessages(false);
            }else{
                model.errors.showAllMessages();
            }
        }
    }
    stockRecord = new stockRecordViewModel();
    stockProduct = new stockProductViewModel();
    //stockProduct.errors = ko.validation.group(stockProduct);
    ko.applyBindings(stockRecord);

    //for sku autocomplete
    var products = [];
    $('#SKUInput').typeahead({
        source:function(query,process){
            products = [{sku:'#4321',name:'one asda',cost:'233',quantity:'2',picture:'/pic/11',price:'244',description:'this is a product'}];
            var results = _.map(products, function (product) {
                return product.sku;
            });
            process(results);
        },
        highlighter:function(selectedSKU){
            var product = _.find(products,function(item){
                return item.sku = selectedSKU;
            });
            return '<div>'+product.sku+'</div>\
                     <div style="color:#cccccc">'+product.name+'</div>';
        },
        updater:function(selectedSKU){
            var product = _.find(products,function(item){
                return item.sku = selectedSKU;
            });
            stockProduct.name(product.name);
            stockProduct.cost(product.cost);
            stockProduct.picture(product.picture);
            stockProduct.price(product.price);
            stockProduct.description(product.description);
            return selectedSKU;
        }
    });
});
