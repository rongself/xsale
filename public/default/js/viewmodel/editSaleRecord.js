/**
 * Created by Administrator on 14-6-10.
 */
define(['knockout','viewmodel/abstract','viewmodel/saleRecord','viewmodel/saleProduct','knockoutMapping','formPost','message','cookie'], function(ko,abstract,saleRecord,saleProduct,koMapping,formPost,message) {
    return function() {
        abstract.call(this);
        saleRecord.call(this);

        var self = this;
        self.id = ko.observable('');
        self.ajaxInit = function(){
            $.getJSON('/sale-record/ajax-get-record',{id:self.id()},function(data){
                self.orderTime(moment(data.orderTime).format('YYYY-MM-DD'));
                if(data.customer){
                    self.phoneNumber(data.customer.phoneNumber);
                    self.customerName(data.customer.name);
                }
                var items = data.orderCarts;
                for(var key in items)
                {
                    var product = new saleProduct(self);
                    product.itemId = ko.observable();
                    product.itemId(items[key].id)
                    product.sku(items[key].product.sku);
                    product.quantity(items[key].quantity);
                    product.price(items[key].product.price);
                    product.remark(items[key].product.remark);
                    self.saleProducts.push(product);
                }
            });
        }

        self.submitAndContinue = function (callback) {
            if(!(self!=null&&typeof self.saleProducts() == 'object'&&self.saleProducts().length>0)){
                message.warning('进货单中还未加入任何产品');
                return false;
            }
            var data = koMapping.toJSON(self);
            formPost.submit({
                viewModel:self,
                url:'/sale-record/edit-record',
                data:{saleRecord:data},
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
