/**
 * Created by Ron on 14-5-3.
 */
define(['knockout','knockoutMapping','validation','validationConfig'], function(ko,koMapping) {
    return function(){
        var self = this;
        self.name = ko.observable();
        self.phoneNumber = ko.observable().extend({
            required:{message: '客户手机号不能为空'},
            number:{message:'手机号格式不正确'}
        });
        self.wechat = ko.observable();
        self.qq = ko.observable();
        self.isVip = ko.observable(false);

        self.reset = function(){
            self.name('');
            self.phoneNumber('');
            self.wechat('');
            self.qq('');
            self.isVip(false);
        }

        self.submitAndContinue = function(callback){
            var data = koMapping.toJSON(self);
            console.table(data);
            var model = ko.validatedObservable(self);
            if((model.isValid())){
                $.post('/customer/create-customer',{customer:data},function(result){
                    if(result){
                        alert('添加成功');
                        self.reset();
                        model.errors.showAllMessages(false);
                        callback();
                    }else{
                        alert(result.error[0]);
                    }
                },'json')
                    .fail(function(){
                        alert('Ajax传输错误');
                    });
            }else{
                model.errors.showAllMessages();
            }
        }
        self.submit = function(){
            self.submitAndContinue(function(){
                location.href = '/customer/index';
            });
        }
    }
});