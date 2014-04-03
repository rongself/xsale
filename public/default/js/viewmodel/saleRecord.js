/**
 * Created by Ron on 14-3-1.
 */
define(['knockout','viewmodel/saleProduct'],function(ko,saleProductViewModel){
    return function() {
        var self = this;
        self.saleProducts = ko.observableArray(null);
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
            product.phoneNumber(saleProductInstance.phoneNumber());
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
                self.saleProducts(null);
            }
        }

        self.submit = function () {
            if(self!=null&&typeof self.stockProducts() == 'object'&&self.stockProducts().length>0){
                var data = koMapping.toJSON(self);
                $.post('/stock-record/create-record',{stockRecord:data},function(result){
                    if(result.success){
                        self.clear();
                        alert('进货单已成功提交');
                    }
                },'json');
            }else{
                alert('进货单中还未加入任何产品');
                return false;
            }
            return true;
        }
        self.submitAndContinue = function () {
            if(self.submit()){
                location.href = '/StockRecord/index';
            }
        }
        self.reset = function () {
            self.clear();
        }
    }
});