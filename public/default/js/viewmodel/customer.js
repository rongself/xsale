/**
 * Created by Ron on 14-5-3.
 */
define(['knockout','knockoutMapping','formPost','message','validation','validationConfig'], function(ko,koMapping,formPost,message) {
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
            formPost.submit({
                viewModel:self,
                url:'/customer/create-customer',
                data:{customer:data},
                success:function(){
                    self.reset();
                    message.success('添加成功');
                    if(typeof callback == 'function'){
                        callback();
                    }
                }
            });
        }
        self.submit = function(){
            self.submitAndContinue(function(){
                location.href = '/customer/index';
            });
        }
    }
});