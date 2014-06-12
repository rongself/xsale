/**
 * Created by Ron on 14-3-1.
 */
define(['knockout','viewmodel/saleProduct','knockoutMapping','formPost','message','cookie','validation','validationConfig'],function(ko,saleProductViewModel,koMapping,formPost,message){
    return function() {
        var self = this;
        self.saleProducts = ko.observableArray(null);
        self.orderTime = ko.observable(moment().format("YYYY-MM-DD")).extend({
            required: { message: '售出日期不能为空' }
        });
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
                $(document).trigger('saleRecord.addItem');
            }else{
                self.saleProducts.remove(exists);
                self.saleProducts.push(product);
            }
        }
        self.removeItem = function (sku){
            self.saleProducts.remove(sku);
        }
        self.reset = function(){
            if(self.saleProducts().length>0){
                self.saleProducts.removeAll();
            }
            self.phoneNumber(null);
            $(document).trigger('saleRecord.reset');
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
            if(!(self!=null&&typeof self.saleProducts() == 'object'&&self.saleProducts().length>0)){
                message.warning('销售记录中还未加入任何产品');
                return false;
            }
            var data = koMapping.toJSON(self);
            formPost.submit({
                viewModel:self,
                url:'/sale-record/create-record',
                data:{saleRecord:data},
                success:function(){
                    self.reset();
                    message.success('销售记录已成功提交');
                    $(document).trigger('saleRecord.submitSuccess');
                    if(typeof callback == 'function'){
                        callback();
                    }
                }
            });
        }
        self.submit = function () {
            self.submitAndContinue(function(){
                location.href = '/sale-record/index';
            });
        }
        self.show = function (elem){
            $(elem).hide().slideDown();
        }
        self.loadCache = function(){
            if($.cookie('saleRecord')!=undefined){
                var cache = koMapping.fromJSON($.cookie('saleRecord'));
                cache.orderTime!=undefined?self.orderTime(cache.orderTime()):'';
                cache.phoneNumber!=undefined?self.phoneNumber(cache.phoneNumber()):'';
                var products = cache.saleProducts();
                for(var key in  products){
                    self.saleProducts.push(products[key]);
                }
                return true;
            }
            return false;
        }
        self.setCache = function(){
            $.removeCookie('saleRecord');
            $.cookie('saleRecord',koMapping.toJSON(self),{expires:2});
        }
        self.clearCache = function(){
            $.removeCookie('saleRecord');
        }
        self.init = function(){
            if(self.loadCache()){
                message.info('已载入上次未保存的数据,清除数据请点击右上角按钮清空已添加产品');
            }
            $(document).on({
                'saleRecord.addItem':function(){
                    self.setCache();
                },
                'saleRecord.submitSuccess':function(){
                    self.clearCache();
                },
                'saleRecord.reset':function(){
                    self.clearCache();
                }
            });
        };
    }
});