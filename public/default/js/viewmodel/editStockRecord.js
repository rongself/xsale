/**
 * Created by Administrator on 14-6-10.
 */
define(['knockout','viewmodel/abstract','viewmodel/stockRecord','viewmodel/stockProduct','knockoutMapping','formPost','message','cookie'], function(ko,abstract,stockRecord,stockProduct,koMapping,formPost,message) {
    return function() {
        abstract.call(this);
        stockRecord.call(this);

        var self = this;
        self.id = ko.observable('');
        self.ajaxInit = function(){
            $.getJSON('/stock-record/ajax-get-record',{id:self.id()},function(data){
                self.stockTime(moment(data.stockTime).format('YYYY-MM-DD'));
                var items = data.stockItems;
                for(var key in items)
                {
                    var product = new stockProduct(self);
                    product.itemId = ko.observable();
                    product.itemId(items[key].id)
                    product.sku(items[key].product.sku);
                    product.name(items[key].product.name);
                    product.cost(items[key].price);
                    product.stock(items[key].quantity);
                    product.price(items[key].product.price);
                    product.description(items[key].product.description);
                    var pictures = items[key].product.productImages;
                    for(var pkey in pictures){
                        product.pictures.push(pictures[pkey].url);
                    }
                    self.stockProducts.push(product);
                }
            });
        }

        self.submitAndContinue = function (callback) {
            if(!(self!=null&&typeof self.stockProducts() == 'object'&&self.stockProducts().length>0)){
                message.warning('进货单中还未加入任何产品');
                return false;
            }
            var data = koMapping.toJSON(self);
            formPost.submit({
                viewModel:self,
                url:'/stock-record/edit-record',
                data:{stockRecord:data},
                success:function(){
                    message.success('进货单已成功提交');
                    if(typeof callback == 'function'){
                        callback();
                    }
                }
            });
        }
        self.setDefaultValue();
        self.ajaxInit();
    }
});
