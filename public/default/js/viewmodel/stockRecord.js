/**
 * Created by Ron on 14-2-27.
 */
define(['knockout','validation','validationConfig','viewmodel/stockProduct'], function(ko,v,vc,stockProductViewModel) {
    return stockRecordViewModel = function() {
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
            //try to update stock record
            if(!exists){
                self.stockProducts.push(product);
            }else{
                self.stockProducts.remove(exists);
                self.stockProducts.push(product);
            }
        }
    }
});
