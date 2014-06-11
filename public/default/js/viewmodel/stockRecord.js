/**
 * Created by Ron on 14-2-27.
 */
define(['knockout','viewmodel/stockProduct','knockoutMapping','formPost','message','cookie'], function(ko,stockProductViewModel,koMapping,formPost,message) {
    return function() {
        var self = this;
        self.stockProducts = ko.observableArray(null);
        self.stockTime = ko.observable(moment().format("YYYY-MM-DD")).extend({
            required: { message: '售出日期不能为空' }
        });
        self.totalPrice = ko.computed(function() {
            var sum = 0;
            for (var item in self.stockProducts()) {
                sum += parseFloat(self.stockProducts()[item].cost()) * parseInt(self.stockProducts()[item].stock());
            }
            return sum;
        });
        self.loadCache = function(){
            if($.cookie('stockRecord')!=undefined){
                var cache = koMapping.fromJSON($.cookie('stockRecord'));
                if(cache.stockTime!=undefined){
                    self.stockTime(cache.stockTime());
                }
                var products = cache.stockProducts();
                for(var key in  products){
                    self.stockProducts.push(products[key]);
                }
                return true;
            }
            return false;
        }
        self.setCache = function(){
            $.removeCookie('stockRecord');
            $.cookie('stockRecord',koMapping.toJSON(self),{expires:2});
        }
        self.clearCache = function(){
            $.removeCookie('stockRecord');
        }
        self.addItem = function(stockProductInstance) {
            var json = koMapping.toJSON(stockProductInstance);
            var product = koMapping.fromJSON(json);

            var exists = ko.utils.arrayFirst(self.stockProducts(),function(item){
                return item.sku() === stockProductInstance.sku();
            })
            //try to update stock record
            if(!exists){
                self.stockProducts.push(product);
                $(document).trigger('stockRecord.addItem');
            }else{
                self.stockProducts.remove(exists);
                self.stockProducts.push(product);
            }
        }
        self.removeItem = function (sku){
            self.stockProducts.remove(sku)
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
                    $(document).trigger('stockRecord.submitSuccess');
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
            $(document).trigger('stockRecord.reset');
        }
        self.init = function(){
            if(self.loadCache()){
                message.info('已载入上次未保存的数据,清除数据请点击右上角按钮清空已添加产品');
            }
            $(document).on({
                'stockRecord.addItem':function(){
                    self.setCache();
                },
                'stockRecord.submitSuccess':function(){
                    self.clearCache();
                },
                'stockRecord.reset':function(){
                    self.clearCache();
                }
            });
        };
    }
});
