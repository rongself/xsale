/**
 * Created by Ron on 14-5-3.
 */
define(['knockout','knockoutMapping','pace','validation','validationConfig'], function(ko,koMapping,pace) {
    return function(){
        var self = this;
        self.name = ko.observable();
        self.phoneNumber = ko.observable().extend({
            required:{message: '客户手机号不能为空'},
            number:{message:'手机号格式不正确'},
            isPhoneNumberExists:self
        });
        self.wechat = ko.observable();
        self.qq = ko.observable();
        self.isVip = ko.observable(false);
        self.remark = ko.observable();

        self.reset = function(){
            self.name('');
            self.phoneNumber('');
            self.wechat('');
            self.qq('');
            self.isVip(false);
            self.remark('');
        }

        self.submitAndContinue = function(callback){
            if(self.phoneNumber.isValidating()){
                $('.submitTo').button('loading');
                setTimeout(function(){
                    self.submitAndContinue(callback);
                },50);
                return false;
            }else{
                $('.submitTo').button('reset');
            }

            var data = koMapping.toJSON(self);
            var model = ko.validatedObservable(self);
            if((model.isValid())){
                $.post('/customer/create-customer',{customer:data},function(result){
                    if(result){
                        alert('添加成功');
                        self.reset();
                        model.errors.showAllMessages(false);
                        if(typeof callback =='function'){
                            callback();
                        }
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