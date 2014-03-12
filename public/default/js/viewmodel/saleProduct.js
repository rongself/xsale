/**
 * Created by Ron on 14-3-4.
 */
define(['knockout','validation','validationConfig'], function(ko) {
    return function(saleProducts) {
        var self = this;
        self.sku = ko.observable().extend({
            required: { message: '产品款号不能为空' },
            validation: { validator: uniqueInObservableArray, message: '该产品已存在于进货单中', params: saleProducts}
        });
        self.quantity = ko.observable().extend({
            required: { message: '数量不能为空' },
            number:{message:'数量必须位数字'}
        });
        self.phoneNumber = ko.observable().extend({
            number:{message:'手机号格式不正确'}
        });
        self.price = ko.observable().extend({
            number:{message:'零售价必须为数字'}
        });
        self.remark = ko.observable();

        self.reset = function(){
            self.sku('');
            self.quantity('');
            self.phoneNumber('');
            self.price('');
            self.remark('');
        }
        self.submitTo = function(saleRecordInstance){
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