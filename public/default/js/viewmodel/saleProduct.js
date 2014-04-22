/**
 * Created by Ron on 14-3-4.
 */
define(['knockout','validation','validationConfig'], function(ko) {
    return function(saleProducts) {
        var self = this;
        self.sku = ko.observable().extend({
            required: { message: '产品款号不能为空' },
            isProductExists:self
        });
        self.quantity = ko.observable().extend({
            required: { message: '数量不能为空' },
            number:{message:'数量必须位数字'}
        });
        self.price = ko.observable().extend({
            required: { message: '零售价不能为空' },
            number:{message:'零售价必须为数字'}
        });
        self.remark = ko.observable();

        self.reset = function(){
            self.sku('');
            self.quantity('');
            self.price('');
            self.remark('');
        }
        self.submitTo = function(saleRecordInstance){
            if(self.sku.isValidating()){
                $('#submitTo').button('loading');
                setTimeout(function(){
                    self.submitTo(saleRecordInstance);
                },50);
                return false;
            }else{
                $('#submitTo').button('reset');
            }
            var model = ko.validatedObservable(this);
            if((model.isValid())){
                saleRecordInstance.addItem(this);
                self.reset();
                model.errors.showAllMessages(false);
            }else{
                model.errors.showAllMessages();
            }
        }
    }
});
