/**
 * Created by Administrator on 14-5-13.
 */
define(['knockout','knockoutMapping','formPost','message','viewmodel/abstract','validation','validationConfig'], function(ko,koMapping,formPost,message,abstract) {
    return function() {
        abstract.call(this);
        var self = this;
        self.id = ko.observable();
        self.sku = ko.observable().extend({
            required: { message: '产品款号不能为空' },
            pattern: {message: '款号只能是字母,数字,_,-,#组合',params: '^[a-z0-9_#-]+$'}
        });
        self.name = ko.observable();
        self.cost = ko.observable().extend({
            required: { message: '进货价不能为空' },
            number:{message:'进货价必须为数字'}
        });
        self.stock = ko.observable().extend({
            required: { message: '库存不能为空' },
            number:{message:'库存必须位数字'},
            min:{params:1,message:'库存必须大于1'}
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
        self.setDefaultValue();
    }
});