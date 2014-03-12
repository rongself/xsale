/**
 * Created by Ron on 14-2-27.
 */
define(['knockout','validation','validationConfig'], function(ko) {
    return function(stockProducts) {
        var self = this;
        self.sku = ko.observable().extend({
            required: { message: '产品款号不能为空' }
        });
        self.name = ko.observable();
        self.cost = ko.observable().extend({
            required: { message: '进货价不能为空' },
            number:{message:'进货价必须为数字'}
        });
        self.stock = ko.observable().extend({
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
            self.stock('');
            self.picture('');
            self.price('');
            self.description('');
        }
        self.submitTo = function(stockRecordInstance){
            var model = ko.validatedObservable(self);
            if((model.isValid())){
                stockRecordInstance.addItem(self);
                self.reset();
                model.errors.showAllMessages(false);
            }else{
                model.errors.showAllMessages();
            }
        }
    }
});