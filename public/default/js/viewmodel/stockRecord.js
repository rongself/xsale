/**
 * Created by Ron on 14-2-27.
 */
define(['knockout','viewmodel/stockProduct','lib/json2','knockoutMapping','formPost','message'], function(ko,stockProductViewModel,JSON,koMapping,formPost,message) {
    return function() {
        var self = this;
        self.stockProducts = ko.observableArray(null);
        self.totalPrice = ko.computed(function() {
            var sum = 0;
            for (var item in self.stockProducts()) {
                sum += parseFloat(self.stockProducts()[item].cost()) * parseInt(self.stockProducts()[item].stock());
            }
            return sum;
        });
        self.addItem = function(stockProductInstance) {
            var json = koMapping.toJSON(stockProductInstance);
            var product = koMapping.fromJSON(json);

            var exists = ko.utils.arrayFirst(self.stockProducts(),function(item){
                return item.sku() === stockProductInstance.sku();
            })
            //try to update stock record
            if(!exists){
                self.stockProducts.push(product);
            }else{
                self.stockProducts.remove(exists);
                self.stockProducts.push(product);
            }
        }
        self.removeItem = function (sku){
            self.stockProducts.remove(function(item) { return item.sku == sku })
        }
        self.clear = function(){
            if(self.stockProducts().length>0){
                self.stockProducts.removeAll();
            }
        }
        self.submitAndContinue = function (callback) {
            if(!(self!=null&&typeof self.stockProducts() == 'object'&&self.stockProducts().length>0)){
                message.warning('进货单中还未加入任何产品');
                return false;
            }
            var data = koMapping.toJSON(self);
            formPost.submit({
                viewModel:self,
                url:'/stock-record/create-record',
                data:{stockRecord:data},
                success:function(){
                    self.reset();
                    message.success('进货单已成功提交');
                    if(typeof callback == 'function'){
                        callback();
                    }
                }
            });
        }
        self.submit = function () {
            self.submitAndContinue(function(){
                location.href = '/stock-record/index';
            });
        }
        self.reset = function () {
            self.clear();
        }
    }
});
