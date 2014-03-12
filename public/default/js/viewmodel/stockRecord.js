/**
 * Created by Ron on 14-2-27.
 */
define(['knockout','viewmodel/stockProduct'], function(ko,stockProductViewModel) {
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
            var product = new stockProductViewModel();
            product.sku(stockProductInstance.sku());
            product.name(stockProductInstance.name());
            product.cost(stockProductInstance.cost());
            product.stock(stockProductInstance.stock());
            product.picture(stockProductInstance.picture());
            product.price(stockProductInstance.price());
            product.description(stockProductInstance.description());
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
    }
});