/**
 * Created by Ron on 14-5-7.
 */
define(['knockout','knockoutMapping','formPost','message','viewmodel/abstract','validation','validationConfig'], function(ko,koMapping,formPost,message,abstract) {
    return function(){
        abstract.call(this);
        var self = this;
        self.id = ko.observable();
        self.newPassword = ko.observable().extend({
            required:{message: '请输入密码'}
        });
        self.confirm = ko.observable().extend({
            required:{message: '请再次输入密码'},
            areSame: self.newPassword
        });

        self.reset = function(){
            self.newPassword('');
            self.confirm('');
        }

        self.submitAndContinue = function(callback){

            var data = koMapping.toJSON(self);
            formPost.submit({
                viewModel:self,
                url:'/account/reset-password',
                data:{password:data},
                success:function(){
                    self.reset();
                    message.success('保存成功');
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
        self.setDefaultValue();
    }
});

