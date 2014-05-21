/**
 * Created by Administrator on 14-5-13.
 */
define(['knockout','knockoutMapping','formPost','message','validation','validationConfig'], function(ko,koMapping,formPost,message) {
    return function() {
        var self = this;
        self.sku = ko.observable().extend({
            required: { message: '产品款号不能为空' }
        });
        self.name = ko.observable();
        self.cost = ko.observable().extend({
            required: { message: '进货价不能为空' },
            number:{message:'进货价必须为数字'}
        });
        self.stock = ko.observable().extend({
            required: { message: '数量不能为空' },
            number:{message:'数量必须位数字'}
        });
        self.pictures = ko.observableArray();
        self.price = ko.observable().extend({
            number:{message:'零售价必须为数字'}
        });
        self.description = ko.observable();

        self.reset = function(){
            self.sku('');
            self.name('');
            self.cost('');
            self.stock('');
            self.pictures.removeAll();
            self.price('');
            self.description('');
        }
        self.submitAndContinue = function(stockRecordInstance){
            var data = koMapping.toJSON(self);
            formPost.submit({
                viewModel:self,
                url:'/product/edit-product',
                data:{product:data},
                success:function(){
                    message.success('保存成功');
                    if(typeof callback == 'function'){
                        callback();
                    }
                }
            });
        }
        self.init = function(){
            for(protype in self){
                if(ko.isWriteableObservable(self[protype])){
                    var $ele = $('#'+protype);
                    if($ele.length>0){
                        var value = $ele.attr('data-value');
                        if(value!=''){
                            if(value=='true'){
                                value = true;
                            }else if(value=='false'){
                                value = false;
                            }
                            self[protype](value);
                        }
                    }
                }
            }
        }

        self.init();
    }
});