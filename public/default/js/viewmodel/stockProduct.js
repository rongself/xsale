/**
 * Created by Ron on 14-2-27.
 */
define(['knockout','validation','validationConfig'], function(ko) {
    return function(stockRecord) {
        var self = this;
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
            required: { message: '数量不能为空' },
            number:{message:'数量必须位数字'},
            min:{params:1,message:'数量必须大于1'}
        });
        self.pictures = ko.observableArray();
        self.price = ko.observable().extend({
            number:{message:'零售价必须为数字'}
        });
        self.showProgress = ko.observable(false);
        self.description = ko.observable();

        self.removePicture = function (item){
            self.pictures.remove(item);
        }
        self.reset = function(){
            self.sku('');
            self.name('');
            self.cost('');
            self.stock('');
            self.pictures.removeAll();
            self.price('');
            self.description('');
        }
        self.submitTo = function(){
            var model = ko.validatedObservable(self);
            if((model.isValid())){
                stockRecord.addItem(self);
                self.reset();
                model.errors.showAllMessages(false);
            }else{
                model.errors.showAllMessages();
            }
        }
    }
});