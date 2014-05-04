/**
 * Created by Ron on 14-5-4.
 */
define(['knockout','knockoutMapping','pace','validation','validationConfig'], function(ko,koMapping,pace) {
    return function(){
        var self = this;
        self.username = ko.observable().extend({
            required:{message: '登录名不能为空'}
        });
        self.password = ko.observable().extend({
            required:{message: '请输入密码'}
        });
        self.rememberMe = ko.observable(false);

        self.reset = function(){
            self.username('');
            self.password('');
            self.rememberMe(false);
        }

        self.submitAndContinue = function(callback){
            var data = koMapping.toJSON(self);
            var model = ko.validatedObservable(self);
            if((model.isValid())){
                $.post('/account/login',{login:data},function(result){
                    if(result.success){
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
                location.href = '/index/index';
            });
        }
    }
});
