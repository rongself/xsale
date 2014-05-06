/**
 * Created by Ron on 14-5-4.
 */
define(['knockout','knockoutMapping','formPost','validation','validationConfig'], function(ko,koMapping,formPost) {
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
            formPost.submit({
                viewModel:self,
                url:'/account/login',
                data:{login:data},
                success:function(){
                    if(typeof callback == 'function'){
                        callback();
                    }
                }
            });
        }
        self.submit = function(){
            self.submitAndContinue(function(){
                location.href = '/index/index';
            });
        }
    }
});
