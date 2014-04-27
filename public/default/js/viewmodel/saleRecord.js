/**
 * Created by Ron on 14-3-1.
 */
define(['knockout','viewmodel/saleProduct','lib/json2','knockoutMapping','validation','validationConfig'],function(ko,saleProductViewModel,JSON,koMapping){
    return function() {
        var self = this;
        self.saleProducts = ko.observableArray(null);
        self.phoneNumber = ko.observable().extend({
            number:{message:'手机号格式不正确'}
        });
        self.totalPrice = ko.computed(function() {
            var sum = 0;
            for (var item in self.saleProducts()) {
                sum += parseFloat(self.saleProducts()[item].price()) * parseInt(self.saleProducts()[item].quantity());
            }
            return sum;
        });
        self.addItem = function(saleProductInstance) {
            var product = new saleProductViewModel();
            product.sku(saleProductInstance.sku());
            product.quantity(saleProductInstance.quantity());
            product.price(saleProductInstance.price());
            product.remark(saleProductInstance.remark());
            var exists = ko.utils.arrayFirst(self.saleProducts(),function(item){
                return item.sku() === saleProductInstance.sku();
            })
            //try to update sale record
            if(!exists){
                self.saleProducts.push(product);
            }else{
                self.saleProducts.remove(exists);
                self.saleProducts.push(product);
            }
        }
        self.removeItem = function (sku){
            self.saleProducts.remove(function(item) { return item.sku == sku })
        }
        self.clear = function(){
            if(self.saleProducts().length>0){
                self.saleProducts.removeAll();
            }
            self.phoneNumber(null);
        }

        self.submitAndContinue = function (callback) {
            if(self.phoneNumber.isValidating()){
                $('#submitTo').button('loading');
                setTimeout(function(){
                    self.submit();
                },50);
                return false;
            }else{
                $('#submitTo').button('reset');
            }
            var model = ko.validatedObservable(this);
            if((model.isValid())){
                if(self!=null&&typeof self.saleProducts() == 'object'&&self.saleProducts().length>0){
                    var data = koMapping.toJSON(self);
                    $.post('/sale-record/create-record',{saleRecord:data},function(result){
                        if(result.success){
                            self.clear();
                            alert('销售记录已成功提交');
                            callback();
                        }else{
                            alert(result.error[0])
                        }
                    },'json');
                }else{
                    alert('销售记录中还未加入任何产品');
                    return false;
                }
                model.errors.showAllMessages(false);
                return true;
            }else{
                model.errors.showAllMessages();
                return false;
            }
        }
        self.submit = function () {
            self.submitAndContinue(function(){
                location.href = '/sale-record/index';
            });
        }
        self.reset = function () {
            self.clear();
        }
    }
});