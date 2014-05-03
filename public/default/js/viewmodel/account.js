/**
 * Created by Ron on 14-5-3.
 */
define(['knockout','knockoutMapping','pace','validation','validationConfig'], function(ko,koMapping,pace) {
    return function(){
        var self = this;
        self.name = ko.observable().extend({
            required:{message: '用户姓名不能为空'}
        });;
        self.username = ko.observable().extend({
            required:{message: '登录名不能为空'},
            isUsernameExists:self
        });
        self.password = ko.observable().extend({
            required:{message: '请输入密码'}
        });
        self.confirm = ko.observable().extend({
            required:{message: '请再次输入密码'},
            areSame: self.password
        });

        self.reset = function(){
            self.name('');
            self.username('');
            self.password('');
            self.confirm('');
        }

        self.submitAndContinue = function(callback){
            if(self.username.isValidating()){
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
                $.post('/account/create-account',{account:data},function(result){
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
                location.href = '/account/index';
            });
        }
    }
});
