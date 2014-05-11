/**
 * Created by Ron on 14-5-7.
 */
define(['knockout','knockoutMapping','formPost','validation','validationConfig'], function(ko,koMapping,formPost) {
    return function(){
        var self = this;
        self.password = ko.observable().extend({
            required:{message: '请输入原密码'}
        });
        self.newPassword = ko.observable().extend({
            required:{message: '请输入密码'}
        });
        self.confirm = ko.observable().extend({
            required:{message: '请再次输入密码'},
            areSame: self.newPassword
        });

        self.reset = function(){
            self.newPassword('');
            self.password('');
            self.confirm('');
        }

        self.submitAndContinue = function(callback){

            var data = koMapping.toJSON(self);
            formPost.submit({
                viewModel:self,
                url:'/account/change-password',
                data:{password:data},
                success:function(){
                    self.reset();
                    alert('保存成功');
                    if(typeof callback == 'function'){
                        callback();
                    }
                }
            });
        }
        self.submit = function(){
            self.submitAndContinue(function(){
                location.href = '/account/index';
            });
        }
    }
});

